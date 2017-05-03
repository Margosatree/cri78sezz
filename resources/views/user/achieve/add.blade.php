@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Achievement's</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/org">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="title" class="col-md-4 control-label">Title</label>
                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <input id="orgname" type="hidden" class="form-control" name="orgname" value="" autofocus>
                            <div class="col-md-5">
                                <select id="org" name="name" class="form-control">
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
                            <label for="location" class="col-md-4 control-label">Location</label>
                            <div class="col-md-6">
                                <input id="location" type="text" class="form-control" name="location" value="" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Time Period</label>
                            <div class="col-md-3">
                                <input id="start_date" type="date" class="form-control" name="start_date" value="" required autofocus>
                            </div>
                            <div class="col-md-3">
                                <input id="end_date" type="date" class="form-control" name="end_date" value="" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" style="width: 100%" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
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