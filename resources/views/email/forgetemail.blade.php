@component('mail::message')
# Forgot Password

Dear {{ $user->name }},

You are receiving this email because a password reset request has been made for your account.

To reset your password, please click the button below:

@component('mail::button', ['url' => url('reset/' . $user->remember_token)])
Reset Password
@endcomponent

If you did not request a password reset, you can safely ignore this email. If you have any questions or need further assistance, please contact our support team.

Best Regards,<br>
The {{ config('app.name') }} Team
@endcomponent
