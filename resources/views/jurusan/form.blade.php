<x-app-layout>
    <x-slot name="header">
        {{ isset($jurusan) ? 'Edit Jurusan' : 'Tambah Jurusan' }}
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('jurusan.index') }}" class="inline-flex items-center gap-2 text-primary font-bold text-[13px] hover:underline mb-4">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Kembali ke Data Jurusan
        </a>
        <h1 class="font-headline text-[28px] font-bold text-on-surface">{{ isset($jurusan) ? 'Edit Jurusan' : 'Tambah Jurusan Baru' }}</h1>
        <p class="text-[14px] text-on-surface-variant mt-1">Isi nama jurusan dan lama masa belajar (dalam tahun).</p>
    </div>

    <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden max-w-2xl">
        <div class="p-5 border-b border-outline-variant bg-surface-container-lowest">
            <h2 class="font-bold text-[16px] text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">school</span>
                Formulir Jurusan
            </h2>
        </div>

        <form method="POST" action="{{ isset($jurusan) ? route('jurusan.update', $jurusan) : route('jurusan.store') }}" class="p-6 space-y-6">
            @csrf
            @isset($jurusan)
                @method('PATCH')
            @endisset

            <div>
                <label for="nama" class="block text-[13px] font-bold text-on-surface mb-2">Nama Jurusan</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $jurusan->nama ?? '') }}" placeholder="Contoh: Pengembangan Perangkat Lunak dan Gim" maxlength="255"
                    class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all" required>
                @error('nama')
                    <p class="mt-2 text-[12px] text-error font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="panjang_tahun_ajaran" class="block text-[13px] font-bold text-on-surface mb-2">Lama Masa Belajar (Tahun)</label>
                <input type="number" id="panjang_tahun_ajaran" name="panjang_tahun_ajaran" value="{{ old('panjang_tahun_ajaran', $jurusan->panjang_tahun_ajaran ?? 3) }}" min="1" max="6"
                    class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all" required>
                <p class="mt-1.5 text-[12px] text-on-surface-variant">Jumlah tahun tempuh, mis. 3 atau 4 tahun.</p>
                @error('panjang_tahun_ajaran')
                    <p class="mt-2 text-[12px] text-error font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 mt-6 border-t border-outline-variant flex items-center justify-end gap-3">
                <a href="{{ route('jurusan.index') }}" class="px-5 py-2.5 text-[14px] font-bold text-on-surface-variant hover:bg-surface-container-low rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-primary text-white text-[14px] font-bold rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    {{ isset($jurusan) ? 'Simpan Perubahan' : 'Simpan Jurusan' }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
