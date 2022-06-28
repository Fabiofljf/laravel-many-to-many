@component('mail::message')
# Introduction

Ciao ! Il tuoi post è stato modificato, ricevi quest'email di conferma.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
