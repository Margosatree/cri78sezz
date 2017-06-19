@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-20">
            <div class="panel panel-default">
                <div class="panel-heading" style="padding: 15px">
                    <h3 style="display:inline;">Tournament List</h3>
                    <a href="tourmst/create"><span class=" pull-right btn btn-info">Add Tournament <i class="fa fa-plus"></i></span></a>
                </div>
                <div class="panel-body">
                    @if(count($Tournaments) > 0 )
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Reg. Period</th>
                                    <th>Time Period</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($Tournaments as $Tournament)
                                    <tr>
                                        <td>
                                            <img src ="{{asset('images/'.$Tournament->tournament_logo)}}" style="width: 30%;height: 30%" class="img-rounded"/>
                                            <b>{{ $Tournament->tournament_name }}</b>
                                        </td>
                                        <td>{{ $Tournament->tournament_location }}</td>
                                        <td>{{ $Tournament->start_date.' to '.$Tournament->end_date }}</td>
                                        <td>{{ $Tournament->reg_start_date.' to '.$Tournament->reg_end_date }}</td>
                                        <td>
                                            <a href="/tourmst/{{$Tournament->id}}/edit" class="btn btn-info">
                                               <span ><i class="fa fa-pencil"></i></span>
                                            </a>
                                            <a onclick="deleteEntry({{$Tournament->id}})" class="btn btn-info">
                                               <span ><i class="fa fa-times"></i></span>
                                            </a>
                                            <a href="/tour/{{$Tournament->id}}/tourdet" class="btn btn-info">
                                               <span >Rules</span>
                                            </a>
                                            <a href="/tour/{{$Tournament->id}}/match" class="btn btn-info">
                                               <!--<span ><i class="fa fa-list"></i></span>-->
                                               <span >Match</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info">
                            <b>No Tournament Found</b>
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
                    <h4 class="modal-title">Delete Comment</h4>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="row">
                            <div class="col-md-12">
                                Are You Sure you Want To Delete This Tournament
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
        $('#deleteFrm').attr('Action', '/tourmst/'+tour);
        $('#deleteModal').modal('toggle');
    }
</script>

@endsection