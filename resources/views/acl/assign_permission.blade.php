@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <div class="container">
            <div class="col-md-4">
            @include('layouts.message')
            </div>
        </div>
            <div class="panel panel-default">
                <div class="panel-heading">Assign Perimssion to Role</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/assign_permission">
                        {{ csrf_field() }}

                <!--This For Role -->
                        <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                            <label for="role_id" class="col-md-4 control-label">Select Role</label>
                                <div class="col-md-6">
                                      <select name="role_id" class="form-control">
                                      @foreach($roleData as $data)
                                        <option  value={{$data->id}}>{{ucfirst($data->name)}}</option>
                                         @endforeach
                                      </select>
                                    @if ($errors->has('role_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('role_id') }}</strong>
                                        </span>
                                    @endif

                            </div>
                        </div>
                    <!-- This for Team -->
                    <div class="form-group{{ $errors->has('permission_id') ? ' has-error' : '' }}">
                            <label for="permission_id" class="col-md-4 control-label">Select Permission</label>
                                <div class="col-md-6">
                                      <select name="permission_id[]" multiple class="form-control">
                                      @foreach($permissionData as $team)
                                        <option  value={{$team->id}}>{{ucfirst($team->name)}}</option>
                                         @endforeach
                                      </select>
                                    @if ($errors->has('permission_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('permission_id') }}</strong>
                                        </span>
                                    @endif

                            </div>
                        </div>
                    <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Assign Permission
                                </button>
                            </div>
                    </div>
                    </form>             
                </div>
            </div>
        </div>
    </div>
</div>
@endsection