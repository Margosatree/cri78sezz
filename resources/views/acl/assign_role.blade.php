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
                <div class="panel-heading">Assign Role to User</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/assign_role">
                        {{ csrf_field() }}

                <!--This For Role -->
                        <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                            <label for="user_id" class="col-md-4 control-label">Select User</label>
                                <div class="col-md-6">
                                      <select name="user_id" class="form-control">
                                      @foreach($userData as $data)
                                        <option  value={{$data->id}}>{{ucfirst($data->email)}}</option>
                                         @endforeach
                                      </select>
                                    @if ($errors->has('user_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('user_id') }}</strong>
                                        </span>
                                    @endif

                            </div>
                        </div>
                    <!-- This for Team -->
                    <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                            <label for="role_id" class="col-md-4 control-label">Select Team</label>
                                <div class="col-md-6">
                                      <select name="role_id[]" multiple class="form-control">
                                      @foreach($roleData as $team)
                                        <option  value={{$team->id}}>{{ucfirst($team->name)}}</option>
                                         @endforeach
                                      </select>
                                    @if ($errors->has('role_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('role_id') }}</strong>
                                        </span>
                                    @endif

                            </div>
                        </div>
                    <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Assign Role
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