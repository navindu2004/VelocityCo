Dear <b>{{ $seller->name }}</b><br>
<p>
    You are receiving this email because you requested to reset your password.
</p>
<p>
    Please use the link below to reset it:
    <a href="{{ $action_link }}" target="_blank">{{ $actionLink }}</a><br>
</p>
<p>
    This password reset link is only valid for the next 15 minutes.
</p>
<p>
    If you did not request a password reset, please ignore this email.
</p>
