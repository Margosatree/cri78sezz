@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Match Master</div>
                <div class="panel-body">
                    <div  class="alert alert-success">
                        <br><lable><b>Tournament ID : </b></lable>{{$match->tournament_id}}
                        <br><lable><b>match name : </b></lable>{{$match->match_name}}<br>
                        <br><lable><b>ground name : </b></lable>{{$match->ground_name}}
                        <br><lable><b>match type : </b></lable>{{$match->match_type}}
                        <br><lable><b>overs : </b></lable>{{$match->overs}}
                        <br><lable><b>innings : </b></lable>{{$match->innings}}
                        <br><lable><b>status : </b></lable>{{$match->status}}
                        <br><lable><b>toss : </b></lable>{{$match->toss}}
                        <br><lable><b>team1 id : </b></lable>{{$match->team1_id}}
                        <br><lable><b>team2 id : </b></lable>{{$match->team2_id}}
                        <br><lable><b>location : </b></lable>{{$match->location}}
                        <br><lable><b>match date : </b></lable>{{$match->match_date}}
                        <br><lable><b>ttl overs : </b></lable>{{$match->ttl_overs}}
                        <br><lable><b>ttl player : </b></lable>{{$match->ttl_player_each_cnt}}
                        <br><lable><b>win toss : </b></lable>{{$match->win_toss_id}}
                        <br><lable><b>toss winner : </b></lable>{{$match->selected_to_by_toss_winner}}
                        <br><lable><b>inning 1 : </b></lable>{{$match->inning_1}}
                        <br><lable><b>inning 2 : </b></lable>{{$match->inning_2}}
                        <br><a href="{{url('matchmaster/'.$match->match_id.'/edit')}}"> edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection