@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-20 ">
            <div class="panel panel-default">
                <div class="panel-heading">Organization List</div>
                <div class="panel-body">
                    @if(count($Orgs) > 0 )
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Business Type</th>
                                    <th>Business Operation</th>
                                    <th>Spoc</th>
                                    <th>Address</th>
                                    <th>verified</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($Orgs as $Org)
                                    <tr>
                                        <td>{{ $Org->name }}</td>
                                        <td>{{ $Org->business_type }}</td>
                                        <td>{{ $Org->business_operation }}</td>
                                        <td>{{ $Org->spoc }}</td>
                                        <td>{{ $Org->address.','.$Org->pincode.','.$Org->landmark.','.$Org->city.','.$Org->state.','.$Org->country }}</td>
                                        <td>{{ $Org->is_verified }}</td>
                                        <td>
                                            <a href="org/{{$Org->id}}/edit" class="btn btn-info">
                                               <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info">
                            <b>No Organization Found</b>
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
            <form id="delete-content" method="" action="">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Post</h4>
                </div>
                <div class="modal-body">
                    <div class="comment">
                        <div class="row">
                            <div class="col-md-12">
                                Are You Sure you Want To Delete This Post
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" style="min-width: 80px;">Yes</button>
                    <button type="button" class="btn btn-default" style="min-width: 80px;" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    
    function deleteBio(id){
        $('#deleteBio').attr('action', '/userBio/' + id );
        $('#deleteBioModal').modal('toggle');
    }
    
</script>
<script>
    $(document).ready(function() {
//        $.noConflict(function() {
            $('#example').DataTable();
//        });
    } );
    $(document).on('click', '.edit-modal', function() {
        var stuff = $(this).data('info').split(',');
        fillmodalData(stuff);
        $('#edit-content').attr('Action', '/userBio/' + stuff[0]);
        $('#editModal').modal('show');
    });
    $(document).on('click', '.delete-modal', function() {
        var stuff = $(this).data('info');
        alert(stuff);
        $('#delete-content').attr('Action', '/userBio/' + stuff);
        $('#deleteModal').modal('show');
    });
    
    function fillmodalData(details){
        $('#id').val(details[0]);
        $('#first_name').val(details[1]);
        $('#middle_name').val(details[2]);
        $('#last_name').val(details[3]);
        $('#date_of_birth').val(details[4]);
//        $('#gender').val(details[5]);
//        $('#physically_challenged').val(details[6]);
        $('#phone').val(details[7]);
        $('#email').val(details[8]);
        $('#username').val(details[9]);
        $('#address').val(details[10]);
        $('#suburb').val(details[11]);
        $('#city').val(details[12]);
        $('#state').val(details[13]);
        $('#country').val(details[14]);
        $('#pin').val(details[15]);
    }

</script>
@endsection
