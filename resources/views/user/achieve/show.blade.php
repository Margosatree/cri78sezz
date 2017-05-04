@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Organization Info</div>
                <div class="panel-body">
                    <div  class="alert alert-success">
                        <lable><h3 style="display:inline;">{{ $Bio->first_name.' '.$Bio->middle_name.' '.$Bio->last_name }}</h3>&nbsp;<span>{{ $Bio->username }}</span>
                        </lable>
                        <br><lable><h4 style="display:inline;">{{ $User_Achieve->title }}</h4>
                            <a href="/userAchieve/{{ $User_Achieve->id }}/edit"><span class="badge pull-right"><i class="fa fa-pencil"></i></span></a>
                        </lable>
                        
                        <br><lable><b>Location : </b></lable>{{$User_Achieve->location}}
                        <br><lable><b>Time Period : </b></lable>{{$User_Achieve->start_date}} &nbsp;&nbsp;To&nbsp;&nbsp;{{$User_Achieve->end_date}} 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection