@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Cricket Profile</div>
                <div class="panel-body">
                    @if($Cri_Profile->id > 0 )
                        <form id="frm" class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="/criProfile/{{$Cri_Profile->id}}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="form-group">
                                <label for="shiftid" class="col-md-4 control-label">Select Role</label>
                                <div class="col-md-6">
                                    <select name="your_role" class="form-control">
                                        <option @if($Cri_Profile->your_role == 1) selected @endif value="1">Bowller</option>
                                        <option @if($Cri_Profile->your_role == 2) selected @endif value="2">BatsMan</option>
                                        <option @if($Cri_Profile->your_role == 3) selected @endif value="3">Wicket Keeper</option>
                                        <option @if($Cri_Profile->your_role == 4) selected @endif value="4">AllRounder</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">Batsman Style</label>
                                <div class="col-md-offset-4">
                                    <div class="col-md-3">
                                        <input id="Lefthand" type="radio" class="" name="batsman_style" value="Lefthand" @if( $Cri_Profile->batsman_style == 'Lefthand') checked @endif > Lefthand
                                    </div>
                                    <div class="col-md-3">
                                        <input id="Righthand" type="radio" class="" name="batsman_style" value="Righthand" @if( $Cri_Profile->batsman_style == 'Righthand') checked @endif > Righthand
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="batsman_order" class="col-md-4 control-label">Batsman Order</label>
                                <div class="col-md-6">
                                    <input id="batsman_order" type="number" min="1" max="12" class="form-control" name="batsman_order" value="{{$Cri_Profile->batsman_order}}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">Bowler Style</label>
                                <div class="col-md-offset-4">
                                    <div class="col-md-3">
                                        <input id="Lefthand" type="radio" class="" name="bowler_style" value="Lefthand" @if( $Cri_Profile->bowler_style == 'Lefthand') checked @endif> Lefthand
                                    </div>
                                    <div class="col-md-3">
                                        <input id="Righthand" type="radio" class="" name="bowler_style" value="Righthand" @if( $Cri_Profile->bowler_style == 'Righthand') checked @endif> Righthand
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="player_type" class="col-md-4 control-label">Player Type</label>
                                <div class="col-md-6">
                                    <input id="player_type" type="text" class="form-control" name="player_type" value="{{$Cri_Profile->player_type}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-md-4 control-label">Description</label>
                                <div class="col-md-6">
                                    <input id="description" type="text" class="form-control" name="description" value="{{$Cri_Profile->description}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="team_image" class="col-md-4 control-label">Team Image</label>

                                <div class="col-md-6">
                                    <td class="text-center">
                                        <img src ="{{asset('images/'.$Cri_Profile->display_img)}}" class="img-thumbnail" width=70 heigth=20/>
                                    </td>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div id="upload-demo" style="width:350px"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="image-upload" class="col-md-4 control-label">Image Upload</label>
                                <div class="col-md-8">
                                    <button type="button" class="btn btn-default btn-file">
                                        <span>Browse</span>
                                        <input type="file"  name="image" id="upload">
                                        <input type="hidden"  name="imagedata" id="imagedata">
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
                                    <button id="Save" type="button" style="width: 100%" onclick="" class="btn btn-primary">
                                        Submit
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
                                action="{{route('criProfile.index')}}"
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
<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/croppie.css">
<script src="http://demo.itsolutionstuff.com/plugin/croppie.js"></script>
<script>
    $uploadCrop = $('#upload-demo').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'square'
        },
        boundary: {
            width: 300,
            height: 300
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
        document.getElementById('frm').submit();
    }
</script>


@endsection