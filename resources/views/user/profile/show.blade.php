@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>
                <div class="panel-body">
                    @if(count($Bio) > 0)
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
                    @else
                        <div  class="alert alert-success">
                            <lable><h3 style="display:inline;">Bio Is Not Available Please Add</h3>
                                <a href="{{route('userBio.create')}}"><span class="badge pull-right"><i class="fa fa-pencil"></i></span></a>
                            </lable>
                        </div>
                    @endif
                    @if(Auth::user()->role == "organizer")
                        @if(count($Org) > 0)
                            <hr>
                            <div  class="alert alert-success">
                                <lable><h3 style="display:inline;">{{ $Org->name }}</h3>&nbsp;@if($Org->is_verified)<i class="fa fa-check-circle"></i>@else<i class="fa fa-times-circle"></i>@endif
                                    <a href="/org/{{ $Org->id }}/edit"><span class="badge pull-right"><i class="fa fa-pencil"></i></span></a>
                                </lable>
                                <br><lable><b>Spoc : </b></lable>{{$Org->spoc}}
                                <br><lable><b>Business Type : </b></lable>{{$Org->business_type}} 
                                <br><lable><b>Business Operation : </b></lable>{{$Org->business_operation}} 
                                <br><lable><b>Address : </b></lable>{{$Org->address.','.$Org->landmark.','.$Org->city.'('.$Org->pincode.')'}}
                                <br><lable><b>State : </b></lable>{{$Org->state}} 
                                <br><lable><b>Country : </b></lable>{{$Org->country}} 
                            </div>
                        @else
                            <hr>
                            <div  class="alert alert-success">
                                <lable><h3 style="display:inline;">Organisation Info Not Available Please Add</h3>
                                    <a href="{{route('org.create')}}"><span class="badge pull-right"><i class="fa fa-pencil"></i></span></a>
                                </lable>
                            </div>
                        @endif
                    @endif
                    @if(count($Cri_Profile) > 0)
                        <hr>
                        <div  class="alert alert-success">
                            <lable><h3 style="display:inline;">Cric8profile</h3>
                                <a href="/criProfile/{{ $Cri_Profile->id }}/edit"><span class="badge pull-right"><i class="fa fa-pencil"></i></span></a>
                            </lable>
                            <br><lable><b>Role : </b></lable>
                            @if($Cri_Profile->your_role == 1)
                                Bowller
                            @elseif($Cri_Profile->your_role == 2)
                                BatsMan
                            @elseif($Cri_Profile->your_role == 3)
                                WicketKeeper
                            @elseif($Cri_Profile->your_role == 4)
                                AllRounder
                            @endif
                            <br><lable><b>Bating Style : </b></lable>{{$Cri_Profile->batsman_style}}
                            <br><lable><b>Bowling Style : </b></lable>{{$Cri_Profile->bowler_style}}
                            <br><lable><b>Player Type : </b></lable>{{$Cri_Profile->player_type}}
                            <br><lable><b>Batsman Order : </b></lable>{{$Cri_Profile->batsman_order}}
                            <br><lable><b>Description : </b></lable>{{$Cri_Profile->description}} 
                        </div>
                    @else
                        <div  class="alert alert-success">
                            <lable><h3 style="display:inline;">Cric8profile Not Available Please Add</h3>
                                <a href="{{route('criProfile.create')}}"><span class="badge pull-right"><i class="fa fa-pencil"></i></span></a>
                            </lable>
                        </div>
                        <hr>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection