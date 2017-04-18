Click here To Reset Your Password:<br>
<a href="{{ $link=url('password/reset',$token).'?email='.urlencode($email) }}">
	{{ $link }}
</a>