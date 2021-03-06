@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>
                <div class="panel-body">
                    @if(count($Bio) > 0)
                            
                            <div  class="alert alert-success ">
                            <div  class="row ">
                                @if(Session::has('user_img'))
                                    <div class="col-md-2">
                                        <img src ="{{asset('images/'.Session::get('user_img'))}}" style="width: 100%;height: 100%" class="img-rounded"/>
                                    </div>
                                @else
                                    <div class="col-md-2">
                                        <img src ="{{asset('images/default128_128.png')}}" style="width: 100%;height: 100%" class="img-rounded"/>
                                    </div>
                                @endif
                                <div class="col-md-10">
                                    <lable><h3 style="display:inline;">{{ $Bio->first_name.' '.$Bio->middle_name.' '.$Bio->last_name  }}</h3>&nbsp;<span>{{ $Bio->username }}</span>
                                        <a href="/userBio/{{ $Bio->id }}/editInfo"><span class="badge pull-right"><i class="fa fa-pencil"></i></span></a>
                                    </lable>
                                    <br><lable><b>DOB : </b></lable>{{$Bio->date_of_birth}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<lable><b>Gender : </b></lable>{{$Bio->gender}}
                                    <br><lable><b>Phone : </b></lable>{{$Bio->phone}} @if($Bio->is_verify_phone)<i class="fa fa-check-circle"></i>@else<i class="fa fa-times-circle"></i>@endif
                                    <br><lable><b>Email : </b></lable>{{$Bio->email}} @if($Bio->is_verify_phone)<i class="fa fa-check-circle"></i>@else<i class="fa fa-times-circle"></i>@endif
                                </div>
                            </div>
                                
                            </div>
                        <div  class="alert alert-success">
                            <lable><h3 style="display:inline;">Personal Info</h3>
                                <a href="/userBio/{{ $Bio->id }}/edit"><span class="badge pull-right"><i class="fa fa-pencil"></i></span></a>
                            </lable>
                            <br><lable><b>Address : </b></lable>{{$Bio->address.','.$Bio->suburb.','.$Bio->city.'('.$Bio->pin.')'}}
                            <br><lable><b>State : </b></lable>{{$Bio->state}} 
                            <br><lable><b>Country : </b></lable>{{$Bio->country}} 
                        </div>
                    @else
                        <div  class="alert alert-success">
                            <lable><h3 style="display:inline;">Bio Is Not Available Please Add</h3>
                                <a href="{{route('userBio.create')}}"><span class="badge pull-right"><i class="fa fa-plus"></i></span></a>
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
                                    <a href="{{route('org.create')}}"><span class="badge pull-right"><i class="fa fa-plus"></i></span></a>
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
                        @if(Auth::user()->role == "user")
                            <hr>
                            <div  class="alert alert-success">
                                <lable><h3 style="display:inline;">Cric8profile Not Available Please Add</h3>
                                    <a href="{{route('criProfile.create')}}"><span class="badge pull-right"><i class="fa fa-plus"></i></span></a>
                                </lable>
                            </div>
                        @endif
                    @endif
                    @if(count($User_Achieves) > 0)
                        <hr>
                        
                        <div  class="alert alert-success">
                            <lable><h3 style="display:inline;">Achievement's</h3>
                                <a href="{{route('userAchieve.create')}}"><span class="badge pull-right"><i class="fa fa-plus"></i></span></a>
                            </lable>
                            <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Title</th>
                                        <th>Location</th>
                                        <th>Time Period</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($User_Achieves as $User_Achieve)
                                        <tr>
                                            <td>{{ ++$Sr }}</td>
                                            <td>{{ $User_Achieve->title }}</td>
                                            <td>{{ $User_Achieve->title }}</td>
                                            <td>{{ $User_Achieve->location }}</td>
                                            <td>{{ $User_Achieve->start_date.' To '. $User_Achieve->end_date}}</td>
                                            <td>
                                                <a onclick="deleteAchievement({{$User_Achieve->id}})">
                                                   <span class="badge pull-right"><i class="fa fa-times"></i></span>
                                                </a>
                                                <a href="/userAchieve/{{$User_Achieve->id}}/edit">
                                                   <span class="badge pull-right"><i class="fa fa-pencil"></i></span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        @if(Auth::user()->role == "user")
                            <hr>
                            <div  class="alert alert-success">
                                <lable><h3 style="display:inline;">Achievement Not Available Please Add</h3>
                                    <a href="{{route('userAchieve.create')}}"><span class="badge pull-right"><i class="fa fa-plus"></i></span></a>
                                </lable>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div id="deleteAchieveModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form id='deleteAchieve' method="post" action="">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Achievement</h4>
                </div>
                <div class="modal-body">
                    <div class="Achieve">
                        <div class="row">
                            <div class="col-md-12">
                                Are You Sure you Want To Delete This Achievement?
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" style="min-width: 80px;">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function deleteAchievement(Achieve_id){
        $('#deleteAchieve').attr('Action', '/userAchieve/' + Achieve_id);
        $('#deleteAchieveModal').modal('toggle');
    }
</script>
@endsection