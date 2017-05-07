@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form id="frm" class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="username" class="col-md-4 control-label">User Name</label>
                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="phone" class="col-md-4 control-label">Phone</label>

                            <div class="col-md-6">
                                <input id="phone"  data-inputmask="'mask' : '9999999999'" class="form-control" name="phone" value="{{ old('phone') }}" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6 ">
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                    <span class="input-group-addon" onclick="showhidepass();">
                                        <i id="showhide" class="fa fa-eye-slash" aria-hidden="true" ></i>
                                    </span>
                                </div>
                                <span class="help-block">
                                    <strong>One Upper, Lower, special char, and Number</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="button" style="width:100%" onclick="Validateform();" class="btn btn-primary">
                                    Register
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/phone-codes/phone.min.js"></script>-->
<script>
    $(document).ready(function() {
        $("#phone").inputmask();
      });
</script>
<script>
    function showhidepass(){
        if($('#showhide').hasClass('fa-eye-slash')){
            $('#showhide').removeClass('fa-eye-slash');
            $('#showhide').addClass('fa-eye');
            $("#password").prop('type','text');
        }else{
            $('#showhide').removeClass('fa-eye');
            $('#showhide').addClass('fa-eye-slash');
            $("#password").prop('type','password');
        }
    }
    function Validateform(){
        if($('#username').val() == "" || $('#username').val() == "undefined" || $('#username').val() == "NaN"){
            alert('Please Enter Username');
            return;
        }else{
            
        }
        if($('#phone').val() == "" || $('#phone').val() == "undefined" || $('#phone').val() == "NaN"){
            alert('Please Enter Valid Phone');
            return;
        }else{
            if($('#phone').inputmask('unmaskedvalue').length !== 10){
                alert('Phone Number Should Must Be 10 Digit');
                return;
            }
            var phoneReg = new RegExp(/(7|8|9)\d{9}/);
            if (!phoneReg.test($('#phone').inputmask('unmaskedvalue'))) {
                alert('Invalid Phone Number');
                return;
            }
        }
        if($('#email').val() == "" || $('#email').val() == "undefined" || $('#email').val() == "NaN"){
            alert('Please Enter email');
            return;
        }else{
            var emailReg = new RegExp(/(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@[*[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+]*/);
            if (!emailReg.test($('#email').val())) {
                alert('Please Enter Valid Email Address');
                return;
            }
//            emailReg = new RegExp(/^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/);
//            if (!emailReg.test($('#email').val())) {
//                alert('Please Enter Valid Email Address');
//                return;
//            }
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
            if($('#password').val().toString() !== $('#password-confirm').val().toString()){
                alert('Password Conrmation Invalid');
                return;
            }
        }
        document.getElementById('frm').submit();
    }
</script>

@endsection