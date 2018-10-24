@component('mail::message')
# Introduction

Confirm Email Address

@component('mail::button', ['url' => url('/register/confirm?token=' . $user->confirmation_token) ])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
