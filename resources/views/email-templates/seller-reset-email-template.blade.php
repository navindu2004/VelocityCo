<p>Dear {{ $seller->name }}</p>
<p>
    Your password has been changed successfully. Here are your new login credentials:<br>
    <b>Login ID: </b>{{ isset($seller->username ) ? $seller->username.' or ' : ''}} {{ $seller->email }}<br>
    <b>Password: </b>{{ $new_password }}
</p>
<br>
Please keep your credentials confidential.