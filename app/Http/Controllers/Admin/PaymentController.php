<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with('registration.student')
            ->when($request->search, function ($q, $s) {
                $q->where('payment_code', 'like', "%{$s}%")
                  ->orWhereHas('registration.student', fn($sq) => $sq->where('full_name', 'like', "%{$s}%"));
            })
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->when($request->method, fn($q, $m) => $q->where('method', $m))
            ->latest()
            ->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        $registrations = \App\Models\Registration::with(['student', 'schedule'])
            ->where('status', '!=', 'ditolak')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.payments.create', compact('registrations'));
    }

    /**
     * Store a manual (cash) payment record for a verified registration.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'amount'          => 'required|numeric|min:1000',
            'payment_type'    => 'required|in:biaya_awal,biaya_bulanan,pendaftaran,spp',
            'spp_month'       => 'required_if:payment_type,biaya_bulanan,spp|nullable|string|max:50',
            'notes'           => 'nullable|string|max:500',
        ]);

        $registration = Registration::findOrFail($validated['registration_id']);

        // Build descriptive notes based on payment type
        if (in_array($validated['payment_type'], ['biaya_awal', 'pendaftaran'])) {
            $notes = 'Biaya Awal Bimbel';
        } else {
            $notes = 'Biaya Bulanan ' . $validated['spp_month'];
        }

        // Append extra notes if provided
        if (!empty($validated['notes'])) {
            $notes .= ' – ' . $validated['notes'];
        }

        Payment::create([
            'registration_id' => $registration->id,
            'payment_code'    => 'PAY-' . Str::upper(Str::random(8)),
            'method'          => 'tunai',
            'amount'          => $validated['amount'],
            'status'          => 'lunas',
            'paid_at'         => Carbon::now(),
            'recorded_by'     => auth()->id(),
            'notes'           => $notes,
        ]);

        return redirect()->route('admin.pembayaran.index')->with('success', 'Pembayaran tunai berhasil dicatat sebagai LUNAS.');
    }

    /**
     * Update payment status (confirm as lunas or mark pending).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:lunas,pending,gagal']);

        $payment = Payment::findOrFail($id);
        $payment->update([
            'status'  => $request->status,
            'paid_at' => $request->status === 'lunas' ? Carbon::now() : null,
        ]);

        $msg = $request->status === 'lunas'
            ? 'Pembayaran berhasil dikonfirmasi sebagai LUNAS.'
            : 'Status pembayaran diperbarui.';

        return back()->with('success', $msg);
    }

    public function confirm($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update([
            'status'  => 'lunas',
            'paid_at' => Carbon::now(),
        ]);

        return back()->with('success', 'Pembayaran #' . $payment->payment_code . ' berhasil dikonfirmasi sebagai LUNAS.');
    }

    /**
     * Display printable payment receipt / kwitansi.
     */
    public function receipt($id)
    {
        $payment = Payment::with([
            'registration.student',
            'registration.parent',
            'registration.schedule',
            'recorder'
        ])->findOrFail($id);

        $settings = [
            'site_title'      => Setting::getByKey('site_title', 'Bright Kids'),
            'site_tagline'    => Setting::getByKey('site_tagline', 'Bimbingan Belajar Membaca & Menulis Anak Usia Dini'),
            'address'         => Setting::getByKey('address', 'Jl. Sidodrajat No. 57 RT. 03 RW. 19, Kel. Muktiharjo Kidul, Kec. Pedurungan, Kota Semarang'),
            'whatsapp_number' => Setting::getByKey('whatsapp_number', '082137690701'),
            'teacher_name'    => Setting::getByKey('teacher_name', 'Barijanti, S.Pd.'),
        ];

        return view('admin.payments.receipt', compact('payment', 'settings'));
    }

    public function destroy($id)
    {
        Payment::findOrFail($id)->delete();
        return back()->with('success', 'Data pembayaran berhasil dihapus.');
    }
}
