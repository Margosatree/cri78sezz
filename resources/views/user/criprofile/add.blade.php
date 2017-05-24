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
                  <a id="s-4" href="" class="done" isdone="1" rel="4">
                    <span class="step_no">4</span>
                    <span class="step_descr">
                      Step 4<br />
                      <br>
                      <!-- <small>Step 4 description</small> -->
                    </span>
                  </a>
                </li>
                <li>
                  <a id="s-5" href="" class="selected" isdone="1" rel="5">
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
                    
                    <div id="step-5">
                    <form id="frm" class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="{{ route('criProfile.store') }}">
                        {{ csrf_field() }}
                        <div class="item form-group{{ $errors->has('your_role') ? ' has-error' : '' }}">
                            <!-- <label for="shiftid" class="col-md-4 control-label">Select Role</label>
                            <div class="col-md-6"> -->
                                <select name="your_role" class="form-control">
                                    <option>Select Role</option>
                                    <option  value="1">Bowller</option>
                                    <option  value="2">BatsMan</option>
                                    <option  value="3">Wicket Keeper</option>
                                    <option  value="4">AllRounder</option>
                                </select>
                                @if ($errors->has('your_role'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('your_role') }}</strong>
                                </span>
                                @endif
                            <!-- </div> -->
                        </div>
                        <div class="item form-group{{ $errors->has('batsman_style') ? ' has-error' : '' }}">
                            <label for="batsman_style" class="">Batsman Style</label>

                            <!-- <div class="col-md-offset-4">
                                <div class="col-md-3"> -->
                                    <input id="Lefthand" type="radio" class="flat" name="batsman_style" value="Lefthand" > Lefthand

                                    @if ($errors->has('batsman_style'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('batsman_style') }}</strong>
                                    </span>
                                    @endif
                                <!-- </div>
                                <div class="col-md-3"> -->
                                    <input id="Righthand" type="radio" class="flat" name="batsman_style" value="Righthand" > Righthand

                                    @if ($errors->has('batsman_style'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('batsman_style') }}</strong>
                                    </span>
                                    @endif
                                <!-- </div>
                            </div> -->
                        </div>

                        <div class="item form-group{{ $errors->has('batsman_order') ? ' has-error' : '' }}">
                            <!-- <label for="batsman_order" class="">Batsman Order</label>
                            <div class="col-md-6"> -->
                                <input id="batsman_order" type="number" min="1" max="12" class="form-control col-md-7 col-xs-12" placeholder="Batsman Order" name="batsman_order" value="{{ old('batsman_order') }}" required autofocus>
                                @if ($errors->has('batsman_order'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('batsman_order') }}</strong>
                                </span>
                                @endif
                            <!-- </div> -->
                        </div>

                        <div class="item form-group{{ $errors->has('bowler_style') ? ' has-error' : '' }}">
                            <label for="bowler_style" class="">Bowler Style</label>

                            <!-- <div class="col-md-offset-4">
                                <div class="col-md-3"> -->
                                    <input id="Lefthand" type="radio" class="flat" name="bowler_style" value="Lefthand" > Lefthand

                                    @if ($errors->has('bowler_style'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bowler_style') }}</strong>
                                    </span>
                                    @endif
                               <!--  </div>
                                <div class="col-md-3"> -->
                                    <input id="Righthand" type="radio" class="flat" name="bowler_style" value="Righthand" > Righthand

                                    @if ($errors->has('bowler_style'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bowler_style') }}</strong>
                                    </span>
                                    @endif
                                <!-- </div>
                            </div> -->
                        </div>

                        <div class="item form-group{{ $errors->has('player_type') ? ' has-error' : '' }}">
                            <!-- <label for="player_type" class="col-md-4 control-label">Player Type</label>
                            <div class="col-md-6"> -->
                                <input id="player_type" type="text" class="form-control col-md-7 col-xs-12" placeholder="Player Type" name="player_type" value="{{ old('player_type') }}" required>
                                @if ($errors->has('country'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('player_type') }}</strong>
                                </span>
                                @endif
                            <!-- </div> -->
                        </div>
                        <div class="item form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <!-- <label for="description" class="col-md-4 control-label">Description</label>
                            <div class="col-md-6"> -->
                                <input id="description" type="text" class="form-control col-md-7 col-xs-12" placeholder="Description" name="description" value="{{ old('description') }}" required>
                                @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            <!-- </div> -->
                        </div>
                        
                        <div class="item form-group">
                            <!-- <div class="col-md-6"> -->
                                <div id="upload-demo" style="width:350px"></div>
                            <!-- </div> -->
                        </div>
                        <div class="item form-group">
                            <label for="image-upload" class="">Image Upload</label>
                            <!-- <div class="col-md-8"> -->
                                <button type="button" class="btn btn-default btn-file">
                                    <span>Browse</span>
                                    <input type="file"  name="image" id="upload">
                                    <input type="hidden"  name="imagedata" id="imagedata">
                                </button>
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            <!-- </div> -->
                        </div>
                        <div class="form-group">
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
                        </div>
                    </form>
                    <form id="frmskip" method="get" action="{{ route('home') }}">
                    </form>
                    
                    </div>
                </div>
                </div>
            <!-- End SmartWizard Content -->
                <!-- <hr> -->
                <div>
                <!-- <div class="row">
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
                        </div> -->
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
<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/croppie.css">
<script src="http://demo.itsolutionstuff.com/plugin/croppie.js"></script>
<script>
    $uploadCrop = $('#upload-demo').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'square'
        },
        boundary: {
            width: 300,
            height: 300
        }
    });
    $('#upload').on('change', function () { 
        var reader = new FileReader();
        reader.onload = function (e) {
            $uploadCrop.croppie('bind', {
                url: e.target.result
            }).then(function(){
                console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(this.files[0]);
    });


    $('#Save').on('click', function (ev) {
        // alert('dasdas');
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            
            $('#imagedata').val(resp);
            console.log($('#imagedata').val());
            Validateform();
//            $.ajax({
//                url: "ajaxpro.php",
//                type: "POST",
//                data: {"image":resp},
//                success: function (data) {
//                    html = '<img src="' + resp + '" />';
//                    $("#upload-demo-i").html(html);
//                }
//            });
        });
    });
</script>
<script>
    function Validateform(){
        if($('#your_role').val() == "" || $('#your_role').val() == "undefined" || $('#your_role').val() == "NaN"){
            alert('Please Select Role');
            return;
        }else{
            
        }
        if($('input[name=batsman_style]:checked').length <= 0){
            alert("Please Select Batsman Style");
            return;
        }
        if($('#batsman_order').val() == "" || $('#batsman_order').val() == "undefined" || $('#batsman_order').val() == "NaN"){
            alert('Please Enter Batsman Order');
            return;
        }else{
            var phoneReg = new RegExp(/^\d+$/);
            if (!phoneReg.test($('#batsman_order').val())) {
                alert('Invalid Batsman Order');
                return;
            }
        }
        if($('input[name=bowler_style]:checked').length <= 0){
            alert("Please Select Bowler Style");
            return;
        }
        if($('#player_type').val() == "" || $('#player_type').val() == "undefined" || $('#player_type').val() == "NaN"){
            alert('Please Enter Player Type');
            return;
        }else{
            if($("#player_type").val().length > 50){
                alert('Player Type Is Too Long');
                return;
            }
            var Reg = new RegExp(/^[A-Za-z _.-]+$/);
            if (!Reg.test($('#player_type').val())) {
                alert('Player Type Country');
                return;
            }
        }
        if($('#description').val() == "" || $('#description').val() == "undefined" || $('#description').val() == "NaN"){
            alert('Please Enter Description');
            return;
        }else{
            if($("#description").val().length > 50){
                alert('Description Is Too Long');
                return;
            }
        }
        document.getElementById('frm').submit();
    }
</script>
@endsection