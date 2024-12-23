@props(['label', 'value', 'button' => null])
<div class="card">
    <h3>
        {{ $label }}
    </h3>
    <h1>
        {{ $value }}
    </h1>
    @if ($button)
        {!! $button !!}
    @endif
</div>
