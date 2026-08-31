<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Perkembangan Siswa - {{ $report->student->full_name }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #1e293b;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #0284c7;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 22px;
            color: #0284c7;
            margin: 0 0 4px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            margin: 2px 0;
            color: #64748b;
            font-size: 11px;
        }
        .title-box {
            background-color: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 6px;
            text-align: center;
            padding: 8px;
            margin-bottom: 20px;
        }
        .title-box h2 {
            margin: 0;
            font-size: 14px;
            color: #0369a1;
            text-transform: uppercase;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 6px 8px;
            vertical-align: top;
        }
        .info-table td.label {
            font-weight: bold;
            color: #334155;
            width: 25%;
        }
        .info-table td.colon {
            width: 2%;
        }
        .section-header {
            background-color: #0284c7;
            color: #ffffff;
            font-weight: bold;
            padding: 6px 10px;
            font-size: 12px;
            border-radius: 4px;
            margin-top: 15px;
            margin-bottom: 10px;
        }
        .stage-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 15px;
        }
        .stage-title {
            font-weight: bold;
            color: #0f172a;
            font-size: 13px;
            margin-bottom: 6px;
        }
        ul.mastered-list {
            margin: 4px 0 0 16px;
            padding: 0;
        }
        ul.mastered-list li {
            margin-bottom: 4px;
            color: #1e293b;
        }
        .notes-box {
            background-color: #fffbe6;
            border: 1px solid #ffe58f;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 20px;
            font-style: italic;
            color: #434343;
        }
        .signature-table {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        .signature-space {
            height: 60px;
        }
        .footer {
            position: fixed;
            bottom: 10px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 6px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ $settings['site_title'] }}</h1>
        <p>Bimbingan Belajar Membaca & Menulis Anak Usia Dini (TK Kecil, TK Besar, SD 1–3)</p>
        <p>{{ $settings['address'] }} | WA: {{ $settings['whatsapp_number'] }}</p>
    </div>

    <div class="title-box">
        <h2>Laporan Perkembangan Belajar Siswa</h2>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Nama Siswa</td>
            <td class="colon">:</td>
            <td><strong>{{ $report->student->full_name }}</strong></td>
            <td class="label">Periode Laporan</td>
            <td class="colon">:</td>
            <td><strong>{{ $report->period }}</strong></td>
        </tr>
        <tr>
            <td class="label">Jenjang / Kelas</td>
            <td class="colon">:</td>
            <td>{{ $report->student->class_level_label }}</td>
            <td class="label">Asal Sekolah</td>
            <td class="colon">:</td>
            <td>{{ $report->student->school_origin }}</td>
        </tr>
        <tr>
            <td class="label">Orang Tua / Wali</td>
            <td class="colon">:</td>
            <td>{{ $report->student->registration->parent->full_name ?? '-' }}</td>
            <td class="label">Sesi Belajar</td>
            <td class="colon">:</td>
            <td>{{ $report->student->registration->schedule->session_name ?? '-' }} ({{ $report->student->registration->schedule->formatted_time ?? '' }})</td>
        </tr>
        <tr>
            <td class="label">Rekap Kehadiran</td>
            <td class="colon">:</td>
            <td colspan="4"><span style="color: #0284c7; font-weight: bold;">{{ $report->attendance_summary ?? 'Hadir 100%' }}</span></td>
        </tr>
    </table>

    <div class="section-header">1. Capaian & Tahapan Belajar</div>
    
    <div class="stage-box">
        <div class="stage-title">Tahap Pembelajaran Saat Ini:</div>
        <div style="font-size: 13px; font-weight: bold; color: #0284c7; margin-bottom: 8px;">
            {{ $report->current_stage }}
        </div>

        <div class="stage-title" style="margin-top: 10px;">Tahapan Kurikulum yang Sudah Dikuasai:</div>
        @if(!empty($report->mastered_stages) && is_array($report->mastered_stages))
            <ul class="mastered-list">
                @foreach($report->mastered_stages as $stage)
                    <li>&#10004; {{ $stage }}</li>
                @endforeach
            </ul>
        @else
            <p style="color: #64748b; margin: 4px 0;">Belum ada daftar tahapan yang ditandai.</p>
        @endif
    </div>

    <div class="section-header">2. Catatan Evaluasi & Observasi Pengajar</div>
    <div class="notes-box">
        "{!! nl2br(e($report->teacher_notes)) !!}"
    </div>

    <table class="signature-table">
        <tr>
            <td>
                Mengetahui,<br>
                <strong>Orang Tua / Wali Murid</strong>
                <div class="signature-space"></div>
                ( .................................................... )
            </td>
            <td>
                Semarang, {{ date('d F Y') }}<br>
                <strong>Pengajar / Administrator</strong>
                <div class="signature-space"></div>
                <strong><u>{{ $settings['teacher_name'] }}</u></strong>
            </td>
        </tr>
    </table>

    <div class="footer">
        Dokumen resmi diterbitkan secara otomatis oleh {{ $settings['site_title'] }} Platform — Pra-UKK SMKN 8 Semarang.
    </div>

</body>
</html>
