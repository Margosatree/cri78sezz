@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body" style="text-align: center;">
                    <a class="btn btn-primary" href="{{ route('create_role') }}">Create Role of User</a> 
                    <a class="btn btn-primary" href="{{ route('assign_role') }}">Assign Role To User</a> <br> <br>
                    
                   <!--  <a href="{{ route('create_role') }}">Sync (Can be merged with Assign role)</a>  |-->
                    <a class="btn btn-primary" href="{{ route('create_permission') }}">Create Permission</a> 
                    <a class="btn btn-primary" href="{{ route('assign_permission') }}">Assign Permission To Role</a> <br><br>

                    <a class="btn btn-primary" href="{{ route('revoke_role') }}">Revoke Role From User</a> 
                    <a class="btn btn-primary" href="{{ route('revoke_permission') }}">Revoke Permission From Role</a>  
                    <!-- <a href="{{ route('create_role') }}">Sync Permissions (Can be merged with Assign Permission)</a> |  -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
