<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Registration</title>

  <!-- Bootstrap -->

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="{{ asset('css/ui/nprogress.css') }}" rel="stylesheet">
  

  <!-- Custom Theme Style -->
  <link href="{{ asset('css/ui/custom.min.css') }}" rel="stylesheet">

  <link href="{{ asset('css/ui/green.css') }}" rel="stylesheet">

<!-- Scripts -->

  
  <style type="text/css">
    .clearfix{clear:both;}
  </style>
</head>
<body class="nav-md">

<div class="main_container">
    <!-- page content -->


    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
            <!-- Smart Wizard -->
            <h1 style="text-align:center;">Registration</h1>
            <div style="padding-top: 50px; display:block;"id="wizard" class="form_wizard wizard_horizontal">
              <ul class="wizard_steps">
                <li>
                  <!-- <a id="s-1" href="#step-1"> -->
                  <a id="s-1" href="#step-1" class="selected" isdone="1" rel="1">
                    <span class="step_no">1</span>
                    <span class="step_descr">
                      Step 1<br />
                      <br>
                      <!-- <small>Step 1 description</small> -->
                    </span>
                  </a>
                </li>
                <li>
                  <a id="s-2" href="" class="disabled">
                    <span class="step_no">2</span>
                    <span class="step_descr">
                      Step 2<br />
                      <br>
                      <!-- <small>Step 2 description</small> -->
                    </span>
                  </a>
                </li>
                <li>
                  <a id="s-3" href="" class="disabled">
                    <span class="step_no">3</span>
                    <span class="step_descr">
                      Step 3<br />
                      <br>
                      <!-- <small>Step 3 description</small> -->
                    </span>
                  </a>
                </li>
                <li>
                  <a id="s-4" href="" class="disabled">
                    <span class="step_no">4</span>
                    <span class="step_descr">
                      Step 4<br />
                      <br>
                      <!-- <small>Step 4 description</small> -->
                    </span>
                  </a>
                </li>
                <li>
                  <a id="s-5" href="" class="disabled">
                    <span class="step_no">5</span>
                    <span class="step_descr">
                      Step 5<br />
                      <br>
                      <!-- <small>Step 5 description</small> -->
                    </span>
                  </a>
                </li>
                <!-- <li>
                  <a id="s-6" href="#step-6">
                    <span class="step_no">5</span>
                    <span class="step_descr">
                      Step 5<br />
                      <br>
                      <small>Step 6 description</small>
                    </span>
                  </a>
                </li> -->
              </ul>
              <div id="step-1">
                    <form id="frm" class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="item form-group">
                            <!-- <label for="username" class="col-md-4 control-label">User Name</label> -->
                            <!-- <div class="col-md-6"> -->
                                <input id="username" type="text" placeholder="User Name" class="form-control" name="username" value="{{ old('username') }}" required >
                            <!-- </div> -->
                        </div>
                        
                        
                        <div class="form-group">
                            <!-- <label for="phone" class="col-md-4 control-label">Phone</label>

                            <div class="col-md-6"> -->
                                <input id="phone"  data-inputmask="'mask' : '9999999999'" placeholder="Phone No" class="form-control col-md-7 col-xs-12"" name="phone" value="{{ old('phone') }}" required>
                            <!-- </div> -->
                        </div>
                        
                        <div class="form-group">
                            <!-- <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6"> -->
                                <input id="email" type="email" class="form-control col-md-7 col-xs-12"" placeholder="E-mail" name="email" value="{{ old('email') }}" required>
                            <!-- </div> -->
                        </div>
                        
                        <div class="form-group">
                            <!-- <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6 "> -->
                                <div class="input-group">
                                    <input id="password" type="password" placeholder="Password" class="form-control col-md-7 col-xs-12"" name="password" required>
                                    <span class="input-group-addon" onclick="showhidepass();">
                                        <i id="showhide" class="fa fa-eye-slash" aria-hidden="true" ></i>
                                    </span>
                                </div>
                                <span class="help-block">
                                    <strong>One Upper, Lower, special char, and Number</strong>
                                </span>
                            <!-- </div> -->
                        </div>

                        <div class="form-group">
                           <!--  <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6"> -->
                                <input id="password-confirm" type="password" placeholder="Repeat Password" class="form-control col-md-7 col-xs-12"" name="password_confirmation" required>
                            <!-- </div> -->
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
            <!-- End SmartWizard Content -->
                
                <div>
                <div class="row">
                    <div class="form-group">
                        
                            <div class="col-md-2 col-md-offset-5">
                                <button type="button" style="width:100%" onclick="Validateform();" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- jQuery -->
<link href="{{ asset('css/ui/nprogress.css') }}" rel="stylesheet">
  <script src="{{ asset('js/ui/jquery.min.js')}}"></script>
  <!-- Bootstrap -->
  <script src="{{ asset('js/ui/bootstrap.min.js')}}"></script>
  <!-- FastClick -->
  <script src="{{ asset('js/ui/fastclick.js')}}"></script>
  <!-- NProgress -->
  <script src="{{ asset('js/ui/nprogress.js')}}"></script>
  <!-- jQuery Smart Wizard -->
  <script src="{{ asset('js/ui/jquery.smartWizard.js')}}"></script>
  <!-- Custom Theme Scripts -->
  <script src="{{ asset('js/ui/custom.min.js')}}"></script>

  <!-- <script src="js/validator.js"></script> -->

  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
  <script src="{{ asset('js/ui/icheck.min.js')}}"></script>
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

</body>
</html>