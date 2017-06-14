@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Organisation Register</div>
                <div class="panel-body">
                    <form id="frm" class="form-horizontal" role="form" method="POST" action="{{route('matchmaster.store')}}">
                        {{ csrf_field() }}
                            <div class="form-group">
                            <label for="tournament_id" class="col-md-4 control-label">Tournament ID </label>
                            <div class="col-md-6">
                                <input id="tournament_id" type="text" class="form-control" name="tournament_id" value="" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="match_name" class="col-md-4 control-label">Match Name</label>
                            <div class="col-md-6">
                                <input id="match_name" type="text" class="form-control" name="match_name" value="" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="match_type" class="col-md-4 control-label">Match Type</label>
                            <div class="col-md-6">
                                <input id="match_type" type="text" class="form-control" name="match_type" value="" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="overs" class="col-md-4 control-label">Overs</label>
                            <div class="col-md-6">
                                <input id="overs" type="text" class="form-control" name="overs" value="" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="team1_id" class="col-md-4 control-label">Team 1 ID</label>
                            <div class="col-md-6">
                                <input id="team1_id" type="text" class="form-control" name="team1_id" value="" required autofocus>
                            </div>
                            </div>
                        
                        
                        
                        <div class="form-group">
                            <label for="team2_id" class="col-md-4 control-label">Team 2 ID</label>
                            <div class="col-md-6">
                                <input id="team2_id" type="text" class="form-control" name="team2_id" value="" required autofocus>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="match_date" class="col-md-4 control-label">Match Date</label>
                            <div class="col-md-6">
                                <input id="match_date" type="date" class="form-control" name="match_date" value="{{ old('match_date') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="win_toss_id" class="col-md-4 control-label">Win Toss id</label>
                            <div class="col-md-6">
                                <input id="win_toss_id" type="text" class="form-control " name="win_toss_id" value="" required>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="spoc" class="col-md-4 control-label">selected to by toss winner</label>
                            <div class="col-md-3">
                                    <input id="bat" type="radio" class="" name="selected_to_by_toss_winner" value="bat" @if( old('selected_to_by_toss_winner') == 'bat') checked @endif > BAT
                                </div>
                                <div class="col-md-3">
                                    <input id="ball" type="radio" class="" name="selected_to_by_toss_winner" value="ball" @if( old('selected_to_by_toss_winner') == 'ball') checked @endif > BALL
                                </div>
                            </div>
                            <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Add
                                </button>
                            </div>
                        </div>
                        </div>
                        </div>
                        
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection