@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Personal Detail</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('userBio.store') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="address" class="col-md-4 control-label">Address</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pin"  class="col-md-4 control-label">Zip Code</label>
                            <div class="col-md-6">
                                <input id="pin" onblur="validPin();" data-inputmask="'mask' : '999999'"  class="form-control"  name="pin" value="{{ old('pin') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="suburb" class="col-md-4 control-label">Suburb</label>
                            <div class="col-md-6">
                                <input id="suburb" type="text" class="form-control"  name="suburb" value="{{ old('suburb') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city" class="col-md-4 control-label">City</label>
                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control" readonly="" name="city" value="{{ old('city') }}" required autofocus>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="state" class="col-md-4 control-label">State</label>
                            <div class="col-md-6">
                                <input id="state" type="text" class="form-control" readonly="" name="state" value="{{ old('state') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="country" class="col-md-4 control-label">Country</label>
                            <div class="col-md-6">
                                <input id="country" type="text" class="form-control" readonly="" name="country" value="{{ old('country') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-4">
                                <button type="submit" style="width: 100%" class="btn btn-primary">
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
                    <form id="frmskip" method="get" action="{{ route('criProfile.create') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $("#pin").inputmask();
      });
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
@endsection