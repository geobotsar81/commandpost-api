@component('mail::message')
## {{$message}}

Feel free to contact me via {{$email}}

Thanks,<br>
{{$name}}

{{ config('app.name') }}
@endcomponent