@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Tournament Info</div>
                <div class="panel-body">
                    @if($Tournament->id > 0 )
                        <form id="frm" class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="/tourmst/{{$Tournament->id}}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class=" col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label>Tournament Name</label>
                                <input id="tournament_name" type="text" class="form-control" name="tournament_name" value="{{$Tournament->tournament_name}}" autofocus required="" >
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label>Tournament Location</label>
                                <input id="tournament_location" type="text" class="form-control" name="tournament_location" value="{{$Tournament->tournament_location}}" autofocus required="" >
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label>Tournament Start Date</label>
                                <input id="start_date" type="date" class="form-control" name="start_date" value="{{$Tournament->start_date}}" autofocus required="" >
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label>Tournament End Date</label>
                                <input id="end_date" type="date" class="form-control" name="end_date" value="{{$Tournament->end_date}}" autofocus required="" >
                            </div>
                            <div class="form-group  col-md-12 col-sm-12 col-xs-12">
                                <label>Reg. Start Date</label>
                                <input id="reg_start_date" type="date" class="form-control" name="reg_start_date" value="{{$Tournament->reg_start_date}}" autofocus required="" >
                            </div>
                            <div class="form-group  col-md-12 col-sm-12 col-xs-12">
                                <label>Reg. End Date</label>
                                <input id="reg_end_date" type="date" class="form-control" name="reg_end_date" value="{{$Tournament->reg_end_date}}" autofocus required="" >
                            </div>
                        </div>

                        <div class=" col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group  col-md-12 col-sm-12 col-xs-12">
                                <div id="upload-demo" style="width:350px;padding: 10px 10px 0px 10px;"></div>
                            </div>
                            <div class="form-group  col-md-12 col-sm-12 col-xs-12">
                                <button type="button" class="btn btn-default btn-file" style="margin-top: 20px">
                                        <span>Add Logo</span>
                                        <div id="defaultimg" class='hidden'>{{asset('images/'.$Tournament->tournament_logo)}}</div>
                                        <input type="file"  name="image" id="upload" required="">
                                        <input type="hidden"  name="imagedata" id="imagedata" required="">
                                    </button>
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <button id="Save" type="button" style="width: 100%"  class="btn btn-primary">
                                    Submit
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
        viewport: {
            width: 200,
            height: 200,
            type: 'square'
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
        if($('#tournament_name').val() == "" || $('#tournament_name').val() == "undefined" || $('#tournament_name').val() == "NaN"){
            alert('Please Enter Tournament Name');
            return;
        }else{
            if($("#tournament_name").val().length > 70){
                alert('Tournament Name Is Too Long');
                return;
            }
        }

        if($('#tournament_location').val() == "" || $('#tournament_location').val() == "undefined" || $('#tournament_location').val() == "NaN"){
            alert('Please Enter Tournament Location');
            return;
        }else{
            if($("#tournament_location").val().length > 70){
                alert('Tournament Location Is Too Long');
                return;
            }
        }

        if($('#start_date').val() == "" || $('#start_date').val() == "undefined" || $('#start_date').val() == "NaN"){
            alert('Please Select Start Date');
            return;
        }

        if($('#end_date').val() == "" || $('#end_date').val() == "undefined" || $('#end_date').val() == "NaN"){
            alert('Please Select End Date');
            return;
        }
        var StartDate = new Date(Date.parse($("#start_date").val()));
        var EndDate = new Date(Date.parse($("#end_date").val()));
        console.log(EndDate+' '+StartDate);
        console.log(EndDate >= StartDate);
        if (!(EndDate >= StartDate)) {
            alert('Start Date SHOULD BE Lesser Then Or Equal To End Date');
            return;
        }

        if($('#reg_start_date').val() == "" || $('#reg_start_date').val() == "undefined" || $('#reg_start_date').val() == "NaN"){
            alert('Please Select Reg. Start Date');
            return;
        }
        if($('#reg_end_date').val() == "" || $('#reg_end_date').val() == "undefined" || $('#reg_end_date').val() == "NaN"){
            alert('Please Select Reg. End Date');
            return;
        }
        var RegStartDate = new Date(Date.parse($("#reg_start_date").val()));
        var RegEndDate = new Date(Date.parse($("#reg_end_date").val()));
        console.log(RegEndDate+' '+RegStartDate);
        console.log(RegEndDate >= RegStartDate);
        if (!(RegEndDate >= RegStartDate)) {
            alert('Reg.Start Date SHOULD BE Lesser Then Or Equal To Reg.End Date');
            return;
        }
        document.getElementById('frm').submit();
    }
</script>


@endsection
