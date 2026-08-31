<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Keys map: view-key => DB setting key (with default).
     */
    private array $settingsMap = [
        'school_name'       => ['key' => 'site_title',       'default' => 'Bright Kids'],
        'tagline'           => ['key' => 'site_tagline',     'default' => 'Bimbingan Belajar Membaca & Menulis Anak Usia Dini'],
        'address'           => ['key' => 'address',          'default' => 'Jl. Sidodrajat No. 57 RT. 03 RW. 19, Kel. Muktiharjo Kidul, Kec. Pedurungan, Kota Semarang, Jawa Tengah'],
        'whatsapp'          => ['key' => 'whatsapp_number',  'default' => '082137690701'],
        'email'             => ['key' => 'contact_email',    'default' => ''],
        'registration_fee'  => ['key' => 'registration_fee', 'default' => '50000'],
        'monthly_fee'       => ['key' => 'monthly_fee',      'default' => '150000'],
        'book_fee'          => ['key' => 'book_fee',         'default' => '50000'],
        'hero_heading'      => ['key' => 'hero_heading',     'default' => 'Membangun Fondasi Baca-Tulis Anak yang Kuat'],
        'hero_subheading'   => ['key' => 'hero_subheading',  'default' => ''],
        'about_text'        => ['key' => 'about_text',       'default' => ''],
        'teacher_name'      => ['key' => 'teacher_name',     'default' => 'Barijanti, S.Pd.'],
        'teacher_role'      => ['key' => 'teacher_role',     'default' => 'Guru TK PGRI 105 Semarang'],
        'teacher_title'     => ['key' => 'teacher_title',    'default' => 'Pendampingan Penuh Kasih & Kesabaran'],
        'teacher_bio'       => ['key' => 'teacher_bio',      'default' => 'Pengajar berpengalaman di TK PGRI 105 Semarang dengan pendekatan belajar yang menyenangkan (fun learning), ramah anak, dan tanpa metode mengeja.'],
        'teacher_stat1_val' => ['key' => 'teacher_stat1_val','default' => '10+ thn'],
        'teacher_stat1_lbl' => ['key' => 'teacher_stat1_lbl','default' => 'Pengalaman Mengajar'],
        'teacher_stat2_val' => ['key' => 'teacher_stat2_val','default' => '100%'],
        'teacher_stat2_lbl' => ['key' => 'teacher_stat2_lbl','default' => 'Pendekatan Ramah Anak'],
        'maps_iframe'       => ['key' => 'maps_iframe',      'default' => ''],
        'maps_embed_url'    => ['key' => 'maps_iframe',      'default' => ''],
        'wa_template'       => ['key' => 'wa_template',      'default' => 'Halo, saya ingin konsultasi perihal bimbel Bright Kids.'],
        'teacher_photo'     => ['key' => 'teacher_photo',    'default' => ''],
    ];

    public function index()
    {
        $settings = [];
        foreach ($this->settingsMap as $viewKey => $config) {
            $settings[$viewKey] = Setting::getByKey($config['key'], $config['default']);
        }

        // Midtrans read from config (env)
        $settings['midtrans_server_key']    = config('midtrans.server_key', '');
        $settings['midtrans_client_key']    = config('midtrans.client_key', '');
        $settings['midtrans_is_production'] = config('midtrans.is_production', false);

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'school_name'      => 'required|string|max:255',
            'tagline'          => 'required|string|max:255',
            'whatsapp'         => 'required|string|max:25',
            'address'          => 'required|string',
            'registration_fee' => 'nullable|numeric|min:0',
            'monthly_fee'      => 'required|numeric|min:0',
            'teacher_photo'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'teacher_photo.image' => 'File foto pengajar harus berupa gambar.',
            'teacher_photo.mimes' => 'Format foto harus jpeg, png, jpg, atau webp.',
            'teacher_photo.max'   => 'Ukuran foto maksimal 2 MB.',
        ]);

        // Handle Teacher Photo Upload
        if ($request->hasFile('teacher_photo')) {
            $oldPhoto = Setting::getByKey('teacher_photo');
            if ($oldPhoto && \Illuminate\Support\Facades\Storage::disk('public')->exists($oldPhoto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPhoto);
            }
            $path = $request->file('teacher_photo')->store('teacher', 'public');
            Setting::setKey('teacher_photo', $path);
        } elseif ($request->boolean('remove_teacher_photo')) {
            $oldPhoto = Setting::getByKey('teacher_photo');
            if ($oldPhoto && \Illuminate\Support\Facades\Storage::disk('public')->exists($oldPhoto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPhoto);
            }
            Setting::setKey('teacher_photo', '');
        }

        // Write each view-key back to its DB setting key
        foreach ($this->settingsMap as $viewKey => $config) {
            if ($viewKey === 'teacher_photo') {
                continue; // Handled above
            }
            if ($request->has($viewKey)) {
                Setting::setKey($config['key'], $request->input($viewKey));
            }
        }

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Pengaturan website berhasil diperbarui!');
    }
}
