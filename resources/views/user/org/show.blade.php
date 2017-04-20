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
                        <br><lable><h4 style="display:inline;">{{ $Org->name }}</h4>&nbsp;<i class="fa fa-check-circle"></i>
                            <a href="/org/{{ $Org->id }}/edit"><span class="badge pull-right"><i class="fa fa-pencil"></i></span></a>
                        </lable>
                        
                        <br><lable><b>Spoc : </b></lable>{{$Org->spoc}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <br><lable><b>Business Type : </b></lable>{{$Org->business_type}} 
                        <br><lable><b>Business Operation : </b></lable>{{$Org->business_operation}} 
                        <br><lable><b>Address : </b></lable>{{$Org->address.','.$Org->landmark.','.$Org->city.'('.$Org->pincode.')'}}
                        <br><lable><b>State : </b></lable>{{$Org->state}} 
                        <br><lable><b>Country : </b></lable>{{$Org->country}} 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection