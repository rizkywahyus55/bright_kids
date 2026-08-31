<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $schedules = Schedule::query()
            ->when($request->search, fn($q, $s) => $q->where('session_name', 'like', "%{$s}%")->orWhere('day', 'like', "%{$s}%"))
            ->latest()
            ->paginate(15);

        return view('admin.schedules.index', compact('schedules'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'session_name' => 'required|string|max:100',
            'day'          => 'required|string|max:100',
            'start_time'   => 'required',
            'end_time'     => 'required',
            'quota'        => 'nullable|integer|min:1',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        Schedule::create($data);

        return back()->with('success', 'Jadwal sesi berhasil ditambahkan.');
    }

    public function update(Request $request, Schedule $jadwal)
    {
        $data = $request->validate([
            'session_name' => 'required|string|max:100',
            'day'          => 'required|string|max:100',
            'start_time'   => 'required',
            'end_time'     => 'required',
            'quota'        => 'nullable|integer|min:1',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $jadwal->update($data);

        return back()->with('success', 'Jadwal sesi berhasil diperbarui.');
    }

    public function toggleStatus($id)
    {
        $jadwal = $id instanceof Schedule ? $id : Schedule::findOrFail($id);
        $jadwal->update(['is_active' => !$jadwal->is_active]);
        $msg = $jadwal->is_active ? 'Jadwal berhasil diaktifkan.' : 'Jadwal berhasil dinonaktifkan.';
        return back()->with('success', $msg);
    }

    public function destroy(Schedule $jadwal)
    {
        $jadwal->delete();
        return back()->with('success', 'Jadwal sesi berhasil dihapus.');
    }
}
