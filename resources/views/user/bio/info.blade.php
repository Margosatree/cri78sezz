@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('userBio.storeInfo') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="first_name" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="middle_name" class="col-md-4 control-label">Middle Name</label>

                            <div class="col-md-6">
                                <input id="middle_name" type="text" class="form-control" name="middle_name" value="{{ old('middle_name') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date_of_birth" class="col-md-4 control-label">Date Of Birth</label>

                            <div class="col-md-6">
                                <input id="date_of_birth" type="date" class="form-control" name="date_of_birth" value="{{ old('date_of_birth') }}" required autofocus>
                            </div>
                        </div>

                        
                        
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Gender</label>
                            
                            <div class="col-md-offset-4">
                                <div class="col-md-3">
                                    <input id="male" type="radio" class="" name="gender" value="male" @if( old('gender') == 'male') checked @endif > Male
                                </div>
                                <div class="col-md-3">
                                    <input id="female" type="radio" class="" name="gender" value="female" @if( old('gender') == 'female') checked @endif > Female
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">physically challenged</label>
                            
                            <div class="col-md-offset-4">
                                <div class="col-md-3">
                                    <input id="yes" type="radio" class="" name="physically_challenged" value="yes" @if( old('physically_challenged') == 'yes') checked @endif > Yes
                                </div>
                                <div class="col-md-3">
                                    <input id="no" type="radio" class="" name="physically_challenged" value="no" @if( old('physically_challenged') == 'no') checked @endif > No
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-4">
                                <button type="submit" style="width: 100%" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="reset" style="width: 100%" class="btn btn-primary">
                                    Clear
                                </button>
                            </div>
                        </div>
                        @if(count($errors) > 0)
                            <div class="from-group" >
                                <div class="col-md-6 col-md-offset-4 alert alert-danger" style="margin-top: 10px;">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection