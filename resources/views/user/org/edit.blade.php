@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Organization Info</div>
                <div class="panel-body">
                    @if($Org->id > 0 )
                        <form class="form-horizontal" role="form" method="POST" action="/org/{{$Org->id}}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $Org->name }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="business_type" class="col-md-4 control-label">Business Type</label>
                            <div class="col-md-6">
                                <input id="business_type" type="text" class="form-control" name="business_type" value="{{ $Org->business_type }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="business_operation" class="col-md-4 control-label">Business Operation</label>
                            <div class="col-md-6">
                                <input id="business_operation" type="text" class="form-control" name="business_operation" value="{{ $Org->business_operation }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-4 control-label">Address</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ $Org->address }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="landmark" class="col-md-4 control-label">Landmark</label>
                            <div class="col-md-6">
                                <input id="landmark" type="text" class="form-control" name="landmark" value="{{ $Org->landmark }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pincode" class="col-md-4 control-label">PIN</label>
                            <div class="col-md-6">
                                <input id="pin" onblur="validPin();" type="number" class="form-control" max="999999" minlength="6" maxlength="6" name="pincode" value="{{ $Org->pincode }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city" class="col-md-4 control-label">City</label>
                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control" name="city" value="{{ $Org->city }}" required autofocus>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="state" class="col-md-4 control-label">State</label>
                            <div class="col-md-6">
                                <input id="state" type="text" class="form-control" name="state" value="{{ $Org->state }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="country" class="col-md-4 control-label">Country</label>
                            <div class="col-md-6">
                                <input id="country" type="text" class="form-control " name="country" value="{{ $Org->country }}" required>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="spoc" class="col-md-4 control-label">Spoc</label>
                            <div class="col-md-6">
                                <input id="spoc" type="text" class="form-control"  name="spoc" value="{{ $Org->spoc }}" required>
                            </div>
                        </div>
                        @if(Auth::user()->role == "admin")
                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">Verification Status</label>

                                <div class="col-md-offset-4">
                                    <div class="col-md-3">
                                        <input id="Yes" type="radio" class="" name="is_verified" value="1" @if( $Org->is_verified == 1) checked @endif > Yes
                                    </div>
                                    <div class="col-md-3">
                                        <input id="No" type="radio" class="" name="is_verified" value="0" @if( $Org->is_verified == 0) checked @endif > No
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-4">
                                <button type="submit" style="width: 100%" class="btn btn-primary">
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
                            action="{{route('org.index')}}"
                        @else
                            action="{{route('Profile.show',Auth::user()->user_master_id)}}"
                        @endif
                        >
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $( "#is_verified" ).trigger( "change" );
    $('#is_verified').on('click', function() {
        if ($('#is_verified').is(":checked")){
            $('#is_verified').val(1);
//            alert($('#is_verified').val());
        }else{
            $('#is_verified').val(2);
//            alert($('#is_verified').val());
        }
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