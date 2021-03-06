@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Organization Info</div>
                <div class="panel-body">
                    @if($Team->id > 0 )
                        <form id="frm" class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="/team/{{$Team->id}}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class=" col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label>Team Name</label>
                                <input id="team_name" type="text" class="form-control" name="team_name" value="{{$Team->team_name}}" autofocus required="" >
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label>Team Owner</label>
                                <!--<input id="team_owner_id" type="number" class="form-control" name="team_owner_id" value="" autofocus required="" >-->
                                <select id="team_owner_id" name="team_owner_id" class="form-control">
                                    <option  value="0" selected="" disabled="">Select Owner</option>
                                    @foreach($Owners as $Owner)
                                        <option @if($Owner->id == $Team->team_owner_id) selected @endif value="{{$Owner->id}}">{{$Owner->Owner_Name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label>Team Type</label>
                                <input id="team_type" type="text" class="form-control" name="team_type" value="{{$Team->team_type}}" autofocus required="" >
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label>Order</label>
                                <input id="order_id" type="number" class="form-control" name="order_id" value="{{$Team->order_id}}" autofocus required="" >
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label>Owner</label>
                                <input id="owner_id" type="number" class="form-control" name="owner_id" value="{{$Team->owner_id}}" autofocus required="" >
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <button id="Save" type="button" style="width: 100%"  class="btn btn-primary">
                                    Submit
                                </button>
                            </div>


                        </div>

                        <div class=" col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group  col-md-12 col-sm-12 col-xs-12">
                                <div id="upload-demo" style="width:350px;padding: 10px 10px 0px 10px;float: left"></div>
                            </div>
                            <div class="form-group  col-md-12 col-sm-12 col-xs-12">
                                <button type="button" class="btn btn-default btn-file" style="margin-top: 20px">
                                        <span>Add Logo</span>
                                        <div id="defaultimg" class='hidden'>{{asset('images/'.$Team->team_logo)}}</div>
                                        <input type="file"  name="image" id="upload" required="">
                                        <input type="hidden"  name="imagedata" id="imagedata" required="">
                                    </button>
                            </div>

                        </div>
                        <div class=" col-md-12 col-sm-12 col-xs-12">
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
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/croppie.css">
<script src="http://demo.itsolutionstuff.com/plugin/croppie.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/phone-codes/phone.min.js"></script>-->
<script>
    $(document).ready(function() {
        $("#pin").inputmask();
      });
</script>
<script>

    $uploadCrop = $('#upload-demo').croppie({
        enableExif: true,
        enforceBoundary : false,
        viewport: {
            width: 200,
            height: 200,
            type: 'circle'
        },
        boundary: {
            width: 250,
            height: 250
        }
    });
    $uploadCrop.croppie('bind', {
        url: $("#defaultimg").html(),
        points: [77, 469, 280, 739]
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
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {

            $('#imagedata').val(resp);
            console.log($('#imagedata').val());
            Validateform();
        });
    });
</script>
<script>
    function Validateform(){
        if($('#team_name').val() == "" || $('#team_name').val() == "undefined" || $('#team_name').val() == "NaN"){
            alert('Please Enter Team Name');
            return;
        }else{
            if($("#team_name").val().length > 70){
                alert('Team Name Is Too Long');
                return;
            }
        }
//        alert($('#team_owner_id option:selected').val());
//        alert(parseInt($('#team_owner_id option:selected').val()) < 0);return;
        if($('#team_owner_id option:selected').val() == "" || $('#team_owner_id option:selected').val() == "undefined" || $('#team_owner_id option:selected').val() == "NaN"){
            alert('Please Enter Team Owner');
            return;
        }else{
            if($("#team_owner_id option:selected").val() < 0){
                alert('Please Enter valid Team Owner');
                return;
            }

            if(!$.isNumeric($("#team_owner_id option:selected").val())){
                alert('Please Enter Numeric values only');
                return;
            }
        }
        if($('#team_type').val() == "" || $('#team_type').val() == "undefined" || $('#team_type').val() == "NaN"){
            alert('Please Enter Team Type');
            return;
        }else{
            if($("#team_type").val().length > 70){
                alert('Team Type Is Too Long');
                return;
            }
        }
        if($('#order_id').val() == "" || $('#order_id').val() == "undefined" || $('#order_id').val() == "NaN"){
            alert('Please Enter Order');
            return;
        }else{
            if($("#order_id").val() < 0){
                alert('Please Enter valid Order');
                return;
            }
            if(!$.isNumeric($("#order_id").val())){
                alert('Please Enter Numeric values only');
                return;
            }
        }
        if($('#owner_id').val() == "" || $('#owner_id').val() == "undefined" || $('#owner_id').val() == "NaN"){
            alert('Please Enter Owner');
            return;
        }else{
            if($("#owner_id").val() < 0){
                alert('Please Enter valid Owner');
                return;
            }
            if(!$.isNumeric($("#owner_id").val())){
                alert('Please Enter Numeric values only');
                return;
            }
        }
        document.getElementById('frm').submit();
    }
</script>


@endsection
