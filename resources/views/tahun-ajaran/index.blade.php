<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Tahun Ajaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between items-center border-b border-gray-200 dark:border-gray-700">
                    <div>
                        <h3 class="text-lg font-medium">Daftar Tahun Ajaran</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Kelola data tahun ajaran dan set status aktif untuk digunakan di seluruh sistem.
                        </p>
                    </div>
                    <div>
                        <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'buat-tahun-ajaran')">
                            + Buat Tahun Ajaran
                        </x-primary-button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">Tahun Ajaran</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Dibuat Pada</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @forelse($tahunAjarans as $ta)
                                <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <p class="font-semibold">{{ $ta->tahun_mulai }} / {{ $ta->tahun_selesai }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($ta->aktif)
                                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-100">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $ta->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            @if(!$ta->aktif)
                                                <form action="{{ route('tahun-ajaran.active', $ta->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">
                                                        Set Aktif
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada data tahun ajaran.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Create academic year modal --}}
    @include('tahun-ajaran.create')
</x-app-layout>
