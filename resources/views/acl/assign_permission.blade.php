<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link rel="stylesheet" href="/css/poststyle.css">
</head>
<body>
	<h1>Assign Perimssion to Role</h1> 




	<form method="POST" action="/assign_permission">
			{{csrf_field()}}
		  <div class="form-group">
		    <label for="role_id">Select Role</label>
		    <select id = 'role_id' class="form-control" name = 'role_id'>
		    @foreach($roleData as $role)
		    	<option value = {{ $role->id }}>{{$role->name}}</option>				
			@endforeach		   
		    </select>
		  </div>  

		  <div class="form-group">
		    <label for="permission_id">Select Permission</label>
		    <select id = 'permission_id' class="form-control" name = 'permission_id[]' multiple>
		    

		    @foreach($permissionData as $permission)
		    	<option value = {{ $permission->id }}>{{$permission->name}}</option>				
			@endforeach
		    </select>
		  </div>  
		  		
		  <div class="form-group">
		  	<button type="submit" class="btn btn-primary">Assign Permission To Role</button>
		  </div>

		
	</form>
</body>
</html>