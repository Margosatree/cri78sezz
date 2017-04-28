Click here To Verify : <br>
<a href="{{ $link=url('/verifes',$token).'?email='.urlencode('abc@gmail.com') }}">
	{{ $link }}
</a>
<br>
Your Email OTP is <h1>{{$email_otp}}</h1>