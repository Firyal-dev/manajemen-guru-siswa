<x-app-layout>
    <x-slot name="header">
        Manajemen Token API
    </x-slot>

    <div class="mb-6">
        <h1 class="font-headline text-[28px] font-bold text-on-surface">Manajemen Token API</h1>
        <p class="text-[14px] text-on-surface-variant mt-1">Buat dan kelola token akses API untuk integrasi aplikasi eksternal.</p>
    </div>

    {{-- Alert: Token Baru Dibuat --}}
    @if (session('new_token'))
        <div class="mb-6 rounded-xl border border-amber-300 bg-amber-50 overflow-hidden">
            <div class="p-4 flex items-start gap-3">
                <div class="w-9 h-9 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-[20px]">verified_user</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[14px] font-bold text-amber-800">Token Berhasil Dibuat!</p>
                    <p class="text-[13px] text-amber-700 mt-0.5">Simpan token di bawah ini sekarang. <strong>Token ini hanya ditampilkan satu kali dan tidak dapat dilihat lagi.</strong></p>

                    <div class="mt-3 flex items-center gap-2">
                        <code id="new-token-value" class="flex-1 min-w-0 block bg-white border border-amber-200 rounded-lg px-3 py-2.5 text-[13px] text-on-surface font-mono truncate select-all">{{ session('new_token') }}</code>
                        <button type="button" onclick="copyNewToken()" id="copy-token-btn"
                            class="flex-shrink-0 inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-amber-600 text-white text-[13px] font-bold rounded-lg hover:bg-amber-700 transition-colors">
                            <span class="material-symbols-outlined text-[18px]">content_copy</span>
                            Salin
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 text-secondary rounded-xl border border-green-200 flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            <p class="text-[14px] font-bold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        {{-- Kolom Kiri: Form Buat Token --}}
        <div class="lg:col-span-1">
            <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden">
                <div class="p-5 border-b border-outline-variant bg-surface-container-lowest">
                    <h2 class="font-bold text-[16px] text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">key</span>
                        Buat Token Baru
                    </h2>
                </div>
                <form action="{{ route('tokens.store') }}" method="POST" class="p-5 space-y-4">
                    @csrf
                    <div>
                        <label for="token_name" class="block text-[13px] font-bold text-on-surface mb-2">Nama Token</label>
                        <input type="text" id="token_name" name="token_name" placeholder="Misal: Aplikasi Rapor" required
                            class="w-full bg-surface-container-lowest border {{ $errors->has('token_name') ? 'border-error' : 'border-outline-variant' }} text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all">
                        @error('token_name')
                            <p class="mt-2 text-[12px] text-error font-medium">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-[12px] text-on-surface-variant">Gunakan nama yang jelas agar mudah diidentifikasi, contoh: nama aplikasi yang akan mengakses API.</p>
                    </div>
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-primary text-white text-[14px] font-bold rounded-lg hover:bg-primary/90 transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[20px]">add_circle</span>
                        Generate Token
                    </button>
                </form>
            </div>
        </div>

        {{-- Kolom Kanan: Daftar Token --}}
        <div class="lg:col-span-2">
            <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden">
                <div class="p-5 border-b border-outline-variant bg-surface-container-lowest flex items-center justify-between">
                    <h2 class="font-bold text-[16px] text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">list_alt</span>
                        Daftar Token Aktif
                    </h2>
                    <span class="text-[12px] font-bold text-on-surface-variant bg-surface-container px-2.5 py-1 rounded-full">{{ $tokens->count() }} token</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low border-b border-outline-variant">
                                <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider">Nama Token</th>
                                <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider">Dibuat Pada</th>
                                <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider">Terakhir Digunakan</th>
                                <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/50">
                            @forelse ($tokens as $token)
                                <tr class="hover:bg-surface-container-highest transition-colors">
                                    <td class="py-4 px-5">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-lg bg-primary-container/20 text-primary flex items-center justify-center flex-shrink-0">
                                                <span class="material-symbols-outlined text-[18px]">vpn_key</span>
                                            </div>
                                            <span class="text-[14px] text-on-surface font-semibold">{{ $token->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-5 text-[13px] text-on-surface-variant">{{ $token->created_at->format('d M Y, H:i') }}</td>
                                    <td class="py-4 px-5">
                                        @if ($token->last_used_at)
                                            <span class="text-[13px] text-on-surface-variant">{{ \Carbon\Carbon::parse($token->last_used_at)->diffForHumans() }}</span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-surface-container text-on-surface-variant border border-outline-variant">
                                                Belum pernah digunakan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-5 text-right">
                                        <button type="button" onclick="confirmDelete('delete-token-form-{{ $token->id }}', '{{ addslashes($token->name) }}')" class="inline-flex items-center gap-2 px-3 py-2 bg-error-container/10 text-error text-[13px] font-semibold rounded-lg border border-error-container hover:bg-error-container/20 transition-colors">
                                            <span class="material-symbols-outlined text-[18px]">block</span>
                                            Revoke
                                        </button>
                                        <form id="delete-token-form-{{ $token->id }}" method="POST" action="{{ route('tokens.destroy', $token->id) }}" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[48px] opacity-20 mb-2">key_off</span>
                                        <p class="text-[14px] font-medium">Belum ada token yang dibuat.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function copyNewToken() {
                const el = document.getElementById('new-token-value');
                const btn = document.getElementById('copy-token-btn');
                if (!el) return;
                navigator.clipboard.writeText(el.textContent.trim()).then(() => {
                    const original = btn.innerHTML;
                    btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">check</span> Tersalin';
                    setTimeout(() => { btn.innerHTML = original; }, 2000);
                });
            }
        </script>
    @endpush
</x-app-layout>
