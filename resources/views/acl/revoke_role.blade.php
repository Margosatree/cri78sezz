<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link rel="stylesheet" href="/css/poststyle.css">
</head>
<body>
	<h1>Revoke Role From User</h1> 


	<form method="POST" action="/revoke_role">
			{{csrf_field()}}
	<div class="form-group">
		 <table class="table">
		 @if (count($users))
    	<thead>
		    <tr>
		        <th>Users</th>
		        <th>Roles</th>        
		    </tr>
	    </thead>
	    <tbody>
	    @foreach($users as $user)  
		    <tr>
			    <td>{{$user['email']}}</td>
				<td>{{$user['role']}}</td>
				<td><a href="/revoke_role/{{$user['id']}}/{{$user['userId']}}" class="btn btn-success btn-xs ">&nbsp;Delete&nbsp;</a></td>
			</tr>    	
		@endforeach 
    	</tbody>
    	@else
    	<thead>
		    <tr>
		        <th>Users</th>
		        <th>Roles</th>        
		    </tr>
	    </thead>
	    <tbody>
	     <tr class="info">
          <td colspan="6">Sorry Data Not Found..If You want to go back <a href="{{route('adminhome')}}" >Click Here..</a></td>
         </tr>
    	</tbody>
    	@endif
  </table>
	</div>	  		
		  <!-- <div class="form-group">
		  	<button type="submit" class="btn btn-primary">Revoke Role</button>
		  </div> -->

		
	</form>
</body>
</html>