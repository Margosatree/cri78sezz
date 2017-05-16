@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Match master</div>
                <div class="panel-body">
                    @if($Match->match_id > 0 )
                        <form id="frm" class="form-horizontal" role="form" method="POST" action="/tour/{{$Tournament}}/match/{{$Match->match_id}}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="form-group">
                            <label for="team1" class="col-md-4 control-label">Select Team 1</label>
                            <div class="col-md-6">
                                <select name="team1" class="form-control">
                                    <option  value="0" selected="" disabled="">Select Team</option>
                                    @foreach($Teams as $Team)
                                        <option @if($Team->id == $Match->team1_id) selected @endif value="{{$Team->id}}">{{$Team->team_name}}</option>
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
                                        <option @if($Team->id == $Match->team2_id) selected @endif value="{{$Team->id}}">{{$Team->team_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="match_name" class="col-md-4 control-label">Match Name</label>
                            <div class="col-md-6">
                                <input id="match_name" type="text" class="form-control" name="match_name" value="{{$Match->match_name}}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ground_name" class="col-md-4 control-label">Ground Name</label>
                            <div class="col-md-6">
                                <input id="ground_name" type="text" class="form-control" name="ground_name" value="{{$Match->ground_name}}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="match_type" class="col-md-4 control-label">Match Type</label>
                            <div class="col-md-6">
                                <input id="match_type" type="text" class="form-control" name="match_type" value="{{$Match->match_type}}" required autofocus>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="match_date" class="col-md-4 control-label">Match Date</label>
                            <div class="col-md-6">
                                <input id="match_date" type="date" class="form-control" name="match_date" value="{{$Match->match_date}}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="overs" class="col-md-4 control-label">Overs</label>
                            <div class="col-md-6">
                                <input id="overs" type="number" class="form-control " name="overs" value="{{$Match->overs}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="innings" class="col-md-4 control-label">Innings</label>
                            <div class="col-md-6">
                                <input id="innings" type="number" class="form-control " name="innings" value="{{$Match->innings}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-6">
                                <button type="button" style="width: 100%" onclick="Validateform();" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
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