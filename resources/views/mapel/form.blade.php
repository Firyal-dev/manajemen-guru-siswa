<x-app-layout>
    <x-slot name="header">
        {{ isset($mapel) ? 'Edit Mapel' : 'Tambah Mapel' }}
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('mapel.index') }}" class="inline-flex items-center gap-2 text-primary font-bold text-[13px] hover:underline mb-4">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Kembali ke Data Mapel
        </a>
        <h1 class="font-headline text-[28px] font-bold text-on-surface">{{ isset($mapel) ? 'Edit Mapel' : 'Tambah Mapel Baru' }}</h1>
        <p class="text-[14px] text-on-surface-variant mt-1">Isi nama mata pelajaran untuk dikelola di sistem.</p>
    </div>

    <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden max-w-2xl">
        <div class="p-5 border-b border-outline-variant bg-surface-container-lowest">
            <h2 class="font-bold text-[16px] text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">book</span>
                Formulir Mapel
            </h2>
        </div>

        <form method="POST" action="{{ isset($mapel) ? route('mapel.update', $mapel) : route('mapel.store') }}" class="p-6 space-y-6">
            @csrf
            @isset($mapel)
                @method('PATCH')
            @endisset

            <div>
                <label for="nama_mapel" class="block text-[13px] font-bold text-on-surface mb-2">Nama Mapel</label>
                <input type="text" id="nama_mapel" name="nama_mapel" value="{{ old('nama_mapel', $mapel->nama_mapel ?? '') }}" placeholder="Contoh: Matematika, Bahasa Indonesia"
                    class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all" required>
                @error('nama_mapel')
                    <p class="mt-2 text-[12px] text-error font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 mt-6 border-t border-outline-variant flex items-center justify-end gap-3">
                <a href="{{ route('mapel.index') }}" class="px-5 py-2.5 text-[14px] font-bold text-on-surface-variant hover:bg-surface-container-low rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-primary text-white text-[14px] font-bold rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    {{ isset($mapel) ? 'Simpan Perubahan' : 'Simpan Mapel' }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
