<x-app-layout>
    <x-slot name="header">
        {{ isset($siswa) ? 'Edit Siswa' : 'Tambah Siswa' }}
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('siswa') }}" class="inline-flex items-center gap-2 text-primary font-bold text-[13px] hover:underline mb-4">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Kembali ke Daftar Siswa
        </a>
        <h1 class="font-headline text-[28px] font-bold text-on-surface">{{ isset($siswa) ? 'Edit Data Siswa' : 'Tambah Siswa Baru' }}</h1>
        <p class="text-[14px] text-on-surface-variant mt-1">Isi formulir di bawah ini dengan lengkap dan benar.</p>
    </div>

    <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden max-w-2xl">
        <div class="p-5 border-b border-outline-variant bg-surface-container-lowest">
            <h2 class="font-bold text-[16px] text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">person</span>
                Formulir Siswa
            </h2>
        </div>
        
        <form method="POST" action="{{ isset($siswa) ? route('siswa.update', $siswa) : route('siswa.store') }}" class="p-6 space-y-6">
            @csrf
            @isset($siswa)
                @method('PATCH')
            @endisset

            {{-- Nama Lengkap --}}
            <div>
                <label for="nama" class="block text-[13px] font-bold text-on-surface mb-2">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $siswa->nama ?? '') }}" placeholder="Masukkan nama lengkap siswa" required autofocus
                    class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all">
                @error('nama')
                    <p class="mt-2 text-[12px] text-error font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- NIS --}}
                <div>
                    <label for="nis" class="block text-[13px] font-bold text-on-surface mb-2">NIS (Nomor Induk Siswa)</label>
                    <input type="text" id="nis" name="nis" value="{{ old('nis', $siswa->nis ?? '') }}" placeholder="Contoh: 12345678" required
                        class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all">
                    @error('nis')
                        <p class="mt-2 text-[12px] text-error font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NISN --}}
                <div>
                    <label for="nisn" class="block text-[13px] font-bold text-on-surface mb-2">NISN</label>
                    <input type="text" id="nisn" name="nisn" value="{{ old('nisn', $siswa->nisn ?? '') }}" placeholder="Contoh: 2023000001" required
                        class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all">
                    @error('nisn')
                        <p class="mt-2 text-[12px] text-error font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Religion selector --}}
                <div>
                    <label for="agama" class="block text-[13px] font-bold text-on-surface mb-2">Agama</label>
                    <select id="agama" name="agama" required
                        class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all">
                        <option value="">-- Pilih Agama --</option>
                        @php $selectedAgama = old('agama', $siswa->agama ?? ''); @endphp
                        @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                            <option value="{{ $agama }}" @selected($agama === $selectedAgama)>{{ $agama }}</option>
                        @endforeach
                    </select>
                    @error('agama')
                        <p class="mt-2 text-[12px] text-error font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gender selector --}}
                <div>
                    <label for="kelamin" class="block text-[13px] font-bold text-on-surface mb-2">Jenis Kelamin</label>
                    <select id="kelamin" name="kelamin" required
                        class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all">
                        <option value="">-- Pilih --</option>
                        <option value="laki_laki" @selected(old('kelamin', $siswa->kelamin?->value ?? '') === 'laki_laki')>Laki-laki</option>
                        <option value="perempuan" @selected(old('kelamin', $siswa->kelamin?->value ?? '') === 'perempuan')>Perempuan</option>
                    </select>
                    @error('kelamin')
                        <p class="mt-2 text-[12px] text-error font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Rombel / Class selector --}}
            <div>
                <label for="rombel_id" class="block text-[13px] font-bold text-on-surface mb-2">Kelas / Rombel (Opsional)</label>
                <select id="rombel_id" name="rombel_id"
                    class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all">
                    <option value="">-- Pilih kelas --</option>
                    @foreach ($rombels as $rombel)
                        <option value="{{ $rombel->id }}" 
                            @selected(old('rombel_id', isset($siswa) && $siswa->rombelAktif() ? $siswa->rombelAktif()->id : '') == $rombel->id)>
                            {{ $rombel->tingkat }} {{ $rombel->kelas?->nama_kelas ?? '' }}
                        </option>
                    @endforeach
                </select>
                @error('rombel_id')
                    <p class="mt-2 text-[12px] text-error font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit / Cancel --}}
            <div class="pt-4 mt-6 border-t border-outline-variant flex items-center justify-end gap-3">
                <a href="{{ route('siswa') }}" class="px-5 py-2.5 text-[14px] font-bold text-on-surface-variant hover:bg-surface-container-low rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-primary text-white text-[14px] font-bold rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    {{ isset($siswa) ? 'Simpan Perubahan' : 'Simpan Siswa' }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
