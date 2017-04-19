@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    @if($Cri_Profile->id > 0 )
                        <form class="form-horizontal" role="form" method="POST" action="/criProfile/{{$Cri_Profile->id}}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="form-group">
                                <label for="shiftid" class="col-md-4 control-label">Select Role</label>
                                <div class="col-md-6">
                                    <select name="your_role" class="form-control">
                                        <option  value="1">Bowller</option>
                                        <option  value="2">BatsMan</option>
                                        <option  value="3">AllRounder</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">Batsman Style</label>
                                <div class="col-md-offset-4">
                                    <div class="col-md-3">
                                        <input id="Lefthand" type="radio" class="" name="batsman_style" value="Lefthand" > Lefthand
                                    </div>
                                    <div class="col-md-3">
                                        <input id="Righthand" type="radio" class="" name="batsman_style" value="Righthand" > Righthand
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="batsman_order" class="col-md-4 control-label">Batsman Order</label>
                                <div class="col-md-6">
                                    <input id="batsman_order" type="number" min="1" max="12" class="form-control" name="batsman_order" value="{{$Cri_Profile->batsman_order}}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">Bowler Style</label>
                                <div class="col-md-offset-4">
                                    <div class="col-md-3">
                                        <input id="Lefthand" type="radio" class="" name="bowler_style" value="Lefthand" > Lefthand
                                    </div>
                                    <div class="col-md-3">
                                        <input id="Righthand" type="radio" class="" name="bowler_style" value="Righthand" > Righthand
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="player_type" class="col-md-4 control-label">Player Type</label>
                                <div class="col-md-6">
                                    <input id="player_type" type="text" class="form-control" name="player_type" value="{{$Cri_Profile->player_type}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-md-4 control-label">Description</label>
                                <div class="col-md-6">
                                    <input id="description" type="text" class="form-control" name="description" value="{{$Cri_Profile->description}}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" style="width: 100%" class="btn btn-primary">
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



@endsection