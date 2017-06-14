@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">User Dashboard</div>
                <div class="panel-body">
                    You are logged in As User!
                </div>
                @if(Session::has('message'))
                    <div class="panel-body ">
                        {{ Session::get('message') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
