<x-app-layout>
    <x-slot name="header">
        Tambah Jurusan
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('kelas') }}" class="inline-flex items-center gap-1.5 text-[13px] font-bold text-on-surface-variant hover:text-primary transition-colors mb-2">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Kembali ke Kelas
        </a>
        <h1 class="font-headline text-[28px] font-bold text-on-surface">Tambah Jurusan</h1>
        <p class="text-[14px] text-on-surface-variant mt-1">Tambahkan program jurusan baru beserta masa belajarnya.</p>
    </div>

    <div class="max-w-2xl">
        <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden">
            {{-- Create department form --}}
            <form method="POST" action="{{ route('jurusan.store') }}" class="p-6">
                @csrf

                {{-- Department name --}}
                <div class="mb-6">
                    <x-input-label for="nama" value="Nama Jurusan" />
                    <x-text-input id="nama" name="nama" type="text"
                        class="mt-1 block w-full"
                        :value="old('nama')"
                        placeholder="Rekayasa Perangkat Lunak"
                        required autofocus />
                    @error('nama')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror
                </div>

                {{-- Study length in years --}}
                <div class="mb-6">
                    <x-input-label for="panjang_tahun_ajaran" value="Lama Masa Belajar (Tahun)" />
                    <x-text-input id="panjang_tahun_ajaran" name="panjang_tahun_ajaran" type="number"
                        class="mt-1 block w-full"
                        :value="old('panjang_tahun_ajaran', 3)"
                        min="1" max="6"
                        required />
                    @error('panjang_tahun_ajaran')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror
                </div>

                {{-- Submit / Cancel --}}
                <div class="pt-4 border-t border-outline-variant flex items-center gap-3">
                    <x-primary-button>Simpan</x-primary-button>
                    <a href="{{ route('kelas') }}">
                        <x-secondary-button type="button">Batal</x-secondary-button>
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
