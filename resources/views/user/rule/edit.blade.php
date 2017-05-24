@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Organization Info</div>
                <div class="panel-body">
                    @if($Tournament->id > 0 )
                        <form id="frm" class="form-horizontal" role="form" method="POST" action="/tournament/{{$Tournament->id}}">
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
//        if($('#name').val() == "" || $('#name').val() == "undefined" || $('#name').val() == "NaN"){
//            alert('Please Enter Organisation Name');
//            return;
//        }else{
//            if($("#name").val().length > 70){
//                alert('Organisation Name Is Too Long');
//                return;
//            }
//        }
//        if($('#business_type').val() == "" || $('#business_type').val() == "undefined" || $('#business_type').val() == "NaN"){
//            alert('Please Enter Business Type');
//            return;
//        }else{
//            if($("#business_type").val().length > 70){
//                alert('Business Type Is Too Long');
//                return;
//            }
//        }
//        if($('#business_operation').val() == "" || $('#business_operation').val() == "undefined" || $('#business_operation').val() == "NaN"){
//            alert('Please Enter Business Operation');
//            return;
//        }else{
//            if($("#business_operation").val().length > 70){
//                alert('Business Operation Is Too Long');
//                return;
//            }
//        }
//        if($('#address').val() == "" || $('#address').val() == "undefined" || $('#address').val() == "NaN"){
//            alert('Please Enter Address');
//            return;
//        }else{
//            if($("#address").val().length > 70){
//                alert('Address Is Too Long');
//                return;
//            }
//        }
//        if($('#landmark').val() == "" || $('#landmark').val() == "undefined" || $('#landmark').val() == "NaN"){
//            alert('Please Enter Landmark');
//            return;
//        }else{
//            if($("#landmark").val().length > 25){
//                alert('Landmark Is Too Long');
//                return;
//            }
//        }
//        if($('#pin').val() == "" || $('#pin').val() == "undefined" || $('#pin').val() == "NaN"){
//            alert('Please Enter Pincode');
//            return;
//        }else{
//            if($('#pin').inputmask('unmaskedvalue').length !== 6){
//                alert('Please Entre Valid Pincode');
//                return;
//            }
//        }
//        if($('#city').val() == "" || $('#city').val() == "undefined" || $('#city').val() == "NaN"){
//            alert('Please Enter City');
//            return;
//        }else{
//            if($("#city").val().length > 20){
//                alert('City Is Too Long');
//                return;
//            }
//            var Reg = new RegExp(/^[A-Za-z _.-]+$/);
//            if (!Reg.test($('#city').val())) {
//                alert('Invalid City');
//                return;
//            }
//        }
//        if($('#state').val() == "" || $('#state').val() == "undefined" || $('#state').val() == "NaN"){
//            alert('Please Enter State');
//            return;
//        }else{
//            if($("#state").val().length > 20){
//                alert('State Is Too Long');
//                return;
//            }
//            var Reg = new RegExp(/^[A-Za-z _.-]+$/);
//            if (!Reg.test($('#state').val())) {
//                alert('Invalid State');
//                return;
//            }
//        }
//        if($('#country').val() == "" || $('#country').val() == "undefined" || $('#country').val() == "NaN"){
//            alert('Please Enter Country');
//            return;
//        }else{
//            if($("#country").val().length > 20){
//                alert('Country Is Too Long');
//                return;
//            }
//            var Reg = new RegExp(/^[A-Za-z _.-]+$/);
//            if (!Reg.test($('#country').val())) {
//                alert('Invalid Country');
//                return;
//            }
//        }
//        if($('#spoc').val() == "" || $('#spoc').val() == "undefined" || $('#spoc').val() == "NaN"){
//            alert('Please Enter SPOC');
//            return;
//        }else{
//
//        }
        document.getElementById('frm').submit();
    }
</script>


@endsection
