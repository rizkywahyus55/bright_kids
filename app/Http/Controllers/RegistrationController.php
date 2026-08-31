<?php

namespace App\Http\Controllers;

use App\Models\ParentModel;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\Schedule;
use App\Models\Setting;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'class_level' => 'required|in:tk_kecil,tk_besar,sd_1,sd_2,sd_3',
            'school_origin' => 'required|string|max:255',
            'parent_name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'address' => 'required|string',
            'schedule_id' => [
                'required',
                \Illuminate\Validation\Rule::exists('schedules', 'id')->where('is_active', true)
            ],
        ], [
            'full_name.required' => 'Nama lengkap anak wajib diisi.',
            'date_of_birth.required' => 'Tanggal lahir anak wajib diisi.',
            'class_level.required' => 'Jenjang / kelas wajib dipilih.',
            'school_origin.required' => 'Asal sekolah wajib diisi.',
            'parent_name.required' => 'Nama orang tua/wali wajib diisi.',
            'whatsapp_number.required' => 'Nomor WhatsApp wajib diisi.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'schedule_id.required' => 'Pilihan jadwal sesi wajib dipilih.',
            'schedule_id.exists'   => 'Jadwal sesi yang dipilih sedang tidak aktif atau tidak ditemukan.',
        ]);

        // Create Student
        $student = Student::create([
            'full_name' => $request->full_name,
            'date_of_birth' => $request->date_of_birth,
            'class_level' => $request->class_level,
            'school_origin' => $request->school_origin,
            'status' => 'aktif',
        ]);

        // Create Parent
        $parent = ParentModel::create([
            'full_name' => $request->parent_name,
            'whatsapp_number' => $request->whatsapp_number,
            'address' => $request->address,
        ]);

        // Generate Registration Code
        $year = date('Y');
        $count = Registration::whereYear('created_at', $year)->count() + 1;
        $code = 'BK-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        // Create Registration
        $registration = Registration::create([
            'registration_code' => $code,
            'student_id' => $student->id,
            'parent_id' => $parent->id,
            'schedule_id' => $request->schedule_id,
            'status' => 'menunggu_verifikasi',
            'registered_at' => now(),
        ]);

        // Initial Payment record
        $initialFee = Setting::getByKey('registration_fee', '50000');
        Payment::create([
            'registration_id' => $registration->id,
            'payment_code' => 'PAY-' . Str::upper(Str::random(8)),
            'method' => 'tunai',
            'amount' => (float) $initialFee,
            'status' => 'pending',
            'notes' => 'Biaya Awal Bimbel',
        ]);

        return redirect()->route('pendaftaran.status', ['code' => $code])
            ->with('success', 'Pendaftaran berhasil dikirim! Silakan catat Kode Pendaftaran Anda.');
    }

    public function status(Request $request, $code = null)
    {
        $searchCode = $code ?? $request->query('query');
        $registration = null;

        if ($searchCode) {
            $registration = Registration::with(['student', 'parent', 'schedule', 'payments'])
                ->where('registration_code', trim($searchCode))
                ->orWhereHas('parent', function($q) use ($searchCode) {
                    $q->where('whatsapp_number', trim($searchCode));
                })
                ->orWhereHas('student', function($q) use ($searchCode) {
                    $q->where('full_name', 'like', '%' . trim($searchCode) . '%');
                })
                ->latest()
                ->first();
        }

        $settings = [
            'address' => Setting::getByKey('address', 'Jl. Pedurungan Kidul No. 105, Semarang'),
            'whatsapp_number' => Setting::getByKey('whatsapp_number', '081234567890'),
            'maps_iframe' => Setting::getByKey('maps_iframe', ''),
            'midtrans_client_key' => Setting::getByKey('midtrans_client_key', config('midtrans.client_key', '')),
            'midtrans_is_production' => Setting::getByKey('midtrans_is_production', config('midtrans.is_production') ? '1' : '0'),
        ];

        return view('public.status', compact('registration', 'searchCode', 'settings'));
    }
}
