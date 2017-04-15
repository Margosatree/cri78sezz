@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/criProfile/update">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('your_role') ? ' has-error' : '' }}">
                            <label for="shiftid" class="col-md-4 control-label">Select Role</label>
                                <div class="col-md-6">
                                    <select name="your_role" class="form-control">
                                        <option  value="1">Bowller</option>
                                        <option  value="2">BatsMan</option>
                                        <option  value="3">AllRounder</option>
                                    </select>
                                    @if ($errors->has('your_role'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('your_role') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('batsman_style') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Batsman Style</label>
                            
                            <div class="col-md-offset-4">
                                <div class="col-md-3">
                                    <input id="Lefthand" type="radio" class="" name="batsman_style" value="Lefthand" > Lefthand

                                    @if ($errors->has('batsman_style'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('batsman_style') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <input id="Righthand" type="radio" class="" name="batsman_style" value="Righthand" > Righthand

                                    @if ($errors->has('batsman_style'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('batsman_style') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('batsman_order') ? ' has-error' : '' }}">
                            <label for="batsman_order" class="col-md-4 control-label">Batsman Order</label>
                            <div class="col-md-6">
                                <input id="batsman_order" type="number" min="1" max="12" class="form-control" name="batsman_order" value="{{ old('batsman_order') }}" required autofocus>
                                @if ($errors->has('batsman_order'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('batsman_order') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('bowler_style') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Bowler Style</label>
                            
                            <div class="col-md-offset-4">
                                <div class="col-md-3">
                                    <input id="Lefthand" type="radio" class="" name="bowler_style" value="Lefthand" > Lefthand

                                    @if ($errors->has('bowler_style'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('bowler_style') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <input id="Righthand" type="radio" class="" name="bowler_style" value="Righthand" > Righthand

                                    @if ($errors->has('bowler_style'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('bowler_style') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('player_type') ? ' has-error' : '' }}">
                            <label for="player_type" class="col-md-4 control-label">Player Type</label>
                            <div class="col-md-6">
                                <input id="player_type" type="text" class="form-control" name="player_type" value="{{ old('player_type') }}" required>
                                @if ($errors->has('country'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('player_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Description</label>
                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description" value="{{ old('description') ? old('description') :  }}" required>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-4">
                                <button type="submit" style="width: 100%" class="btn btn-primary">
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

<script>
    @if($Cri_Profile->your_role == 1){
        alert('DASDAS');
    }
</script>
@endsection