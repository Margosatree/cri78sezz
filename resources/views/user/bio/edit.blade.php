@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit User Bio</div>
                <div class="panel-body">
                    @if($Bio->id > 0 )
                        <form class="form-horizontal" role="form" method="POST" action="/userBio/{{$Bio->id}}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="form-group">
                            <label for="address" class="col-md-4 control-label">Address</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ $Bio->address }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="suburb" class="col-md-4 control-label">Suburb</label>
                            <div class="col-md-6">
                                <input id="suburb" type="text" class="form-control" name="suburb" value="{{ $Bio->suburb }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city" class="col-md-4 control-label">City</label>
                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control" name="city" value="{{ $Bio->city }}" required autofocus>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="state" class="col-md-4 control-label">State</label>
                            <div class="col-md-6">
                                <input id="state" type="text" class="form-control" name="state" value="{{ $Bio->state }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="country" class="col-md-4 control-label">Country</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control " name="country" value="{{ $Bio->country }}" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="pin" class="col-md-4 control-label">PIN</label>
                            <div class="col-md-6">
                                <input id="pin" type="number" class="form-control" max="999999" minlength="6" maxlength="6" name="pin" value="{{ $Bio->pin }}" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" style="width: 100%" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>



@endsection