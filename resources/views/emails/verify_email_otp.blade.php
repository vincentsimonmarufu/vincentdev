@component('mail::message')
# OTP for Email Verification

Hello {{ $user->name }},

Thank you for registering! Please use below otp to verify email address:

<br><br>
OTP for new user registartion is {{$otp}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent