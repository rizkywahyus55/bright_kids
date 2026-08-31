@extends('layouts.admin')

@section('title', 'Manajemen Jadwal Sesi')
@section('page-title', 'Manajemen Jadwal Sesi Belajar')
@section('page-subtitle', 'Kelola sesi belajar Senin–Kamis (maksimal 4 murid per sesi, total 12 murid)')

@section('content')

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <!-- Search Form -->
        <form action="{{ route('admin.jadwal.index') }}" method="GET" class="flex gap-2 w-full sm:max-w-xs">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama sesi / hari..." class="flex-1 px-3.5 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-800 text-white text-sm font-bold"><i class="fa-solid fa-magnifying-glass"></i></button>
            @if(request('search')) <a href="{{ route('admin.jadwal.index') }}" class="px-3 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50"><i class="fa-solid fa-xmark"></i></a> @endif
        </form>

        <!-- Tambah Jadwal Button → triggers modal -->
        <button onclick="document.getElementById('modal-add').classList.remove('hidden')" class="flex-shrink-0 flex items-center gap-2 px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold shadow-md shadow-sky-600/20 transition-all">
            <i class="fa-solid fa-plus"></i> Tambah Sesi Jadwal
        </button>
    </div>

    <!-- Schedules Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 bg-slate-50/70">
                        <th class="px-5 py-3.5">No</th>
                        <th class="px-5 py-3.5">Nama Sesi</th>
                        <th class="px-5 py-3.5">Hari</th>
                        <th class="px-5 py-3.5">Jam Sesi</th>
                        <th class="px-5 py-3.5 text-center">Kapasitas</th>
                        <th class="px-5 py-3.5 text-center">Status</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/80">
                    @forelse($schedules as $i => $s)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-4 text-slate-400 text-xs font-bold">{{ $schedules->firstItem() + $i }}</td>
                            <td class="px-5 py-4">
                                <div class="font-bold text-slate-900">{{ $s->session_name }}</div>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $s->day }}</td>
                            <td class="px-5 py-4 font-bold text-sky-700">{{ $s->formatted_time }}</td>
                            <td class="px-5 py-4 text-center text-slate-600">{{ $s->quota }} Murid</td>
                            <td class="px-5 py-4 text-center">
                                @if($s->is_active)
                                    <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">Aktif</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-bold">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Edit Button -->
                                    <button
                                        onclick='openEditModal({{ json_encode($s) }})'
                                        class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-100 flex items-center justify-center transition-colors"
                                        title="Edit Jadwal">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>

                                    <!-- Toggle Status -->
                                    <form action="{{ route('admin.jadwal.toggle', $s->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 rounded-lg {{ $s->is_active ? 'bg-amber-50 text-amber-600 hover:bg-amber-100' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' }} flex items-center justify-center transition-colors" title="{{ $s->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="fa-solid {{ $s->is_active ? 'fa-toggle-off' : 'fa-toggle-on' }} text-sm"></i>
                                        </button>
                                    </form>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.jadwal.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus sesi jadwal ini? Semua data terkait akan terhapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition-colors" title="Hapus">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-400">
                                <i class="fa-solid fa-calendar-xmark text-4xl mb-3 block opacity-30"></i>
                                Belum ada jadwal sesi yang dibuat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-slate-100">{{ $schedules->withQueryString()->links() }}</div>
    </div>

    <!-- ===== Modal: Tambah Jadwal ===== -->
    <div id="modal-add" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-7">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-900">Tambah Sesi Jadwal Baru</h3>
                <button onclick="document.getElementById('modal-add').classList.add('hidden')" class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 flex items-center justify-center"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form action="{{ route('admin.jadwal.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Nama Sesi</label>
                    <input type="text" name="session_name" required placeholder="Contoh: Sesi 1 (Sore)" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Hari</label>
                    <input type="text" name="day" required placeholder="Contoh: Senin – Kamis" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Jam Mulai</label>
                        <input type="time" name="start_time" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Jam Selesai</label>
                        <input type="time" name="end_time" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Kapasitas Maks (Opsional)</label>
                    <input type="number" name="quota" value="4" min="1" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                </div>
                <label class="flex items-center gap-2 text-sm font-semibold text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_active" checked class="rounded border-slate-300 text-sky-600 focus:ring-sky-200">
                    Jadwal Aktif (tampil di landing page & form pendaftaran)
                </label>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('modal-add').classList.add('hidden')" class="flex-1 py-3 rounded-xl border border-slate-200 text-sm font-bold text-slate-700 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="flex-1 py-3 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold shadow-md">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== Modal: Edit Jadwal ===== -->
    <div id="modal-edit" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-7">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-900">Edit Sesi Jadwal</h3>
                <button onclick="document.getElementById('modal-edit').classList.add('hidden')" class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 flex items-center justify-center"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form id="edit-form" action="" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Nama Sesi</label>
                    <input type="text" id="edit-session_name" name="session_name" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Hari</label>
                    <input type="text" id="edit-day" name="day" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Jam Mulai</label>
                        <input type="time" id="edit-start_time" name="start_time" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Jam Selesai</label>
                        <input type="time" id="edit-end_time" name="end_time" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Kapasitas Maks</label>
                    <input type="number" id="edit-quota" name="quota" min="1" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                </div>
                <label class="flex items-center gap-2 text-sm font-semibold text-slate-700 cursor-pointer">
                    <input type="checkbox" id="edit-is_active" name="is_active" class="rounded border-slate-300 text-sky-600">
                    Jadwal Aktif
                </label>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('modal-edit').classList.add('hidden')" class="flex-1 py-3 rounded-xl border border-slate-200 text-sm font-bold text-slate-700 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="flex-1 py-3 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold shadow-md">Perbarui Jadwal</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function openEditModal(schedule) {
        document.getElementById('edit-form').action = '/admin/jadwal/' + schedule.id;
        document.getElementById('edit-session_name').value = schedule.session_name;
        document.getElementById('edit-day').value = schedule.day;
        document.getElementById('edit-start_time').value = schedule.start_time ? schedule.start_time.substring(0,5) : '';
        document.getElementById('edit-end_time').value = schedule.end_time ? schedule.end_time.substring(0,5) : '';
        document.getElementById('edit-quota').value = schedule.quota;
        document.getElementById('edit-is_active').checked = schedule.is_active == 1;
        document.getElementById('modal-edit').classList.remove('hidden');
    }
</script>
@endpush
