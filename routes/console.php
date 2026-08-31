<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('clean:orphans', function () {
    $orphanedStudents = \App\Models\Student::doesntHave('registration')->get();
    $this->info('Found ' . $orphanedStudents->count() . ' orphaned students.');
    foreach ($orphanedStudents as $s) {
        $this->line('Deleting orphaned student: ' . $s->full_name . ' (ID: ' . $s->id . ')');
        $s->attendances()->delete();
        $s->progressReports()->delete();
        $s->delete();
    }

    $orphanedParents = \App\Models\ParentModel::doesntHave('registrations')->get();
    $this->info('Found ' . $orphanedParents->count() . ' orphaned parents.');
    foreach ($orphanedParents as $p) {
        $this->line('Deleting orphaned parent: ' . $p->full_name . ' (ID: ' . $p->id . ')');
        $p->delete();
    }

    $this->info('Done cleaning orphans!');
});

Artisan::command('db:check', function () {
    $this->info('Database Name: ' . config('database.connections.mysql.database'));
    $this->info('Total Payments in DB: ' . \App\Models\Payment::count());
    foreach (\App\Models\Payment::with('registration.student')->get() as $p) {
        $studentName = $p->registration && $p->registration->student ? $p->registration->student->full_name : 'No Student';
        $this->line(" - ID: {$p->id} | Murid: {$studentName} | {$p->notes} | Rp " . number_format($p->amount, 0, ',', '.') . " | Status: {$p->status} | Metode: {$p->method}");
    }
});

