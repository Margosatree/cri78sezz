@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-20">
            <div class="panel panel-default">
                <div class="panel-heading" style="padding: 15px">
                    <h3 style="display:inline;">Team List</h3>
                    <a href="/team/create"><span class=" pull-right btn btn-info">Add Team <i class="fa fa-plus"></i></span></a>
                </div>
                <div class="panel-body">
                    @if(count($Teams) > 0 )
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Owner</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($Teams as $Team)
                                    <tr>
                                        <td>
                                            <img src ="{{asset('images/'.$Team->team_logo)}}" style="width: 30%;height: 30%" class="img-rounded"/>
                                            <b>{{ $Team->team_name }}</b>
                                        </td>
                                        <td>{{ $Team->owner->first_name." ".$Team->owner->last_name }}</td>
                                        <td>{{ $Team->team_type }}</td>
                                        <td>
                                            <a href="/team/{{$Team->id}}/edit" class="btn btn-info">
                                               <span ><i class="fa fa-pencil"></i></span>
                                            </a>
                                            <a onclick="deleteEntry({{$Team->id}})" class="btn btn-info">
                                               <span ><i class="fa fa-times"></i></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info">
                            <lable><h3 style="display:inline;">No Team's Found </h3>
                            </lable>
                        </div> 
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form id='deleteFrm' method="Post" action="">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Team</h4>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="row">
                            <div class="col-md-12">
                                Are You Sure you Want To Delete This Team
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" style="min-width: 80px;">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
//        $.noConflict(function() {
            $('#example').DataTable();
//        });
    } );
    
    function deleteEntry(tour){
        $('#deleteFrm').attr('Action', '/team/'+tour);
        $('#deleteModal').modal('toggle');
    }
</script>

@endsection