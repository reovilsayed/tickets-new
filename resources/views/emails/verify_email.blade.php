
@component('mail::message')
<h1 class="title">Welcome</h1>
<div class="body-section">
<p>
{{ $user->name }} <br>
Your account has been successfully created. I'm glad you're here. <br>
Please confirm your email address. <br><br>

</p>

@php $url = route('verify.token',['token'=>$token]); @endphp
@component('mail::button', ['url' => $url, 'color' => 'green'])
Confirm
@endcomponent
</div>
@endcomponent