@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xs font-bold text-gray-700 uppercase tracking-widest mb-1']) }}>
    {{ $value ?? $slot }}
</label>
