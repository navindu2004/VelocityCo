<p>Dear {{ $admin->name }}</p>
<br>
<p>
    Your password on VelocityCo system was changed successfully.
    Here is your new login credentials:
    <br>
    <b>Login ID: </b>{{ $admin-> type }} or {{ $admin->email }}
    <br>
    <b>Password: </b>{{ $new_password }}
</p>
<br>
Please keep your credentials confidential.
<p>
    This email was automatically was sent by VelocityCo system, Do not reply to it.
</p>