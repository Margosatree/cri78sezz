@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Change Password</div>

                <div class="panel-body">
                    
                    <form id="frm" class="form-horizontal" role="form" method="POST" action="/pass/update">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="current_password" class="col-md-4 control-label">Current Password</label>

                            <div class="col-md-6">
                                <input id="current_password" type="password" class="form-control" name="current_password" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">New Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm New Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="button" onclick="Validateform();" class="btn btn-primary">
                                    Change Password
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
<script>
    function Validateform(){
        if($('#current_password').val() == "" || $('#current_password').val() == "undefined" || $('#current_password').val() == "NaN"){
            alert('Please Enter Password');
            return;
        }else{
            
        }
        if($('#password').val() == "" || $('#password').val() == "undefined" || $('#password').val() == "NaN"){
            alert('Please Enter Password');
            return;
        }else{
            passwordReg = new RegExp(/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/);
            if (!passwordReg.test($('#password').val())) {
                alert('Password Formate Invalid');
                return;
            }
        }
        if($('#password-confirm').val() == "" || $('#password-confirm').val() == "undefined" || $('#password-confirm').val() == "NaN"){
            alert('Please Enter Password');
            return;
        }else{
            if($('#password').val().toString() !== $('#password-confirm').val().toString()){
                alert('Password Conrmation Invalid');
                return;
            }
        }
        document.getElementById('frm').submit();
    }
</script>
@endsection
