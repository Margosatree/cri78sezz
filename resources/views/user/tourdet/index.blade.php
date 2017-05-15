@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-20">
            <div class="panel panel-default">
                <div class="panel-heading" style="padding: 15px">
                    <h3 style="display:inline;">Rules List</h3>
                    <a href="/tour/{{ $Tournament }}/tourdet/create"><span class=" pull-right btn btn-info">Add Rule <i class="fa fa-plus"></i></span></a>
                </div>
                <div class="panel-body">
                    @if(count($Tour_Dets) > 0 )
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Specification</th>
                                    <th>Value</th>
                                    <th>Range From</th>
                                    <th>Range To</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($Tour_Dets as $Tour_Det)
                                    <tr>
                                        <td>
                                            <b>{{ $Tour_Det->rules->name }}</b>
                                        </td>
                                        <td>{{ $Tour_Det->specification }}</td>
                                        <td>{{ $Tour_Det->value }}</td>
                                        <td>{{ $Tour_Det->range_from }}</td>
                                        <td>{{ $Tour_Det->range_to }}</td>
                                        <td>
                                            <a href="/tour/{{ $Tournament }}/tourdet/{{$Tour_Det->rule_id}}/edit" class="btn btn-info">
                                               <span ><i class="fa fa-pencil"></i></span>
                                            </a>
                                            <a onclick="deleteEntry({{$Tournament.','.$Tour_Det->rule_id}})" class="btn btn-info">
                                                <span ><i class="fa fa-times"></i></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info">
                            <lable><h3 style="display:inline;">No Rules Found </h3>
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
                    <h4 class="modal-title">Delete Comment</h4>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="row">
                            <div class="col-md-12">
                                Are You Sure you Want To Delete This Rule
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
    
    function deleteEntry(tour,tourdet){
        $('#deleteFrm').attr('Action', '/tour/'+tour+'/tourdet/'+tourdet);
        $('#deleteModal').modal('toggle');
    }
</script>

@endsection