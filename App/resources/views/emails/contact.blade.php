@component('mail::message')
# New Contact Form Submission

**From:** {{ $data['name'] }}  
**Email:** {{ $data['email'] }}  
**Received:** {{ $receivedAt }}

@component('mail::panel')
{{ $data['message'] }}
@endcomponent

@if($data['newsletter'])
<small>User opted in to newsletter subscriptions</small>
@endif

@component('mail::button', ['url' => 'mailto:'.$data['email']])
Reply to {{ $data['name'] }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent