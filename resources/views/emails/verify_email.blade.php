
@component('mail::message')
<h1 class="title">{{ __('words.welcome') }}</h1>
<div class="body-section">
<p>
{{ $user->name }} <br>
{{ __('words.your_account_has_been_successfully_created') }}.<br>
{{ __('words.pleasr_conmfirm_your_email_address') }} <br><br>

</p>

@php $url = route('verify.token',['token'=>$token]); @endphp
@component('mail::button', ['url' => $url, 'color' => 'green'])
{{ __('words.confirmed') }}
@endcomponent
</div>
@endcomponent