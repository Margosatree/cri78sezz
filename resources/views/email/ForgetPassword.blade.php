Click here To Reset Your Password:<br>
<a href="{{ $link=url('passwords/reset',$token).'?email='.urlencode($email) }}">
	{{ $link }}
</a>