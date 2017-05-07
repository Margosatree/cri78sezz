@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Organization Info</div>
                <div class="panel-body">
                    @if($User_Achieve->id > 0 )
                        <form id="frm" class="form-horizontal" role="form" method="POST" action="/userAchieve/{{$User_Achieve->id}}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="form-group">
                            <label for="title" class="col-md-4 control-label">Title</label>
                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{$User_Achieve->title}}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <!--<input id="orgname" type="hidden" class="form-control" name="orgname" value="{{$User_Achieve->id}}" autofocus>-->
                            <div class="col-md-5">
                                <select id="org" name="name" class="form-control">
                                    <option  value="0" selected disabled>Select Organisation</option>
                                    @foreach($Orgs as $Org)
                                        <option @if($User_Achieve->organization_master_id == $Org->id) selected @endif value="{{$Org->id}}">{{$Org->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('your_role'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('your_role') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-1">
                                <button type="button" onclick="$('#orgModal').modal('toggle');" class="btn btn-primary" style="display: block">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Time Period</label>
                            <div class="col-md-3">
                                <input id="start_date" type="date" class="form-control" name="start_date" value="{{$User_Achieve->start_date}}" required autofocus>
                            </div>
                            <div class="col-md-3">
                                <input id="end_date" type="date" class="form-control" name="end_date" value="{{$User_Achieve->end_date}}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="location" class="col-md-4 control-label">Location</label>
                            <div class="col-md-6">
                                <input id="location" type="text" class="form-control" name="location" value="{{$User_Achieve->location}}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-4">
                                <button type="button" style="width: 100%" onclick="Validateform();"
                                        class="btn btn-primary">
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
                            action="{{route('userAchieve.index')}}"
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/phone-codes/phone.min.js"></script>-->
<script>
    $(document).ready(function() {
        $("#pin").inputmask();
      });
</script>
<script>
    function Validateform(){
        if($('#title').val() == "" || $('#title').val() == "undefined" || $('#title').val() == "NaN"){
            alert('Please Enter Title');
            return;
        }else{
            if($("#title").val().length > 50){
                alert('Title Is Too Long');
                return;
            }
        }
        if($('#name').val() == "" || $('#name').val() == "undefined" || $('#name').val() == "NaN"){
            alert('Please Select Role');
            return;
        }else{
            
        }
        if($('#start_date').val() == "" || $('#start_date').val() == "undefined" || $('#start_date').val() == "NaN"){
            alert('Please Select Role');
            return;
        }
        if($('#end_date').val() == "" || $('#end_date').val() == "undefined" || $('#end_date').val() == "NaN"){
            alert('Please Select Role');
            return;
        }
        var StartDate = new Date(Date.parse($("#start_date").val()));
        var EndDate = new Date(Date.parse($("#end_date").val()));
        console.log(EndDate+' '+StartDate);
        if (EndDate >= StartDate) {
            alert('Start Date Grater Then Or Equal To End Date');
            return;
        }
        if($('#location').val() == "" || $('#location').val() == "undefined" || $('#location').val() == "NaN"){
            alert('Please Enter Location');
            return;
        }else{
            if($("#location").val().length > 50){
                alert('Location Is Too Long');
                return;
            }
        }
        return;
        document.getElementById('frm').submit();
    }
</script>
<script>
    $( "#is_verified" ).trigger( "change" );
    $('#is_verified').on('click', function() {
        if ($('#is_verified').is(":checked")){
            $('#is_verified').val(1);
        }else{
            $('#is_verified').val(2);
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