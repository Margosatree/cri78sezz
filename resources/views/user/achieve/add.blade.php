@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Achievement's</div>
                <div class="panel-body">
                    <form id="frm" class="form-horizontal" role="form" method="POST" action="/userAchieve">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="title" class="col-md-4 control-label">Title</label>
                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <input id="orgname" type="hidden" class="form-control" name="orgname" value="{{ old('orgname') }}" autofocus>
                            <div class="col-md-5">
                                <select id="name" name="name" class="form-control">
                                    <option  value="0" selected disabled>Select Organisation</option>
                                    @foreach($Orgs as $Org)
                                        <option  value="{{$Org->id}}">{{$Org->name}}</option>
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
                                <input id="start_date" type="date" class="form-control" name="start_date" value="{{ old('start_date') }}" required autofocus>
                            </div>
                            <div class="col-md-3">
                                <input id="end_date" type="date" class="form-control" name="end_date" value="{{ old('end_date') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="location" class="col-md-4 control-label">Location</label>
                            <div class="col-md-6">
                                <input id="location" type="text" class="form-control" name="location" value="{{ old('location') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-4">
                                <button type="button" onclick="Validateform();"
                                    style="width: 100%" class="btn btn-primary">
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
                    <form id="frmskip" method="get" action="{{ route('home') }}">
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
        console.log(EndDate >= StartDate);
        if (!(EndDate >= StartDate)) {
            alert('Start Date Lesser Then Or Equal To End Date');
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
        document.getElementById('frm').submit();
    }
</script>
<script>
    $('#name').change(function(){
        $('#orgname').val($('#org option:selected').text());
    });
    function openModal(){
        $('#orgModal').modal('toggle');
    }
    function validateOrg(){
        if($('#txtModalInput').val() != ""){
            var flag = true;
            $("#name option").each(function(){
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
                $('#name').append('<option  value="-1" selected>'+ $('#txtModalInput').val() +'</option>');
                $("#name").trigger("change");
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