@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Match master</div>
                <div class="panel-body">
                    @if($match->match_id > 0 )
                        <form id="frm" class="form-horizontal" role="form" method="POST" action="/matchmaster/{{$match->match_id}}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        
                        <div class="form-group">
                            <label for="tournament_id" class="col-md-4 control-label">Tournament id</label>
                            <div class="col-md-6">
                                <input id="tournament_id" type="text" class="form-control" name="tournament_id" value="{{ $match->tournament_id }}" required autofocus>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="match_name" class="col-md-4 control-label">match name</label>
                            <div class="col-md-6">
                                <input id="match_name" type="text" class="form-control" name="match_name" value="{{ $match->match_name }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="match_type" class="col-md-4 control-label">match type</label>
                            <div class="col-md-6">
                                <input id="match_type" type="text" class="form-control" name="match_type" value="{{ $match->match_type }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="overs" class="col-md-4 control-label">overs</label>
                            <div class="col-md-6">
                                <input id="overs" type="text" class="form-control" name="overs" value="{{ $match->overs }}" required autofocus>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="team1_id" class="col-md-4 control-label">team1 id</label>
                            <div class="col-md-6">
                                <input id="team1_id" type="text" class="form-control" name="team1_id" value="{{ $match->team1_id }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="team2_id" class="col-md-4 control-label">team2 id</label>
                            <div class="col-md-6">
                                <input id="team2_id" type="text" class="form-control" name="team2_id" value="{{ $match->team2_id }}" required autofocus>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="match_date" class="col-md-4 control-label">match date</label>
                            <div class="col-md-6">
                                <input id="match_date" type="text" class="form-control" name="match_date" value="{{ $match->match_date }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="win_toss_id" class="col-md-4 control-label">win toss id</label>
                            <div class="col-md-6">
                                <input id="win_toss_id" type="text" class="form-control " name="win_toss_id" value="{{ $match->win_toss_id }}" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-4">
                                <button type="button" style="width: 100%" onclick="Validateform();"
                                        class="btn btn-primary">
                                    Update
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

@endsection