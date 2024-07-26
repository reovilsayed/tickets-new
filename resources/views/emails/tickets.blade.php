@component('mail::message')
@if( $ticket->subject)
<h1 class="title">{{ $ticket->subject }}</h1>
@else
<h1 class="title">Reply This: {{ $ticket->parent->subject }}</h1>
@endif
<div class="body-section">
<p>
{{ $ticket->massage }}
</p>
</div>
@endcomponent