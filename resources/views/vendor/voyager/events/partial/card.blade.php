@props(['label', 'value', 'button' => null])
<div class="card" title="{{ $label }}">
    <h3>
        {{ Str::limit($label, 15) }}
    </h3>
    <h1>
        {{ $value }}
    </h1>
    @if ($button)
        {!! $button !!}
    @endif
</div>
