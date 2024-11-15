@component('mail::message')
# Email Validation

Dear {{ $user->name }},

Thank you for registering with {{ config('app.name') }}. To complete your registration, please click the button below to verify your email address.

@component('mail::button', ['url' => url('verify/' . $user->remember_token)])
Verify Email
@endcomponent

If you did not register on our website, please disregard this email.

Best Regards,<br>
The {{ config('app.name') }} Team
@endcomponent
