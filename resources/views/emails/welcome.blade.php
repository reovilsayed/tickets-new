@component('mail::message')
<h1 class="title" style="background-color: red;">Hi, {{$user->name}}  <br> Never share Your username and password</h1>
<div class="body-section">
<p>
  Email : {{$user->email}}

</p>
<p>

  Password : {{$password}}
</p>

@php $url = route('login'); @endphp
@component('mail::button', ['url' => $url, 'color' => 'green'])
login
@endcomponent
{{ config('app.name') }}
</div>
@endcomponent