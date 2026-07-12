{{-- Toast notification: auto-dismiss after 3 seconds, green for success / red for error --}}
@if (session('success') || session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition
        class="fixed top-4 right-4 z-50 px-4 py-3 rounded-md shadow-lg text-white {{ session('success') ? 'bg-green-600' : 'bg-red-600' }}">
        {{ session('success') ?? session('error') }}
    </div>
@endif
