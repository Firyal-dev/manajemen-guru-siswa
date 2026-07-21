<x-app-layout>
    <x-slot name="header">
        {{ isset($guru) ? 'Edit Guru' : 'Tambah Guru' }}
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('guru') }}" class="inline-flex items-center gap-2 text-primary font-bold text-[13px] hover:underline mb-4">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Kembali ke Daftar Guru
        </a>
        <h1 class="font-headline text-[28px] font-bold text-on-surface">{{ isset($guru) ? 'Edit Data Guru' : 'Tambah Guru Baru' }}</h1>
        <p class="text-[14px] text-on-surface-variant mt-1">Isi formulir di bawah ini dengan lengkap dan benar.</p>
    </div>

    <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden max-w-2xl">
        <div class="p-5 border-b border-outline-variant bg-surface-container-lowest">
            <h2 class="font-bold text-[16px] text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">person</span>
                Formulir Guru
            </h2>
        </div>
        
        <form method="POST" action="{{ isset($guru) ? route('guru.update', $guru) : route('guru.store') }}" class="p-6 space-y-6" enctype="multipart/form-data">
            @csrf
            @isset($guru)
                @method('PATCH')
            @endisset

            {{-- Photo upload --}}
            <div x-data="{
                    previewUrl: '{{ isset($guru) && $guru->url_foto ? asset('storage/' . $guru->url_foto) : '' }}',
                    fileName: '',
                    status: '{{ isset($guru) && $guru->url_foto ? 'current' : 'idle' }}',
                    previewFile(event) {
                        const file = event.target.files[0];
                        if (! file) {
                            this.fileName = '';
                            this.status = '{{ isset($guru) && $guru->url_foto ? 'current' : 'idle' }}';
                            return;
                        }
                        this.fileName = file.name;
                        this.status = 'loading';

                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.previewUrl = e.target.result;
                        };
                        reader.readAsDataURL(file);

                        setTimeout(() => {
                            this.status = 'ready';
                        }, 700);
                    }
                }">
                <label for="url_foto" class="block text-[13px] font-bold text-on-surface mb-2">Foto Profil (Opsional)</label>

                <template x-if="previewUrl">
                    <div class="mb-3 flex items-center gap-4">
                        <img :src="previewUrl" alt="Preview foto" class="w-16 h-16 rounded-full object-cover border border-outline-variant">
                        <div>
                            <p class="text-[12px] font-semibold text-on-surface">
                                <span x-show="status === 'current'">Foto saat ini</span>
                                <span x-show="status === 'loading'">Memeriksa foto...</span>
                                <span x-show="status === 'ready'">Foto terpilih</span>
                            </p>
                            <p class="text-[12px] text-on-surface-variant" x-text="fileName || '{{ isset($guru) && $guru->url_foto ? basename($guru->url_foto) : 'Belum ada foto' }}'"></p>
                        </div>
                    </div>
                </template>

                <div class="grid gap-2">
                    <label for="url_foto" class="inline-flex items-center justify-center gap-2 w-full max-w-fit px-4 py-2 border border-outline-variant rounded-lg text-[14px] font-semibold text-primary hover:bg-primary-container/10 transition-colors cursor-pointer">
                        <span class="material-symbols-outlined">photo_camera</span>
                        Pilih Foto
                    </label>
                    <p class="text-[12px] text-on-surface-variant">Maksimal JPG/PNG 2MB. Biarkan kosong jika tidak ingin mengganti foto.</p>
                </div>

                <input type="file" name="url_foto" id="url_foto" accept=".jpg,.png" class="sr-only" @change="previewFile($event)" {{ !isset($guru) ? 'required' : '' }}>

                <div class="mt-3 transition-all">
                    <div x-show="status === 'loading'" class="inline-flex items-center gap-2 text-secondary text-[13px]">
                        <span class="inline-block h-4 w-4 animate-spin rounded-full border-2 border-current border-t-transparent"></span>
                        Memindai foto...
                    </div>
                    <div x-show="status === 'ready'" class="inline-flex items-center gap-2 text-success text-[13px]">
                        <span class="material-symbols-outlined">check_circle</span>
                        Foto siap diunggah
                    </div>
                </div>

                @error('url_foto')
                    <p class="mt-2 text-[12px] text-error font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama --}}
            <div>
                <label for="nama" class="block text-[13px] font-bold text-on-surface mb-2">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $guru->nama ?? '') }}" placeholder="Masukkan nama lengkap guru" required autofocus
                    class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all">
                @error('nama')
                    <p class="mt-2 text-[12px] text-error font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- NIP --}}
            <div>
                <label for="nip" class="block text-[13px] font-bold text-on-surface mb-2">NIP</label>
                <input type="text" id="nip" name="nip" value="{{ old('nip', $guru->nip ?? '') }}" placeholder="Contoh: 196504071990031001" required
                    class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all">
                @error('nip')
                    <p class="mt-2 text-[12px] text-error font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Religion selector --}}
                <div>
                    <label for="agama" class="block text-[13px] font-bold text-on-surface mb-2">Agama</label>
                    <select id="agama" name="agama" required
                        class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all">
                        <option value="">-- Pilih Agama --</option>
                        @php $selectedAgama = old('agama', $guru->agama ?? ''); @endphp
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
                        <option value="laki_laki" @selected(old('kelamin', $guru->kelamin->value ?? '') === 'laki_laki')>Laki-laki</option>
                        <option value="perempuan" @selected(old('kelamin', $guru->kelamin->value ?? '') === 'perempuan')>Perempuan</option>
                    </select>
                    @error('kelamin')
                        <p class="mt-2 text-[12px] text-error font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Submit / Cancel --}}
            <div class="pt-4 mt-6 border-t border-outline-variant flex items-center justify-end gap-3">
                <a href="{{ route('guru') }}" class="px-5 py-2.5 text-[14px] font-bold text-on-surface-variant hover:bg-surface-container-low rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-primary text-white text-[14px] font-bold rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    {{ isset($guru) ? 'Simpan Perubahan' : 'Simpan Guru' }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>