@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Rule</div>
                <div class="panel-body">
                    @if($Tournament > 0 )
                        <form id="frm" class="form-horizontal" role="form" method="POST" action="/tour/{{$Tournament}}/tourdet/{{$Tour_Det->rule_id}}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="form-group">
                            <label for="shiftid" class="col-md-4 control-label">Select Rule</label>
                            <div class="col-md-6">
                                <select name="rule_id" class="form-control">
                                    <option  value="0" selected disabled>Select Rule</option>
                                    @foreach($Rules as $Rule)
                                        <option @if($Rule->id == $Tour_Det->rule_id) selected @endif value="{{$Rule->id}}">{{$Rule->name}}</option>
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
                                <input id="value" type="text" class="form-control" name="value" value="{{$Tour_Det->value}}" autofocus required="" > 
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
//            if(!$.isNumeric($("#rule option:selected").val())){
//                alert('Invalid Rule');
//                return;
//            }
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