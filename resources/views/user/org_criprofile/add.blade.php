@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 ">
            <div class="panel panel-default">
                <div class="panel-heading">Cricket Profile</div>
                <div class="panel-body">
                    <form id="frmcri" class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="{{ route('criProfile.store') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('your_role') ? ' has-error' : '' }}">
                            <label for="shiftid" class="col-md-4 control-label">Select Role</label>
                            <div class="col-md-6">
                                <select id="your_role" name="your_role" class="form-control">
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
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('batsman_style') ? ' has-error' : '' }}">
                            <label for="batsman_style" class="col-md-4 control-label">Batsman Style</label>
                            <div class="col-md-offset-4">
                                <div class="col-md-3">
                                    <input id="Lefthand" type="radio" class="" name="batsman_style" value="Lefthand" @if( old('batsman_style') == 'Lefthand') checked @endif> Lefthand
                                    @if ($errors->has('batsman_style'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('batsman_style') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <input id="Righthand" type="radio" class="" name="batsman_style" value="Righthand" @if( old('batsman_style') == 'Righthand') checked @endif> Righthand
                                    @if ($errors->has('batsman_style'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('batsman_style') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('batsman_order') ? ' has-error' : '' }}">
                            <label for="batsman_order" class="col-md-4 control-label">Batsman Order</label>
                            <div class="col-md-6">
                                <input id="batsman_order" type="number" min="1" max="12" class="form-control" name="batsman_order" value="{{ old('batsman_order') }}" required autofocus>
                                @if ($errors->has('batsman_order'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('batsman_order') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('bowler_style') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Bowler Style</label>
                            <div class="col-md-offset-4">
                                <div class="col-md-3">
                                    <input id="Lefthand" type="radio" class="" name="bowler_style" value="Lefthand" @if( old('bowler_style') == 'Lefthand') checked @endif> Lefthand
                                    @if ($errors->has('bowler_style'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('bowler_style') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <input id="Righthand" type="radio" class="" name="bowler_style" value="Righthand" @if( old('bowler_style') == 'Righthand') checked @endif> Righthand
                                    @if ($errors->has('bowler_style'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('bowler_style') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('player_type') ? ' has-error' : '' }}">
                            <label for="player_type" class="col-md-4 control-label">Player Type</label>
                            <div class="col-md-6">
                                <input id="player_type" type="text" class="form-control" name="player_type" value="{{ old('player_type') }}" required>
                                @if ($errors->has('country'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('player_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Description</label>
                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" required>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                        <label for="image-upload" class="col-md-4 control-label">Profile Upload</label>
                        <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-file">
                                <span>Browse</span>
                                <input type="file" name="image" required="">
                                </button>

                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                        </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-4">
                                <button type="Submit" style="width: 100%" onclick="Validatecri();" class="btn btn-primary">
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
                        @if(count($errors) > 0)
                            @if ($errors->has('image') || $errors->has('description') || $errors->has('player_type') || 
                            $errors->has('bowler_style') || $errors->has('batsman_order') || $errors->has('batsman_style')
                            || $errors->has('your_role'))
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
                        @endif
                    </form>
                    <form id="frmskip" method="get" action="{{ route('userAchieve.create') }}">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="panel panel-default">
                <div class="panel-heading">Organisation Register</div>
                <div class="panel-body">
                    <form id="frmorg" class="form-horizontal" role="form" method="POST" action="/org">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="business_type" class="col-md-4 control-label">Business Type</label>
                            <div class="col-md-6">
                                <input id="business_type" type="text" class="form-control" name="business_type" value="{{ old('business_type') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="business_operation" class="col-md-4 control-label">Business Operation</label>
                            <div class="col-md-6">
                                <input id="business_operation" type="text" class="form-control" name="business_operation" value="{{ old('business_operation') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-4 control-label">Address</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="landmark" class="col-md-4 control-label">Landmark</label>
                            <div class="col-md-6">
                                <input id="landmark" type="text" class="form-control" name="landmark" value="{{ old('landmark') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pincode" class="col-md-4 control-label">PIN</label>
                            <div class="col-md-6">
                                <input id="pin" onblur="validPin();" data-inputmask="'mask' : '999999'"  class="form-control" max="999999" minlength="6" maxlength="6" name="pincode" value="{{ old('pincode') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city" class="col-md-4 control-label">City</label>
                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control" name="city" value="{{ old('city') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="state" class="col-md-4 control-label">State</label>
                            <div class="col-md-6">
                                <input id="state" type="text" class="form-control" name="state" value="{{ old('state') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="country" class="col-md-4 control-label">Country</label>
                            <div class="col-md-6">
                                <input id="country" type="text" class="form-control " name="country" value="{{ old('country') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="spoc" class="col-md-4 control-label">Spoc</label>
                            <div class="col-md-6">
                                <input id="spoc" type="text" class="form-control"  name="spoc" value="{{ old('spoc') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="button" style="width: 100%"  onclick="Validateform();" class="btn btn-primary">
                                    Add
                                </button>
                            </div>
                        </div>
                        @if(count($errors) > 0)
                            @if ($errors->has('name') || $errors->has('business_type') || $errors->has('business_operation') || 
                                $errors->has('address') || $errors->has('landmark') || $errors->has('pincode') ||
                                $errors->has('city') || $errors->has('state') || $errors->has('country')
                                || $errors->has('spoc'))
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
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="orgModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Organisation</h4>
            </div>
            <div class="modal-body">
                <div class="comment">
                    <div class="row">
                        <div class="col-md-12">
                            <input required="" class="form-control" id="txtModalInput" placeholder="Organisation Name" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="validateOrg()" class="btn btn-primary" style="min-width: 80px;">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    function Validatecri(){
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
        document.getElementById('frmcri').submit();
    }
</script>
<script>
    function Validateform(){
        if($('#name').val() == "" || $('#name').val() == "undefined" || $('#name').val() == "NaN"){
            alert('Please Enter Organisation Name');
            return;
        }else{
            if($("#name").val().length > 70){
                alert('Organisation Name Is Too Long');
                return;
            }
        }
        if($('#business_type').val() == "" || $('#business_type').val() == "undefined" || $('#business_type').val() == "NaN"){
            alert('Please Enter Business Type');
            return;
        }else{
            if($("#business_type").val().length > 70){
                alert('Business Type Is Too Long');
                return;
            }
        }
        if($('#business_operation').val() == "" || $('#business_operation').val() == "undefined" || $('#business_operation').val() == "NaN"){
            alert('Please Enter Business Operation');
            return;
        }else{
            if($("#business_operation").val().length > 70){
                alert('Business Operation Is Too Long');
                return;
            }
        }
        if($('#address').val() == "" || $('#address').val() == "undefined" || $('#address').val() == "NaN"){
            alert('Please Enter Address');
            return;
        }else{
            if($("#address").val().length > 70){
                alert('Address Is Too Long');
                return;
            }
        }
        if($('#landmark').val() == "" || $('#landmark').val() == "undefined" || $('#landmark').val() == "NaN"){
            alert('Please Enter Landmark');
            return;
        }else{
            if($("#landmark").val().length > 25){
                alert('Landmark Is Too Long');
                return;
            }
        }
        if($('#pin').val() == "" || $('#pin').val() == "undefined" || $('#pin').val() == "NaN"){
            alert('Please Enter Pincode');
            return;
        }else{
            if($('#pin').inputmask('unmaskedvalue').length !== 6){
                alert('Please Entre Valid Pincode');
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
        if($('#spoc').val() == "" || $('#spoc').val() == "undefined" || $('#spoc').val() == "NaN"){
            alert('Please Enter SPOC');
            return;
        }else{
            
        }
        document.getElementById('frmorg').submit();
    }
</script>
<script>
    $('#org').change(function(){
        $('#orgname').val($('#org option:selected').text());
    });
    function openModal(){
        $('#orgModal').modal('toggle');
    }
    function validateOrg(){
        if($('#txtModalInput').val() != ""){
            var flag = true;
            $("#org option").each(function(){
                if($('#txtModalInput').val().toLowerCase() == $(this).text().toLowerCase()){
//                    $(this).atrr('selected',true);
//                    var objRide = document.getElementById("cboRide");
//                    setSelectedValue(objRide, 'No');
//                    $("#org").trigger("change");
                    $('#orgModal').modal('hide');
                    alert('Organisation Already Exist');
                    flag = false;
                    return;
                }
//                alert(name+' '+org);
            });
            if(flag){
                $('#org').append('<option  value="-1" selected>'+ $('#txtModalInput').val() +'</option>');
                $("#org").trigger("change");
                $('#orgModal').modal('hide');
            }
        }
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