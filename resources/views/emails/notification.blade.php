@component('mail::message')
<h1 class="title">{{ $data->title }}</h1>
<div class="body-section">
<p>
{!! $data->body !!}
</p>
</div>
@endcomponent