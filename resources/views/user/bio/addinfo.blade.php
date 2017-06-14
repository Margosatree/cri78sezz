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
                  <a id="s-2" href="#step-2" class="done" isdone="1" rel="2">
                    <span class="step_no">2</span>
                    <span class="step_descr">
                      Step 2<br />
                      <br>
                      <!-- <small>Step 2 description</small> -->
                    </span>
                  </a>
                </li>
                <li>
                  <a id="s-3" href="" class="selected" isdone="1" rel="3">
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
                    
                    <div id="step-3">
                    <form id="frm" class="form-horizontal" role="form" method="POST" action="{{ route('userBio.storeInfo') }}">
                        {{ csrf_field() }}
                        <div class="item form-group">
                            <!-- <label for="first_name" class="col-md-4 control-label">First Name</label> -->
                            <!-- <div class="col-md-6"> -->
                                <input id="first_name" type="text" class="form-control col-md-7 col-xs-12" placeholder="First Name" name="first_name" value="{{ old('first_name') }}" required autofocus>
                            <!-- </div> -->
                        </div>
                        <div class="form-group">
                            <!-- <label for="middle_name" class="col-md-4 control-label">Middle Name</label> -->
                            <!-- <div class="col-md-6"> -->
                                <input id="middle_name" type="text" class="form-control col-md-7 col-xs-12" placeholder="Middle Name" name="middle_name" value="{{ old('middle_name') }}" required autofocus>
                            <!-- </div> -->
                        </div>
                        <div class="form-group">
                            <!-- <label for="last_name" class="col-md-4 control-label">Last Name</label> -->
                            <!-- <div class="col-md-6"> -->
                                <input id="last_name" type="text" class="form-control col-md-7 col-xs-12" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" required autofocus>
                            <!-- </div> -->
                        </div>
                        <div class="form-group">
                            <!-- <label for="date_of_birth" class="col-md-4 control-label">Date Of Birth</label> -->
                            <!-- <div class="col-md-6"> -->
                                <input id="date_of_birth" type="date" class="form-control col-md-7 col-xs-12" placeholder="Date of Birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required autofocus>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="gender" class="">Gender : &nbsp;</label>
                            <!-- <div class="col-md-offset-4">
                                <div class="col-md-3"> -->
                                    <input id="male" type="radio" class="flat" name="gender" value="male" @if( old('gender') == 'male') checked @endif > &nbsp; Male &nbsp;
                                <!-- </div>
                                <div class="col-md-3"> -->
                                    <input id="female" type="radio" class="flat" name="gender" value="female" @if( old('gender') == 'female') checked @endif > &nbsp; Female
                                <!-- </div>
                            </div> -->
                        </div>
                        <div class="item form-group">
                            <label for="physically_challenged" class="">Physically Challenged :  &nbsp;</label>
                            
                            <!-- <div class="col-md-offset-4">
                                <div class="col-md-3"> -->
                                    <input id="yes" type="radio" class="flat" name="physically_challenged" value="yes" @if( old('physically_challenged') == 'yes') checked @endif > &nbsp; Yes &nbsp;
                                <!-- </div>
                                <div class="col-md-3"> -->
                                    <input id="no" type="radio" class="flat" name="physically_challenged" value="no" @if( old('physically_challenged') == 'no') checked @endif >  &nbsp;No
                                <!-- </div>
                            </div> -->
                        </div>
                        
                        <!-- <div class="form-group">
                            <div class="col-md-3 col-md-offset-4">
                                <button type="button" style="width: 100%" onclick="Validateform();" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" style="width: 100%" onclick="event.preventDefault();
                                    document.getElementById('frmskip').submit();" class="btn btn-primary">
                                    Skip
                                </button>
                            </div>
                        </div> -->
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
                    <form id="frmskip" method="get" action="{{ route('userBio.create') }}">
                    </form>
                    
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
                                    Submit
                                </button>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" style="width: 100%" onclick="event.preventDefault();
                                    document.getElementById('frmskip').submit();" class="btn btn-primary">
                                    Skip
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
        if($('#first_name').val() == "" || $('#first_name').val() == "undefined" || $('#first_name').val() == "NaN"){
            alert('Please Enter First Name');
            return;
        }else{
            if($("#first_name").val().length > 50){
                alert('First Name Is Too Long');
                return;
            }
        }
        if($('#middle_name').val() == "" || $('#middle_name').val() == "undefined" || $('#middle_name').val() == "NaN"){
            alert('Please Enter Middle Name');
            return;
        }else{
            if($("#middle_name").val().length > 50){
                alert('Middle Name Is Too Long');
                return;
            }
        }
        if($('#last_name').val() == "" || $('#last_name').val() == "undefined" || $('#last_name').val() == "NaN"){
            alert('Last Name Is Too Long');
            return;
        }else{
            if($("#last_name").val().length > 50){
                alert('Last Name Is Too Long');
                return;
            }
        }
        if($('#date_of_birth').val() == "" || $('#date_of_birth').val() == "undefined" || $('#date_of_birth').val() == "NaN"){
            alert('Please Enter Phone OTP');
            return;
        }else{
            var now = new Date();
            var FiveYearBackDate = new Date(now.getFullYear()-5,now.getMonth(),now.getDay());
            var EndDate = new Date(Date.parse($("#date_of_birth").val()));
            console.log(EndDate+' '+FiveYearBackDate);
            if (EndDate > FiveYearBackDate) {
                alert('At Least 5 Year Old');
                return;
            }
        }
        if($('input[name=gender]:checked').length <= 0){
            alert("Please Select Gender");
            return;
        }
        if($('input[name=physically_challenged]:checked').length <= 0){
            alert("Please Select Physically Challenged");
            return;
        }
        document.getElementById('frm').submit();
    }
</script>