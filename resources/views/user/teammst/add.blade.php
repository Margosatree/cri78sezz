@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Tournament</div>
                <div class="panel-body">
                    <form id="frm" class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="/team">
                        {{ csrf_field() }}
                        <div class=" col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label>Team Name</label>
                                <input id="team_name" type="text" class="form-control" name="team_name" value="" autofocus required="" > 
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label>Team Owner</label>
                                <input id="team_owner_id" type="number" class="form-control" name="team_owner_id" value="" autofocus required="" > 
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label>Team Type</label>
                                <input id="team_type" type="text" class="form-control" name="team_type" value="" autofocus required="" > 
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label>Order</label>
                                <input id="order_id" type="number" class="form-control" name="order_id" value="" autofocus required="" > 
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label>Owner</label>
                                <input id="owner_id" type="number" class="form-control" name="owner_id" value="" autofocus required="" > 
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
<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/croppie.css">
<script src="http://demo.itsolutionstuff.com/plugin/croppie.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
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
        alert('dasdas');
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
//        if($('#your_role').val() == "" || $('#your_role').val() == "undefined" || $('#your_role').val() == "NaN"){
//            alert('Please Select Role');
//            return;
//        }else{
//            
//        }
//        if($('input[name=batsman_style]:checked').length <= 0){
//            alert("Please Select Batsman Style");
//            return;
//        }
//        if($('#batsman_order').val() == "" || $('#batsman_order').val() == "undefined" || $('#batsman_order').val() == "NaN"){
//            alert('Please Enter Batsman Order');
//            return;
//        }else{
//            var phoneReg = new RegExp(/^\d+$/);
//            if (!phoneReg.test($('#batsman_order').val())) {
//                alert('Invalid Batsman Order');
//                return;
//            }
//        }
//        if($('input[name=bowler_style]:checked').length <= 0){
//            alert("Please Select Bowler Style");
//            return;
//        }
//        if($('#player_type').val() == "" || $('#player_type').val() == "undefined" || $('#player_type').val() == "NaN"){
//            alert('Please Enter Player Type');
//            return;
//        }else{
//            if($("#player_type").val().length > 50){
//                alert('Player Type Is Too Long');
//                return;
//            }
//            var Reg = new RegExp(/^[A-Za-z _.-]+$/);
//            if (!Reg.test($('#player_type').val())) {
//                alert('Player Type Country');
//                return;
//            }
//        }
//        if($('#description').val() == "" || $('#description').val() == "undefined" || $('#description').val() == "NaN"){
//            alert('Please Enter Description');
//            return;
//        }else{
//            if($("#description").val().length > 50){
//                alert('Description Is Too Long');
//                return;
//            }
//        }
        document.getElementById('frm').submit();
    }
</script>
@endsection