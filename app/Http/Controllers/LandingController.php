<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Setting;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $schedules = Schedule::orderBy('start_time')->get();

        $settings = [
            'site_title'        => Setting::getByKey('site_title', 'Bright Kids'),
            'site_tagline'      => Setting::getByKey('site_tagline', 'Bimbingan Belajar Membaca & Menulis Anak Usia Dini'),
            'hero_heading'      => Setting::getByKey('hero_heading', 'Belajar Membaca & Menulis Tanpa Mengeja'),
            'hero_subheading'   => Setting::getByKey('hero_subheading', 'Metode belajar menyenangkan, ramah anak, dan terbukti efektif untuk anak usia dini TK hingga SD Kelas 3.'),
            'about_text'        => Setting::getByKey('about_text', 'Bright Kids adalah bimbingan belajar khusus membaca dan menulis tanpa mengeja untuk anak usia dini. Dibimbing langsung oleh Barijanti, S.Pd., pengajar berpengalaman dari TK PGRI 105 Semarang.'),
            'teacher_name'      => Setting::getByKey('teacher_name', 'Barijanti, S.Pd.'),
            'teacher_role'      => Setting::getByKey('teacher_role', 'Guru TK PGRI 105 Semarang'),
            'teacher_title'     => Setting::getByKey('teacher_title', 'Pendampingan Penuh Kasih & Kesabaran'),
            'teacher_bio'       => Setting::getByKey('teacher_bio', 'Pengajar berpengalaman di TK PGRI 105 Semarang dengan pendekatan belajar yang menyenangkan (fun learning), ramah anak, dan tanpa metode mengeja.'),
            'teacher_stat1_val' => Setting::getByKey('teacher_stat1_val', '10+ th'),
            'teacher_stat1_lbl' => Setting::getByKey('teacher_stat1_lbl', 'Pengalaman Mengajar'),
            'teacher_stat2_val' => Setting::getByKey('teacher_stat2_val', '100%'),
            'teacher_stat2_lbl' => Setting::getByKey('teacher_stat2_lbl', 'Pendekatan Ramah Anak'),
            'whatsapp_number'   => Setting::getByKey('whatsapp_number', '082137690701'),
            'contact_email'     => Setting::getByKey('contact_email', ''),
            'address'           => Setting::getByKey('address', 'Jl. Sidodrajat No. 57 RT. 03 RW. 19, Kel. Muktiharjo Kidul, Kec. Pedurungan, Kota Semarang, Jawa Tengah'),
            'maps_iframe'       => Setting::getByKey('maps_iframe', ''),
            'registration_fee'  => Setting::getByKey('registration_fee', '50000'),
            'monthly_fee'       => Setting::getByKey('monthly_fee', '150000'),
            'book_fee'          => Setting::getByKey('book_fee', '0'),
            'wa_template'       => Setting::getByKey('wa_template', 'Halo, saya ingin konsultasi perihal bimbel Bright Kids.'),
            'teacher_photo'     => Setting::getByKey('teacher_photo', ''),
        ];

        return view('public.index', compact('schedules', 'settings'));
    }
}
