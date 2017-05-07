@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Personal Detail</div>
                <div class="panel-body">
                    <form id="frm" class="form-horizontal" role="form" method="POST" action="{{ route('userBio.store') }}">
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
                    <form id="frmskip" method="get" action="{{ route('orgcriProfile.create') }}">
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
    function Validateform(){
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
@endsection