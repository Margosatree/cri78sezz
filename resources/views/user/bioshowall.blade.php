@extends('layouts.appadmin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    @if(count($User_Bios) > 0 )
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>DOB</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>DOB</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($User_Bios as $User_Bio)
                                    <tr>
                                        <td>{{ $User_Bio->first_name .' '. $User_Bio->last_name}}</td>
                                        <td>{{ $User_Bio->date_of_birth }}</td>
                                        <td>{{ $User_Bio->gender }}</td>
                                        <td>{{ $User_Bio->email }}</td>
                                        <td>{{ $User_Bio->phone }}</td>
                                        <td>{{ $User_Bio->address.','.$User_Bio->suburb.','.$User_Bio->city.','.$User_Bio->state.','.$User_Bio->country }}</td>
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
<div id="deleteBioModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form id="deleteBio" method="" action="">
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script>
    
    function deleteBio(id){
        $('#deleteBio').attr('action', '/userBio/' + id );
        $('#deleteBioModal').modal('toggle');
    }
    $(document).ready(function() {
//        $("#example").on('load', function(e){
//            e.preventDefault();
//            alert("Hello");
//        }).trigger('load');
        $('#example').DataTable();
    } );
</script>
@endsection
