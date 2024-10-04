@component('mail::message')
# Verify Your Email

Hello {{ $user->name }},

Thank you for registering! Please click the button below to verify your email address:

@component('mail::button', ['url' => $verificationUrl])
Verify Email Address@Abisiniya
@endcomponent

If you did not create an account, no further action is required.
<br><br>
{{$verificationUrl}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
