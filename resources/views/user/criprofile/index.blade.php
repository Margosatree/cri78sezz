@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-20">
            <div class="panel panel-default">
                <div class="panel-heading">Cricket Profile List</div>
                <div class="panel-body">
                    @if(count($Cri_Profiles) > 0 )
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>Batsman Style</th>
                                    <th>Batsman Order</th>
                                    <th>Bowler Style</th>
                                    <th>Player Type</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($Cri_Profiles as $Cri_Profile)
                                    <tr>
                                        <td>{{ $Cri_Profile->your_role}}</td>
                                        <td>{{ $Cri_Profile->batsman_style }}</td>
                                        <td>{{ $Cri_Profile->batsman_order }}</td>
                                        <td>{{ $Cri_Profile->bowler_style }}</td>
                                        <td>{{ $Cri_Profile->player_type }}</td>
                                        <td>{{ $Cri_Profile->description }}</td>
                                        <td>
                                            <a href="criProfile/{{$Cri_Profile->id}}/edit" class="btn btn-info">
                                               <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info">
                            <b>No Post Found</b>
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