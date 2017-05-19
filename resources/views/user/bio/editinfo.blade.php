@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit User Bio</div>
                <div class="panel-body">
                    @if($Bio->id > 0 )
                        <form id="frm" class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="/userBio/{{$Bio->id}}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}

                        <div class="form-group">
                            <label for="first_name" class="col-md-4 control-label">First Name</label>
                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ $Bio->first_name }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="middle_name" class="col-md-4 control-label">Middle Name</label>
                            <div class="col-md-6">
                                <input id="middle_name" type="text" class="form-control" name="middle_name" value="{{  $Bio->middle_name }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-md-4 control-label">Last Name</label>
                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ $Bio->last_name }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date_of_birth" class="col-md-4 control-label">Date Of Birth</label>
                            <div class="col-md-6">
                                <input id="date_of_birth" type="date" class="form-control" name="date_of_birth" value="{{ $Bio->date_of_birth }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Gender</label>
                            <div class="col-md-offset-4">
                                <div class="col-md-3">
                                    <input id="male" type="radio" class="" name="gender" value="male" @if( old('gender') == 'male') checked @endif > Male
                                </div>
                                <div class="col-md-3">
                                    <input id="female" type="radio" class="" name="gender" value="female" @if( old('gender') == 'female') checked @endif > Female
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">physically challenged</label>

                            <div class="col-md-offset-4">
                                <div class="col-md-3">
                                    <input id="yes" type="radio" class="" name="physically_challenged" value="yes" @if( old('physically_challenged') == 'yes') checked @endif > Yes
                                </div>
                                <div class="col-md-3">
                                    <input id="no" type="radio" class="" name="physically_challenged" value="no" @if( old('physically_challenged') == 'no') checked @endif > No
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-4">
                                <button type="button" style="width: 100%" class="btn btn-primary" onclick="Validateform();">
                                    Update
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" onclick="event.preventDefault();
                                    document.getElementById('frmskip').submit();"
                                    style="width: 100%" class="btn btn-primary">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                    <form id="frmskip" method="get"
                        @if(Auth::user()->role == "admin")
                            action="{{route('userBio.index')}}"
                        @else
                            action="{{route('profile.show',Auth::user()->user_master_id)}}"
                        @endif
                        >
                    </form>
                    @endif
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
