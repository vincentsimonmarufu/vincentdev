@component('mail::message')
# Newsletter

{{$message}}

@component('mail::button', ['url' => 'https://abisiniya.com'])
Visit us
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
