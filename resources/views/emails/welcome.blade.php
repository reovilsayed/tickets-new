@component('mail::message')
<h1 class="title" style="background-color: red;">Hi, {{$user->name}}  <br> {{ __('words.never_share_your_username_and_password') }}</h1>
<div class="body-section">
<p>
  {{ __('words.email') }}: {{$user->email}}

</p>
<p>

  {{ __('words.password') }} : {{$password}}
</p>

@php $url = route('login'); @endphp
@component('mail::button', ['url' => $url, 'color' => 'green'])
{{ __('words.login') }}
@endcomponent
{{ config('app.name') }}
</div>
@endcomponent