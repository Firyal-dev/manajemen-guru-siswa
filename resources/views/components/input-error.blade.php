@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'mt-2 text-[12px] text-error font-medium space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
