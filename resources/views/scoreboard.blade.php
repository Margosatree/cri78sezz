@extends('master.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cric8 Scoreboard</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('store_scoreboard')}}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('TransID') ? ' has-error' : '' }}">
                            <label for="TransID" class="col-md-4 control-label">Trans Id</label>

                            <div class="col-md-6">
                                <input id="TransID" type="text" class="form-control" name="TransID" autofocus>

                                @if ($errors->has('TransID'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('TransID') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('MatchID') ? ' has-error' : '' }}">
                            <label for="MatchID" class="col-md-4 control-label">Match Id</label>

                            <div class="col-md-6">
                                <input id="MatchID" type="text" class="form-control" name="MatchID" value="{{ old('MatchID') }}" required autofocus>

                                @if ($errors->has('MatchID'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('MatchID') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('TeamID1') ? ' has-error' : '' }}">
                            <label for="TeamID1" class="col-md-4 control-label">Team ID 1</label>

                            <div class="col-md-6">
                                <input id="TeamID1" type="text" class="form-control" name="TeamID1" value="{{ old('TeamID1') }}" required autofocus>

                                @if ($errors->has('TeamID1'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('TeamID1') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('TeamID2') ? ' has-error' : '' }}">
                            <label for="TeamID2" class="col-md-4 control-label">Team ID 2</label>

                            <div class="col-md-6">
                                <input id="TeamID2" type="text" class="form-control" name="TeamID2" value="{{ old('TeamID2') }}" required autofocus>

                                @if ($errors->has('TeamID2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('TeamID2') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('Innings') ? ' has-error' : '' }}">
                            <label for="Innings" class="col-md-4 control-label">Innings</label>

                            <div class="col-md-6">
                                <input id="Innings" type="text" class="form-control" name="Innings" value="{{ old('Innings') }}" required autofocus>

                                @if ($errors->has('Innings'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Innings') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('BatsmanID') ? ' has-error' : '' }}">
                            <label for="BatsmanID" class="col-md-4 control-label">BatsmanID</label>

                            <div class="col-md-6">
                                <input id="BatsmanID" type="text" class="form-control" name="BatsmanID" value="{{ old('BatsmanID') }}" required autofocus>

                                @if ($errors->has('BatsmanID'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('BatsmanID') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('BatsmanID2') ? ' has-error' : '' }}">
                            <label for="BatsmanID2" class="col-md-4 control-label">BatsmanID 2</label>

                            <div class="col-md-6">
                                <input id="BatsmanID2" type="text" class="form-control" name="BatsmanID2" value="{{ old('BatsmanID2') }}" required autofocus>

                                @if ($errors->has('BatsmanID2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('BatsmanID2') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('BowlerID') ? ' has-error' : '' }}">
                            <label for="BowlerID" class="col-md-4 control-label">Bowler ID</label>

                            <div class="col-md-6">
                                <input id="BowlerID" type="text" class="form-control" name="BowlerID" value="{{ old('BowlerID') }}" required autofocus>

                                @if ($errors->has('BowlerID'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('BowlerID') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('FilderID') ? ' has-error' : '' }}">
                            <label for="FilderID" class="col-md-4 control-label">Filder ID</label>

                            <div class="col-md-6">
                                <input id="FilderID" type="text" class="form-control" name="FilderID" value="{{ old('FilderID') }}" required autofocus>

                                @if ($errors->has('FilderID'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('FilderID') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('BatsmanScore') ? ' has-error' : '' }}">
                            <label for="BatsmanScore" class="col-md-4 control-label">Batsman Score</label>

                            <div class="col-md-6">
                                <input id="BatsmanScore" type="text" class="form-control" name="BatsmanScore" value="{{ old('BatsmanScore') }}" required autofocus>

                                @if ($errors->has('BatsmanScore'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('BatsmanScore') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('BowlerGiven') ? ' has-error' : '' }}">
                            <label for="BowlerGiven" class="col-md-4 control-label">Bowler Given</label>

                            <div class="col-md-6">
                                <input id="BowlerGiven" type="text" class="form-control" name="BowlerGiven" value="{{ old('BowlerGiven') }}" required autofocus>

                                @if ($errors->has('BowlerGiven'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('BowlerGiven') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('ExtraRuns') ? ' has-error' : '' }}">
                            <label for="ExtraRuns" class="col-md-4 control-label">Extra Runs</label>

                            <div class="col-md-6">
                                <input id="ExtraRuns" type="text" class="form-control" name="ExtraRuns" value="{{ old('ExtraRuns') }}" required autofocus>

                                @if ($errors->has('ExtraRuns'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ExtraRuns') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('TotalRuns') ? ' has-error' : '' }}">
                            <label for="TotalRuns" class="col-md-4 control-label">Total Runs</label>

                            <div class="col-md-6">
                                <input id="TotalRuns" type="text" class="form-control" name="TotalRuns" value="{{ old('TotalRuns') }}" required autofocus>

                                @if ($errors->has('TotalRuns'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('TotalRuns') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('TeamRuns') ? ' has-error' : '' }}">
                            <label for="TeamRuns" class="col-md-4 control-label">Team Runs</label>

                            <div class="col-md-6">
                                <input id="TeamRuns" type="text" class="form-control" name="TeamRuns" value="{{ old('TeamRuns') }}" required autofocus>

                                @if ($errors->has('TeamRuns'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('TeamRuns') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('WicketCount') ? ' has-error' : '' }}">
                            <label for="WicketCount" class="col-md-4 control-label">Wicket Count</label>

                            <div class="col-md-6">
                                <input id="WicketCount" type="text" class="form-control" name="WicketCount" value="{{ old('WicketCount') }}" required autofocus>

                                @if ($errors->has('WicketCount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('WicketCount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('BallNo') ? ' has-error' : '' }}">
                            <label for="BallNo" class="col-md-4 control-label">Ball No</label>

                            <div class="col-md-6">
                                <input id="BallNo" type="text" class="form-control" name="BallNo" value="{{ old('BallNo') }}" required autofocus>

                                @if ($errors->has('BallNo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('BallNo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('BallTypeID') ? ' has-error' : '' }}">
                            <label for="BallTypeID" class="col-md-4 control-label">Ball Type ID</label>

                            <div class="col-md-6">
                                <input id="BallTypeID" type="text" class="form-control" name="BallTypeID" value="{{ old('BallTypeID') }}" required autofocus>

                                @if ($errors->has('BallTypeID'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('BallTypeID') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('BallType') ? ' has-error' : '' }}">
                            <label for="BallType" class="col-md-4 control-label">Ball Type</label>

                            <div class="col-md-6">
                                <input id="BallType" type="text" class="form-control" name="BallType" value="{{ old('BallType') }}" required autofocus>

                                @if ($errors->has('BallType'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('BallType') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('OverNo') ? ' has-error' : '' }}">
                            <label for="OverNo" class="col-md-4 control-label">Over No.</label>

                            <div class="col-md-6">
                                <input id="OverNo" type="text" class="form-control" name="OverNo" value="{{ old('OverNo') }}" required autofocus>

                                @if ($errors->has('OverNo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('OverNo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('WicketId') ? ' has-error' : '' }}">
                            <label for="WicketId" class="col-md-4 control-label">Wicket Id</label>

                            <div class="col-md-6">
                                <input id="WicketId" type="text" class="form-control" name="WicketId" value="{{ old('WicketId') }}" required autofocus>

                                @if ($errors->has('WicketId'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('WicketId') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('WicketType') ? ' has-error' : '' }}">
                            <label for="WicketType" class="col-md-4 control-label">Wicket Type</label>

                            <div class="col-md-6">
                                <input id="WicketType" type="text" class="form-control" name="WicketType" value="{{ old('WicketType') }}" required autofocus>

                                @if ($errors->has('WicketType'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('WicketType') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('WicketDesc') ? ' has-error' : '' }}">
                            <label for="WicketDesc" class="col-md-4 control-label">Wicket Desc</label>

                            <div class="col-md-6">
                                <input id="WicketDesc" type="text" class="form-control" name="WicketDesc" value="{{ old('WicketDesc') }}" required autofocus>

                                @if ($errors->has('WicketDesc'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('WicketDesc') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('Remark') ? ' has-error' : '' }}">
                            <label for="Remark" class="col-md-4 control-label">Remark</label>

                            <div class="col-md-6">
                                <input id="Remark" type="text" class="form-control" name="Remark" value="{{ old('Remark') }}" required autofocus>

                                @if ($errors->has('Remark'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Remark') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('Commentry') ? ' has-error' : '' }}">
                            <label for="Commentry" class="col-md-4 control-label">Commentry</label>

                            <div class="col-md-6">
                                <input id="Commentry" type="text" class="form-control" name="Commentry" value="{{ old('Commentry') }}" required autofocus>

                                @if ($errors->has('Commentry'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Commentry') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                             
                        

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
