@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cricket Profile</div>
                <div class="panel-body">
                    <div  class="alert alert-success">
                        <lable><h3 style="display:inline;">{{ $Bio->first_name.' '.$Bio->middle_name.' '.$Bio->last_name }}</h3>&nbsp;<span>{{ $Bio->username }}</span>&nbsp;<i class="fa fa-check-circle"></i>
                            <a href="/criProfile/{{ $Cri_Profile->id }}/edit"><span class="badge pull-right"><i class="fa fa-pencil"></i></span></a>
                        </lable>
                        
                        <br><lable><b>Bating Style : </b></lable>{{$Cri_Profile->batsman_style}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <br><lable><b>Bowling Style : </b></lable>{{$Cri_Profile->bowler_style}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <br><lable><b>Player Type : </b></lable>{{$Cri_Profile->player_type}}
                        <br><lable><b>Batsman Order : </b></lable>{{$Cri_Profile->batsman_order}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <br><lable><b>Description : </b></lable>{{$Cri_Profile->description}} 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection