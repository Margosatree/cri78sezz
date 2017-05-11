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
                  <a id="s-3" href="" class="done" isdone="1" rel="3">
                    <span class="step_no">3</span>
                    <span class="step_descr">
                      Step 3<br />
                      <br>
                      <!-- <small>Step 3 description</small> -->
                    </span>
                  </a>
                </li>
                <li>
                  <a id="s-4" href="" class="selected" isdone="1" rel="4">
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
                    
                    <div id="step-4">
                    <form id="frm" class="form-horizontal" role="form" method="POST" action="{{ route('userBio.store') }}">
                        {{ csrf_field() }}
                        <div class="item form-group">
                            <!-- <label for="address" class="col-md-4 control-label">Address</label>
                            <div class="col-md-6"> -->
                                <input id="address" type="text" class="form-control col-md-7 col-xs-12" placeholder="Address" name="address" value="{{ old('address') }}" required autofocus>
                            <!-- </div> -->
                        </div>
                        <div class="item form-group">
                            <!-- <label for="pin"  class="col-md-4 control-label">Zip Code</label>
                            <div class="col-md-6"> -->
                                <input id="pin" onblur="validPin();" data-inputmask="'mask' : '999999'" placeholder="Zip Code"  class="form-control col-md-7 col-xs-12"  name="pin" value="{{ old('pin') }}" required>
                            <!-- </div> -->
                        </div>
                        <div class="item form-group">
                            <!-- <label for="suburb" class="col-md-4 control-label">Suburb</label>
                            <div class="col-md-6"> -->
                                <input id="suburb" type="text" class="form-control col-md-7 col-xs-12"  placeholder="Suburb" name="suburb" value="{{ old('suburb') }}" required autofocus>
                            <!-- </div> -->
                        </div>
                        <div class="item form-group">
                            <!-- <label for="city" class="col-md-4 control-label">City</label>
                            <div class="col-md-6"> -->
                                <input id="city" type="text" class="form-control col-md-7 col-xs-12" placeholder="City" readonly="" name="city" value="{{ old('city') }}" required autofocus>
                            <!-- </div> -->
                        </div>
                        
                        <div class="item form-group">
                            <!-- <label for="state" class="col-md-4 control-label">State</label>
                            <div class="col-md-6"> -->
                                <input id="state" type="text" class="form-control col-md-7 col-xs-12" placeholder="State" readonly="" name="state" value="{{ old('state') }}" required autofocus>
                            <!-- </div> -->
                        </div>

                        <div class="item form-group">
                            <!-- <label for="country" class="col-md-4 control-label">Country</label>
                            <div class="col-md-6"> -->
                                <input id="country" type="text" class="form-control col-md-7 col-xs-12" placeholder="Country" readonly="" name="country" value="{{ old('country') }}" required>
                            <!-- </div> -->
                        </div>
                        <!-- <div class="form-group">
                            <div class="col-md-3 col-md-offset-4">
                                <button type="button" style="width: 100%" onclick="Validateform();" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" onclick="event.preventDefault();
                                    document.getElementById('frmskip').submit();" 
                                    style="width: 100%" class="btn btn-primary">
                                    Skip
                                </button>
                            </div>
                        </div> -->
                    </form>
                    <form id="frmskip" method="get" action="{{ route('orgcriProfile.create') }}">
                    </form>
                    </div>
                </div>
                </div>
                </div>

            <!-- End SmartWizard Content -->
                
                <div>
                <div class="row">
                    <div class="form-group">
                        
                            <div class="col-md-1 col-md-offset-4">
                                 <button type="button" id="usr_sub" style="width: 100%" onclick="Validateform('c');" class="btn btn-primary">
                                    User
                                </button>
                            </div>
                            <div class="col-md-1">
                                <button type="button" id="usr_skip" onclick="event.preventDefault();
                                    Callfrom('c');
                                    document.getElementById('frmskip').submit();" 
                                    style="width: 100%" class="btn btn-primary">
                                    Skip To User
                                </button>
                            </div>
                            <div class="col-md-1">
                                 <button type="button" id="org_sub" style="width: 100%" onclick="Validateform('o');" class="btn btn-primary">
                                    Org
                                </button>
                            </div>
                            <div class="col-md-1">
                                <button type="button" id="org_skip" onclick="event.preventDefault();
                                    Callfrom('o');
                                    document.getElementById('frmskip').submit();" 
                                    style="width: 100%" class="btn btn-primary">
                                    Skip To Org
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

  <script src="{{ asset('js/ui/step_5.js')}}"></script>

  <!-- <script src="js/validator.js"></script> -->

  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
  <script src="{{ asset('js/ui/icheck.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $("#pin").inputmask();
      });
</script>
<script type="text/javascript">
    // document.getElementById("usr_sub").addEventListener("click", myFunction);

    // function myFunction(){

    // }
</script>
<script>
function Callfrom(callfrom){
    if(callfrom == 'c'){
        localStorage.setItem('callfrom',callfrom);
    }else{
        localStorage.setItem('callfrom',callfrom);
    }
}
    function Validateform(callfrom){
        Callfrom(callfrom);
        
        if($('#address').val() == "" || $('#address').val() == "undefined" || $('#address').val() == "NaN"){
            alert('Please Enter Address');
            return;
        }else{
            if($("#address").val().length > 70){
                alert('Address Is Too Long');
                return;
            }
        }
        if($('#pin').val() == "" || $('#pin').val() == "undefined" || $('#pin').val() == "NaN"){
            alert('Please Enter Pincode');
            return;
        }else{
            if(!$("#pin").val().length === 6){
                alert('Please Entre Valid Pincode');
                return;
            }
        }
        if($('#suburb').val() == "" || $('#suburb').val() == "undefined" || $('#suburb').val() == "NaN"){
            alert('Please Enter Suburb');
            return;
        }else{
            if($("#suburb").val().length > 20){
                alert('Suburb Is Too Long');
                return;
            }
            var Reg = new RegExp(/^[A-Za-z _.-]+$/);
            if (!Reg.test($('#suburb').val())) {
                alert('Invalid Suburb');
                return;
            }
        }
        if($('#city').val() == "" || $('#city').val() == "undefined" || $('#city').val() == "NaN"){
            alert('Please Enter City');
            return;
        }else{
            if($("#city").val().length > 20){
                alert('City Is Too Long');
                return;
            }
            var Reg = new RegExp(/^[A-Za-z _.-]+$/);
            if (!Reg.test($('#city').val())) {
                alert('Invalid City');
                return;
            }
        }
        if($('#state').val() == "" || $('#state').val() == "undefined" || $('#state').val() == "NaN"){
            alert('Please Enter State');
            return;
        }else{
            if($("#state").val().length > 20){
                alert('State Is Too Long');
                return;
            }
            var Reg = new RegExp(/^[A-Za-z _.-]+$/);
            if (!Reg.test($('#state').val())) {
                alert('Invalid State');
                return;
            }
        }
        if($('#country').val() == "" || $('#country').val() == "undefined" || $('#country').val() == "NaN"){
            alert('Please Enter Country');
            return;
        }else{
            if($("#country").val().length > 20){
                alert('Country Is Too Long');
                return;
            }
            var Reg = new RegExp(/^[A-Za-z _.-]+$/);
            if (!Reg.test($('#country').val())) {
                alert('Invalid Country');
                return;
            }
        }
        
        document.getElementById('frm').submit();
    }
</script>
<script>
    function getAddressfromZip(){
        console.log("http://maps.googleapis.com/maps/api/geocode/json?address="+$('#pin').val()+"&sensor=true");
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "http://maps.googleapis.com/maps/api/geocode/json?address="+$('#pin').val()+"&sensor=true",
            success: function(data){
                if(data.status == "OK" || data.status == "ok"){
                    var obj = data.results;
                    if(obj != ""){
                        console.log(JSON.stringify(obj[0]));
                        if(obj[0] != ""){
                            var obj1 = obj[0];
                            SetAddress(obj1.formatted_address);
                        }
                    }
                }else{
                    alert('Please Insert Valid Pin Code');
                }
            }
        });
    }
    function SetAddress(data){
        var add = data.split(',');
        console.log(add);
        console.log(add.length);
        $('#suburb').val('');
        $('#city').val('');
        $('#state').val('');
        $('#country').val('');
        if(add.length == 2){
            $('#state').val(add[0].substring(0,add[0].indexOf(" ")).trim());
            $('#country').val(add[1].trim());
        }else if(add.length == 3){
            $('#city').val(add[0].trim());
            $('#state').val(add[1].substring(0,add[1].trim().indexOf(" ")+1).trim());
            $('#country').val(add[2].trim());
            
        }
        if($('#city').val() == ""){
            $('#city').attr('readonly',false);
        }else{
            $('#city').attr('readonly',true);
        }
        if($('#state').val() == ""){
            $('#state').attr('readonly',false);
        }else{
            $('#state').attr('readonly',true);
        }
        if($('#country').val() == ""){
            $('#country').attr('readonly',false);
        }else{
            $('#country').attr('readonly',true);
        }
    }
</script>
<script type="text/javascript">
        function validPin(){
            getAddressfromZip();
        }
</script>
