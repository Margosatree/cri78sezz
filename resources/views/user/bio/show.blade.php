@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Bio</div>
                <div class="panel-body">
                    <div  class="alert alert-success">
                        <lable><h3 style="display:inline;">{{ $Bio->first_name.' '.$Bio->middle_name.' '.$Bio->last_name }}</h3>&nbsp;<span>{{ $Bio->username }}</span>
                            <a href="/userBio/{{ $Bio->id }}/edit"><span class="badge pull-right"><i class="fa fa-pencil"></i></span></a>
                        </lable>
                        
                        <br><lable><b>DOB : </b></lable>{{$Bio->date_of_birth}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<lable><b>Gender : </b></lable>{{$Bio->gender}}
                        <br><lable><b>Phone : </b></lable>{{$Bio->phone}} @if($Bio->is_verify_phone)<i class="fa fa-check-circle"></i>@else<i class="fa fa-times-circle"></i>@endif
                        <br><lable><b>Email : </b></lable>{{$Bio->email}} @if($Bio->is_verify_phone)<i class="fa fa-check-circle"></i>@else<i class="fa fa-times-circle"></i>@endif
                        <br><lable><b>Address : </b></lable>{{$Bio->address.','.$Bio->suburb.','.$Bio->city.'('.$Bio->pin.')'}}
                        <br><lable><b>State : </b></lable>{{$Bio->state}} 
                        <br><lable><b>Country : </b></lable>{{$Bio->country}} 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection