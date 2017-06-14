@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-20">
            <div class="panel panel-default">
                <div class="panel-heading">Rules List</div>
                <div class="panel-body">
                    @if(count($Rules) > 0 )
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Specification</th>
                                    <th>Value</th>
                                    <th>Range From</th>
                                    <th>Range To</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($Rules as $Rule)
                                    <tr>
                                        <td>
                                            <b>{{ $Rule->name }}</b>
                                        </td>
                                        <td>{{ $Rule->specification }}</td>
                                        <td>{{ $Rule->value }}</td>
                                        <td>{{ $Rule->range_from }}</td>
                                        <td>{{ $Rule->range_to }}</td>
                                        <td>
                                            <a href="tournament/{{$Rule->id}}/edit" class="btn btn-info">
                                               <span ><i class="fa fa-pencil"></i></span>
                                            </a>
                                            <a href="tournament/{{$Rule->id}}/edit" class="btn btn-info">
                                               <span ><i class="fa fa-times"></i></span>
                                            </a>
                                            <a href="rule" class="btn btn-info">
                                               <span ><i class="fa fa-list"></i></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info">
                            <lable><h3 style="display:inline;">No Rules Found </h3>
                                <a href="{{route('rule.create')}}"><span class="badge pull-right"><i class="fa fa-plus"></i></span></a>
                            </lable>
                        </div> 
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
//        $.noConflict(function() {
            $('#example').DataTable();
//        });
    } );
</script>

@endsection