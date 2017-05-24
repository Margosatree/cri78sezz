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
                  <a id="s-1" href="#step-1" class="done" isdone="1" rel="1">
                    <span class="step_no">1</span>
                    <span class="step_descr">
                      Step 1<br />
                      <br>
                      <!-- <small>Step 1 description</small> -->
                    </span>
                  </a>
                </li>
                <li>
                  <a id="s-2" href="#step-2" class="selected" isdone="1" rel="2">
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
                    
                    <div id="step-2">
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                    <form id="frm" class="form-horizontal" role="form" method="POST" action="{{ route('verify.store') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token or old('token') }}">

                        <div class="item form-group{{ $errors->has('verify_email') ? ' has-error' : '' }}">
                            <!-- <label for="verify_email" class="col-md-4 control-label">E-Mail OTP</label> -->

                            <div class="">
                                <input id="verify_email" type="verify_email" placeholder="E-mail OTP" class="form-control col-md-7 col-xs-12" name="verify_email" value="{{ old('verify_email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('verify_email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="item form-group{{ $errors->has('verify_phone') ? ' has-error' : '' }}">
                            <!-- <label for="verify_phone" class="col-md-4 control-label">Phone OTP</label> -->

                            <div class="">
                                <input id="verify_phone" type="verify_phone" placeholder="Phone OTP" class="form-control col-md-7 col-xs-12" name="verify_phone" value="{{ old('verify_phone') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('verify_phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <div class="col-md-3 col-md-offset-4">
                                <button type="button" style="width: 100%" onclick="Validateform();" class="btn btn-primary">
                                    Verify
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="reset" style="width: 100%" class="btn btn-primary">
                                    Clear
                                </button>
                            </div>
                        </div> -->
                    </form>
                    </div>
                </div>
                </div>
                </div>
            <!-- End SmartWizard Content -->
                <!-- <hr> -->
                <div>
                <div class="row">
                    <div class="form-group">
                        
                            <div class="col-md-1 col-md-offset-5">
                                <button type="button" style="width: 100%" onclick="Validateform();" class="btn btn-primary">
                                    Verify
                                </button>
                            </div>
                            <div class="col-md-1">
                                <button type="reset" style="width: 100%" class="btn btn-primary">
                                    Clear
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
    function Validateform(){
        if($('#verify_email').val() == "" || $('#verify_email').val() == "undefined" || $('#verify_email').val() == "NaN"){
            alert('Please Enter Email OTP');
            return;
        }else{
            if(!$.isNumeric($("#verify_email").val()) || $("#verify_phone").val().length !== 6){
                alert('Invalid Email OTP');
                return;
            }
        }
        if($('#verify_phone').val() == "" || $('#verify_phone').val() == "undefined" || $('#verify_phone').val() == "NaN"){
            alert('Please Enter Phone OTP');
            return;
        }else{
            if(!$.isNumeric($("#verify_phone").val()) || $("#verify_phone").val().length !== 6){
                alert('Invalid Phone OTP');
                return;
            }
        }
        document.getElementById('frm').submit();
    }
    $('#s-1').addClass('done');
    $('#s-2').addClass('selected');
</script>

