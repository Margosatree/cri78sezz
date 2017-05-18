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
                                <select id="rule" name="rule" class="form-control">
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
        if($('#rule option:selected').val() == "" || $('#rule option:selected').val() == "undefined" || $('#rule option:selected').val() == "NaN"){
            alert('Please Enter Team Owner');
            return;
        }else{
            if($("#rule option:selected").val() < 0){
                alert('Please Enter valid Rule');
                return;
            }
            if(!$.isNumeric($("#rule option:selected").val())){
                alert('Invalid Rule');
                return;
            }
        }
        if($('#value').val() == "" || $('#value').val() == "undefined" || $('#value').val() == "NaN"){
            alert('Please Enter Value');
            return;
        }else{
            if($("#value").val().length > 70){
                alert('Organisation Name Is Too Long');
                return;
            }
        }
        document.getElementById('frm').submit();
    }
</script>
@endsection