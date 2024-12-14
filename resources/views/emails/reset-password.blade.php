{{-- <x-mail::message>
# Introduction

The body of your message.ff

<x-mail::button :url="''">
Button Text
</x-mail::button>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}


{{-- <x-mail::message>
# Reset Your Password

Hello, **{{ $user->name }}**!

We received a request to reset your password. If you made this request, click the button below to proceed:

<x-mail::button :url="$resetLink">
Reset Password
</x-mail::button>

If you did not request a password reset, you can safely ignore this email.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}



{{-- <x-mail::message>
# Reset Your Password

Hi **{{ $user->name }}**,

We received a request to reset your password. Don’t worry, we’ve got you covered! Click the button below to create a new password:

<x-mail::button :url="$resetLink" color="primary">
Reset My Password
</x-mail::button>

---

If you didn’t request a password reset, no action is required. However, we recommend keeping your account secure and contacting support if you suspect any issues.

Need help? Feel free to [contact us](mailto:support@{{ config('app.name') }}).

Thanks,
**The {{ config('app.name') }} Team**

<x-mail::subcopy>
If the button above doesn't work, copy and paste this URL into your browser:
{{ $resetLink }}
</x-mail::subcopy>
</x-mail::message> --}}



{{-- <x-mail::message>
<x-slot:header>
    <div style="text-align: center; background-color: #f3f4f6; padding: 20px; border-bottom: 2px solid #e5e7eb;">
        <h1 style="color: #1f2937; font-family: Arial, sans-serif; font-size: 28px; margin: 0;">{{ config('app.name') }}</h1>
        <p style="color: #6b7280; margin: 5px 0;">Your Trusted Platform</p>
    </div>
</x-slot:header>

<div style="text-align: center; padding: 20px;">
    <h2 style="color: #374151; font-family: Arial, sans-serif;">Reset Your Password</h2>
    <p style="color: #4b5563; font-size: 16px; line-height: 1.5;">
        Hello <strong>{{ $user->name }}</strong>,
        We received a request to reset your password. Don’t worry—we’re here to help!
    </p>
    <x-mail::button :url="$resetLink" color="primary" style="font-size: 18px; padding: 12px 24px; text-transform: uppercase;">
        Reset Password
    </x-mail::button>
    <p style="color: #4b5563; margin-top: 20px; font-size: 14px;">
        If you didn’t request this, you can safely ignore this email. If you need help, please contact us.
    </p>
</div>

<x-slot:footer>
    <div style="text-align: center; background-color: #f3f4f6; padding: 20px; border-top: 2px solid #e5e7eb; font-size: 14px;">
        <p style="color: #6b7280; margin: 5px 0;">
            © {{ now()->year }} {{ config('app.name') }}. All rights reserved.
        </p>
        <p style="color: #9ca3af; margin: 5px 0;">
            Need help? <a href="mailto:support@{{ config('app.name') }}" style="color: #3b82f6; text-decoration: none;">Contact Support</a>
        </p>
    </div>
</x-slot:footer>
</x-mail::message> --}}


<x-mail::message>
# Reset Your Password

Hello {{ $user->name }},

Click the button below to reset your password:

<x-mail::button :url="'myapp://reset-password?token=' . $resetToken">
    Reset Password
</x-mail::button>

If you don't have our app, [click here](https://example.com/reset-password?token={{ $resetToken }}) to reset your password in a web browser.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
