@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form id="frm" class="form-horizontal" role="form" method="POST" action="{{ route('verify.store') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token or old('token') }}">

                        <div class="form-group{{ $errors->has('verify_email') ? ' has-error' : '' }}">
                            <label for="verify_email" class="col-md-4 control-label">E-Mail OTP</label>

                            <div class="col-md-6">
                                <input id="verify_email" type="verify_email" class="form-control" name="verify_email" value="{{ old('verify_email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('verify_email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('verify_phone') ? ' has-error' : '' }}">
                            <label for="verify_phone" class="col-md-4 control-label">Phone OTP</label>

                            <div class="col-md-6">
                                <input id="verify_phone" type="verify_phone" class="form-control" name="verify_phone" value="{{ old('verify_phone') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('verify_phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-4">
                                <button type="submit" style="width: 100%" onclick="Validateform();" class="btn btn-primary">
                                    Verify
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="reset" style="width: 100%" class="btn btn-primary">
                                    Clear
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function Validateform(){
        if($('#verify_phone').val() == "" || $('#verify_phone').val() == "undefined" || $('#verify_phone').val() == "NaN"){
            alert('Please Enter Username');
            return;
        }else{
            if()
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
            var emailReg = new RegExp(/\A[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}\z/);
            if (!emailReg.test($('#email').val())) {
                alert('Please Enter Valid Email Address');
                return;
            }
        }
        if($('#password').val() == "" || $('#password').val() == "undefined" || $('#password').val() == "NaN"){
            alert('Please Enter End Date');
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
        alert('out');
        return;
        document.getElementById('frm').submit();
    }
</script>
@endsection
