@if(Session::has('Success'))

	<div class="alert alert-dismissible alert-success">
 	 <strong>Thank You !</strong> {{Session::get('Success')}}
	</div>

@endif