@component('mail::message')
# We send a file.

Please find out the attached files or you can find the file your account.

@component('mail::button', ['url' =>  url('/') ])
Login Your Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
