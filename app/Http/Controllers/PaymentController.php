<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Registration;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function getSnapToken(Request $request, $code)
    {
        $registration = Registration::with(['student', 'parent', 'schedule', 'payments'])
            ->where('registration_code', $code)
            ->firstOrFail();

        $paymentType = $request->input('payment_type'); // 'biaya_awal' or 'biaya_bulanan'
        $month = $request->input('month');

        if ($paymentType === 'biaya_bulanan' && $month) {
            $notes = 'Biaya Bulanan ' . $month;
            $payment = Payment::where('registration_id', $registration->id)
                ->where('notes', $notes)
                ->where('status', 'pending')
                ->first();

            if (!$payment) {
                $monthlyFee = (float) Setting::getByKey('monthly_fee', '150000');
                $payment = Payment::create([
                    'registration_id' => $registration->id,
                    'payment_code'    => 'PAY-' . strtoupper(Str::random(8)),
                    'method'          => 'online',
                    'amount'          => $monthlyFee,
                    'status'          => 'pending',
                    'notes'           => $notes,
                ]);
            }
        } else {
            $payment = $registration->payments()->where('status', 'pending')->latest()->first();
            if (!$payment) {
                $payment = Payment::create([
                    'registration_id' => $registration->id,
                    'payment_code'    => 'PAY-' . strtoupper(Str::random(8)),
                    'method'          => 'online',
                    'amount'          => (float) Setting::getByKey('registration_fee', '50000'),
                    'status'          => 'pending',
                    'notes'           => 'Biaya Awal Bimbel',
                ]);
            }
        }

        // Configure Midtrans
        $serverKey = Setting::getByKey('midtrans_server_key', config('midtrans.server_key'));
        $isProduction = filter_var(Setting::getByKey('midtrans_is_production', config('midtrans.is_production')), FILTER_VALIDATE_BOOLEAN);

        \Midtrans\Config::$serverKey = $serverKey;
        \Midtrans\Config::$isProduction = $isProduction;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $orderId = 'BRIGHT-' . $registration->registration_code . '-' . $payment->id . '-' . time();
        $payment->update([
            'method'            => 'online',
            'midtrans_order_id' => $orderId,
        ]);

        $itemName = ($payment->notes ?? 'Biaya Bimbingan') . ' - ' . $registration->student->full_name;
        if (mb_strlen($itemName) > 50) {
            $itemName = mb_substr($itemName, 0, 47) . '...';
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $payment->amount,
            ],
            'customer_details' => [
                'first_name' => $registration->parent->full_name,
                'phone'      => $registration->parent->whatsapp_number,
            ],
            'item_details' => [
                [
                    'id'       => 'ITEM-' . $payment->id,
                    'price'    => (int) $payment->amount,
                    'quantity' => 1,
                    'name'     => $itemName,
                ]
            ]
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
                'order_id' => $orderId,
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Exception: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghubungkan ke Midtrans Gateway: ' . $e->getMessage() . '. Silakan coba metode Bayar Tunai Manual.',
            ], 500);
        }
    }

    public function handleNotification(Request $request)
    {
        $serverKey = Setting::getByKey('midtrans_server_key', config('midtrans.server_key'));
        \Midtrans\Config::$serverKey = $serverKey;
        \Midtrans\Config::$isProduction = filter_var(Setting::getByKey('midtrans_is_production', config('midtrans.is_production')), FILTER_VALIDATE_BOOLEAN);

        try {
            $notif = new \Midtrans\Notification();
            $transactionStatus = $notif->transaction_status;
            $orderId = $notif->order_id;
            $transactionId = $notif->transaction_id;
            $statusCode = $notif->status_code;
            $grossAmount = $notif->gross_amount;
            $signatureKey = $notif->signature_key;

            // Verify signature key
            $mySignature = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);
            if ($signatureKey !== $mySignature) {
                return response()->json(['status' => 'error', 'message' => 'Invalid signature key'], 403);
            }

            $payment = Payment::where('midtrans_order_id', $orderId)->first();
            if ($payment) {
                $payment->midtrans_transaction_id = $transactionId;

                if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                    $payment->status = 'lunas';
                    $payment->paid_at = now();
                    $payment->registration->update(['status' => 'terverifikasi']);
                } else if ($transactionStatus == 'pending') {
                    $payment->status = 'pending';
                } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                    $payment->status = 'kedaluwarsa';
                }

                $payment->save();
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
