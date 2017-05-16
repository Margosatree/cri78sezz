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
                                <select name="team1" class="form-control">
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
                                <select name="team2" class="form-control">
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
//        if($('#title').val() == "" || $('#title').val() == "undefined" || $('#title').val() == "NaN"){
//            alert('Please Enter Title');
//            return;
//        }else{
//            if($("#title").val().length > 50){
//                alert('Title Is Too Long');
//                return;
//            }
//        }
//        if($('#name').val() == "" || $('#name').val() == "undefined" || $('#name').val() == "NaN"){
//            alert('Please Select Role');
//            return;
//        }else{
//            
//        }
//        if($('#start_date').val() == "" || $('#start_date').val() == "undefined" || $('#start_date').val() == "NaN"){
//            alert('Please Select Role');
//            return;
//        }
//        if($('#end_date').val() == "" || $('#end_date').val() == "undefined" || $('#end_date').val() == "NaN"){
//            alert('Please Select Role');
//            return;
//        }
//        var StartDate = new Date(Date.parse($("#start_date").val()));
//        var EndDate = new Date(Date.parse($("#end_date").val()));
//        console.log(EndDate+' '+StartDate);
//        console.log(EndDate >= StartDate);
//        if (!(EndDate >= StartDate)) {
//            alert('Start Date Lesser Then Or Equal To End Date');
//            return;
//        }
//        if($('#location').val() == "" || $('#location').val() == "undefined" || $('#location').val() == "NaN"){
//            alert('Please Enter Location');
//            return;
//        }else{
//            if($("#location").val().length > 50){
//                alert('Location Is Too Long');
//                return;
//            }
//        }
        document.getElementById('frm').submit();
    }
</script>
@endsection