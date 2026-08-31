<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Schedule;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─────────────────────────────────────────
        // 1. Akun Admin (Ibu Barijanti)
        // ─────────────────────────────────────────
        Admin::updateOrCreate(
            ['email' => 'Barijanti@gmail.com'],
            [
                'name'     => 'Barijanti, S.Pd.',
                'password' => Hash::make('admin123'),
                'phone'    => '082137690701',
            ]
        );

        // ─────────────────────────────────────────
        // 2. Jadwal Belajar (Maks 4 Murid per Sesi, Total Maks 12 Murid di Semua Sesi)
        // ─────────────────────────────────────────
        $schedules = [
            [
                'session_name' => 'Sesi 1 (Sore)',
                'day'          => 'Senin – Kamis',
                'start_time'   => '16:00:00',
                'end_time'     => '17:30:00',
                'quota'        => 4,
                'is_active'    => true,
            ],
            [
                'session_name' => 'Sesi 2 (Malam 1)',
                'day'          => 'Senin – Kamis',
                'start_time'   => '18:00:00',
                'end_time'     => '19:30:00',
                'quota'        => 4,
                'is_active'    => true,
            ],
            [
                'session_name' => 'Sesi 3 (Malam 2)',
                'day'          => 'Senin – Kamis',
                'start_time'   => '19:00:00',
                'end_time'     => '20:30:00',
                'quota'        => 4,
                'is_active'    => true,
            ],
        ];

        foreach ($schedules as $schedule) {
            Schedule::updateOrCreate(
                ['session_name' => $schedule['session_name']],
                $schedule
            );
        }

        // ─────────────────────────────────────────
        // 3. Pengaturan Website
        // ─────────────────────────────────────────
        $settings = [
            'site_title'      => 'Bright Kids',
            'site_tagline'    => 'Bimbingan Belajar Membaca & Menulis Anak Usia Dini',
            'teacher_name'    => 'Barijanti, S.Pd.',
            'teacher_bio'     => 'Pengajar berpengalaman di TK PGRI 105 Semarang dengan pendekatan belajar yang menyenangkan (fun learning), ramah anak, dan tanpa metode mengeja.',
            'whatsapp_number' => '082137690701',
            'address'         => 'Jl. Sidodrajat No. 57 RT. 03 RW. 19, Kel. Muktiharjo Kidul, Kec. Pedurungan, Kota Semarang, Jawa Tengah',
            'maps_embed_url'  => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7920.540756661844!2d110.46086034083419!3d-6.9773913096295175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708cd237c522c7%3A0x3301f2cced2a5fe6!2sJl.%20Sidodrajat%20II%20No.57%2C%20Muktiharjo%20Kidul%2C%20Kec.%20Pedurungan%2C%20Kota%20Semarang%2C%20Jawa%20Tengah%2050197!5e0!3m2!1sid!2sid!4v1786105935926!5m2!1sid!2sid',
            'maps_iframe'     => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7920.540756661844!2d110.46086034083419!3d-6.9773913096295175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708cd237c522c7%3A0x3301f2cced2a5fe6!2sJl.%20Sidodrajat%20II%20No.57%2C%20Muktiharjo%20Kidul%2C%20Kec.%20Pedurungan%2C%20Kota%20Semarang%2C%20Jawa%20Tengah%2050197!5e0!3m2!1sid!2sid" width="100%" height="280" style="border:0; border-radius: 12px;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>',
            'registration_fee' => '50000',
            'monthly_fee'     => '150000',
            'book_fee'        => '0',
            'hero_heading'    => 'Belajar Membaca & Menulis Tanpa Mengeja',
            'hero_subheading' => 'Metode belajar menyenangkan, ramah anak, dan terbukti efektif untuk anak usia dini TK hingga SD Kelas 3.',
            'about_text'      => 'Bright Kids adalah bimbingan belajar khusus membaca dan menulis tanpa mengeja untuk anak usia dini. Dibimbing langsung oleh Barijanti, S.Pd., pengajar berpengalaman dari TK PGRI 105 Semarang.',
            'contact_email'   => '',
            'wa_template'     => 'Halo, saya ingin konsultasi perihal bimbel Bright Kids.',
        ];

        foreach ($settings as $key => $value) {
            Setting::setKey($key, $value);
        }

        // ─────────────────────────────────────────
        // CATATAN: Tidak ada data dummy siswa,
        // pendaftaran, absensi, pembayaran, atau
        // laporan perkembangan. Semua data diisi
        // secara nyata oleh admin Bright Kids.
        // ─────────────────────────────────────────
    }
}
