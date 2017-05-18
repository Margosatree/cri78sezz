@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Add Match</div>
                <div class="panel-body">
                    <form id="frm" class="form-horizontal" role="form" method="POST" action="/tour/{{$Tournament}}/match">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="team1" class="col-md-4 control-label">Select Team 1</label>
                            <div class="col-md-6">
                                <select id="team1" name="team1" class="form-control">
                                    <option  value="0" selected="" disabled="">Select Team</option>
                                    @foreach($Teams as $Team)
                                        <option  value="{{$Team->id}}">{{$Team->team_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('your_role'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('your_role') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="team2" class="col-md-4 control-label">Select Team 2</label>
                            <div class="col-md-6">
                                <select id="team2" name="team2" class="form-control">
                                    <option  value="0" selected="" disabled="">Select Team</option>
                                    @foreach($Teams as $Team)
                                        <option  value="{{$Team->id}}">{{$Team->team_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="match_name" class="col-md-4 control-label">Match Name</label>
                            <div class="col-md-6">
                                <input id="match_name" type="text" class="form-control" name="match_name" value="{{ old('match_name') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ground_name" class="col-md-4 control-label">Ground Name</label>
                            <div class="col-md-6">
                                <input id="ground_name" type="text" class="form-control" name="ground_name" value="{{ old('ground_name') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="match_type" class="col-md-4 control-label">Match Type</label>
                            <div class="col-md-6">
                                <input id="match_type" type="text" class="form-control" name="match_type" value="{{ old('match_type') }}" required autofocus>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="match_date" class="col-md-4 control-label">Match Date</label>
                            <div class="col-md-6">
                                <input id="match_date" type="date" class="form-control" name="match_date" value="{{ old('match_date') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="overs" class="col-md-4 control-label">Overs</label>
                            <div class="col-md-6">
                                <input id="overs" type="number" class="form-control " name="overs" value="{{ old('overs') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="innings" class="col-md-4 control-label">Innings</label>
                            <div class="col-md-6">
                                <input id="innings" type="number" class="form-control " name="innings" value="{{ old('innings') }}" required>
                            </div>
                        </div>
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
        if($('#team1 option:selected').val() == "" || $('#team1 option:selected').val() == "undefined" || $('#team1 option:selected').val() == "NaN"){
            alert('Please Select Team 1');
            return;
        }else{
            if($('#team1 option:selected').val() == $('#team2 option:selected').val()){
                alert('Please Select Another Team');
            }
        }
        if($('#team2 option:selected').val() == "" || $('#team2 option:selected').val() == "undefined" || $('#team2 option:selected').val() == "NaN"){
            alert('Please Select Team 2');
            return;
        }else{
        }
        if($('#match_name').val() == "" || $('#match_name').val() == "undefined" || $('#match_name').val() == "NaN"){
            alert('Please Enter Match Name');
            return;
        }else{
            var Reg = new RegExp(/^[a-zA-Z0-9]+$/i);
            if (!Reg.test($('#match_name').val())) {
                alert('Please Enter Valid Match Name');
                return;
            }
        }
        if($('#ground_name').val() == "" || $('#ground_name').val() == "undefined" || $('#ground_name').val() == "NaN"){
            alert('Please Enter Match Name');
            return;
        }else{
            var Reg = new RegExp(/^[A-Za-z _.-]+$/);
            if (!Reg.test($('#ground_name').val())) {
                alert('Please Enter Valid Ground Name');
                return;
            }
        }
        if($('#match_date').val() == "" || $('#match_date').val() == "undefined" || $('#match_date').val() == "NaN"){
            alert('Please Select Role');
            return;
        }
        if($('#overs').val() == "" || $('#overs').val() == "undefined" || $('#overs').val() == "NaN"){
            alert('Please Enter Overs');
            return;
        }else{
            if(!$.isNumeric($("#overs").val())){
                alert('Please Enter Valid Overs');
                return;
            }
        }
        if($('#overs').val() == "" || $('#overs').val() == "undefined" || $('#overs').val() == "NaN"){
            alert('Please Enter Overs');
            return;
        }else{
            if(!$.isNumeric($("#overs").val())){
                alert('Please Enter Valid Overs');
                return;
            }
        }
        if($('#innings').val() == "" || $('#innings').val() == "undefined" || $('#innings').val() == "NaN"){
            alert('Please Enter Innings');
            return;
        }else{
            if(!$.isNumeric($("#innings").val())){
                alert('Invalid Innings');
                return;
            }
        }
        document.getElementById('frm').submit();
    }
    $( "#team1" ).change(function() {
        $('#team2 > option').each(function () {
            $(this).show();
            if($("#team1 option:selected").val() === $(this).val()){
                $(this).hide();
            }
        });
    });
    $( "#team2" ).change(function() {
        $('#team1 > option').each(function () {
            $(this).show();
            if($("#team2 option:selected").val() === $(this).val()){
                $(this).hide();
            }
        });
    });
</script>
@endsection