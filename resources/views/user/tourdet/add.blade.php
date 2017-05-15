@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Add Rule</div>
                <div class="panel-body">
                    <form id="frm" class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="/tour/{{ $Tournament }}/tourdet">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="shiftid" class="col-md-4 control-label">Select Rule</label>
                            <div class="col-md-6">
                                <select name="rule" class="form-control">
                                    <option  value="0" selected disabled>Select Rule</option>
                                    @foreach($Rules as $Rule)
                                        <option  value="{{$Rule->id}}">{{$Rule->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
<!--                        
                        <div class="form-group">
                            <label for="specification" class="col-md-4 control-label">Specification</label>
                            <div class="col-md-6">
                                <input id="specification" type="text" class="form-control" name="specification" value="" autofocus required="" > 
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label for="value" class="col-md-4 control-label">Value</label>
                            <div class="col-md-6">
                                <input id="value" type="text" class="form-control" name="value" value="" autofocus required="" > 
                            </div>
                        </div>
<!--                        
                        <div class="form-group">
                            <label for="range_from" class="col-md-4 control-label">Range From</label>
                            <div class="col-md-6">
                                <input id="range_from" type="number" class="form-control" name="range_from" value="" autofocus required="" > 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="range_to" class="col-md-4 control-label">Range To</label>
                            <div class="col-md-6">
                                <input id="range_to" type="number" class="form-control" name="range_to" value="" autofocus required="" > 
                            </div>
                        </div>-->
                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-6">
                                <button type="button" style="width: 100%" onclick="Validateform();" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
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