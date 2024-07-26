@component('mail::message')
@if(!$massage->parent)
<h1 class="title">{{ $massage->email }}</h1>
@endif
<div class="body-section">
<p>
{!! $massage->massage !!}
</p>
</div>
@endcomponent