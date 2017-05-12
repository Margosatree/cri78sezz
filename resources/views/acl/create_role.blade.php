<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link rel="stylesheet" href="/css/poststyle.css">
</head>
<body>
	<h1>Create A Role</h1> 

	<form method="POST" action="/create_role">
			{{csrf_field()}}
		  <div class="form-group">
		    <label for="name">User Role</label>
		    <input type="text" class="form-control" id="name" name="name">
		  </div>  
		  <div class="form-group">
		    <label for="description">Description</label>
		    <input type="text" class="form-control" id="description" name="description">
		  </div> 		
		  <div class="form-group">
		  	<button type="submit" class="btn btn-primary">Create Role</button>
		  </div>

		
	</form>
</body>
</html>