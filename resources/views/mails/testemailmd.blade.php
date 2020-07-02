@component('mail::message')
# Benvenuto {{$user->name}}

The body of your message.

@component('mail::button', ['url' => route('login')])
Vai al login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
