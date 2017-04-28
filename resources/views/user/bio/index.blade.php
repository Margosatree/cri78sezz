@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-20 ">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    @if(count($User_Bios) > 0 )
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 20%">Name</th>
                                    <th style="width: 10%">DOB</th>
                                    <th style="width: 10%">Gender</th>
                                    <th style="width: 10%">Email</th>
                                    <th style="width: 10%">Phone</th>
                                    <th style="width: 25%">Address</th>
                                    <th style="width: 15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($User_Bios as $User_Bio)
                                    <tr>
                                        <td style="width: 20%">{{ $User_Bio->first_name .' '. $User_Bio->middle_name .' '. $User_Bio->last_name}}</td>
                                        <td style="width: 10%">{{ $User_Bio->date_of_birth }}</td>
                                        <td style="width: 10%">{{ $User_Bio->gender }}</td>
                                        <td style="width: 10%">{{ $User_Bio->email }}</td>
                                        <td style="width: 10%">{{ $User_Bio->phone }}</td>
                                        <td style="width: 25%">{{ $User_Bio->address.', '.$User_Bio->suburb.', '.$User_Bio->city.', '.$User_Bio->state.', '.$User_Bio->country }}</td>
                                        <td style="width: 15%">
                                            <a href="userBio/{{$User_Bio->id}}/edit" class="btn btn-info">
                                               <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                            <a href="pass/{{$User_Bio->id}}/adminrequest" class="btn btn-info">
                                                <span  class="glyphicon glyphicon-user"></span>
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
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form id="edit-content" method="Post" action="">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit UserBio</h4>
                </div>
                <div class="modal-body">
                    <!--<div class="comment">-->
                        <div class="row">
                            <div class="row">
                                <div class="from-group col-md-6">
                                    <label for="username" class="col-md-6 control-label">User Name</label>
                                    <div class="col-md-12">
                                        <input id="username" type="text" class="form-control" name="username" value="" required autofocus>
                                    </div>
                                </div>
                                <div class="from-group  col-md-6">
                                    <label for="first_name" class="col-md-6 control-label">First Name</label>
                                    <div class="col-md-12">
                                        <input id="first_name" type="text" class="form-control" name="first_name" value="" required autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="from-group col-md-6">
                                    <label for="last_name" class="col-md-6 control-label">Last Name</label>
                                    <div class="col-md-12">
                                        <input id="last_name" type="text" class="form-control" name="last_name" value="" required autofocus>
                                    </div>
                                </div>
                                <div class="from-group  col-md-6">
                                    <label for="middle_name" class="col-md-6 control-label">Middle Name</label>
                                    <div class="col-md-12">
                                        <input id="middle_name" type="text" class="form-control" name="middle_name" value="" required autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="from-group">
                                <label for="date_of_birth" class="col-md-4 control-label">Date Of Birth</label>
                                <div class="col-md-12">
                                    <input id="date_of_birth" type="text" class="form-control" name="date_of_birth" value="" required autofocus>
                                </div>
                            </div>
                            <div class="from-group">
                                <div class="row">
                                    <div class="from-group col-md-7">
                                        <label for="gender" class="col-md-12 control-label">Gender</label>
                                        <div class="row">
                                            <div class="from-group col-md-12">

                                                <div class="col-md-4">
                                                    <input id="male" type="radio" class="gender" name="gender" value="male" > Male
                                                </div>
                                                <div class="col-md-4">
                                                    <input id="female" type="radio" class="gender" name="gender" value="female" > Female
                                                </div>
                                                <div class="col-md-4">
                                                    <input id="other" type="radio" class="gender" name="gender" value="'other" > Other
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="from-group col-md-5">
                                        <label for="physically_challenged" class="col-md-12 control-label">Physically Challenged</label>
                                        <div class="row">
                                            <div class="from-group col-md-12">

                                                <div class="col-md-6">
                                                    <input id="male" type="radio" class="physically_challenged" name="physically_challenged" value="yes" > Yes
                                                </div>
                                                <div class="col-md-6">
                                                    <input id="female" type="radio" class="physically_challenged" name="physically_challenged" value="No" > No
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="from-group col-md-4">
                                    <label for="phone" class="col-md-6 control-label">Phone</label>
                                    <div class="col-md-12">
                                        <input id="phone" type="text" class="form-control" name="phone" value="" required autofocus>
                                    </div>
                                </div>
                                <div class="from-group  col-md-8">
                                    <label for="email" class="col-md-6 control-label">Email</label>
                                    <div class="col-md-12">
                                        <input id="email" type="text" class="form-control" name="email" value="" required autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="from-group">
                                <label for="address" class="col-md-4 control-label">Address</label>
                                <div class="col-md-12">
                                    <input id="address" type="text" class="form-control" name="address" value="" required autofocus>
                                </div>
                            </div>
                            <div class="row">
                                <div class="from-group col-md-6">
                                    <label for="suburb" class="col-md-6 control-label">Suburb</label>
                                    <div class="col-md-12">
                                        <input id="suburb" type="text" class="form-control" name="suburb" value="" required autofocus>
                                    </div>
                                </div>
                                <div class="from-group  col-md-6">
                                    <label for="pin" class="col-md-6 control-label">Pincode</label>
                                    <div class="col-md-12">
                                        <input id="pin" type="text" class="form-control" name="pin" value="" required autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="from-group col-md-4">
                                    <label for="city" class="col-md-6 control-label">City</label>
                                    <div class="col-md-12">
                                        <input id="city" type="text" class="form-control" name="city" value="" required autofocus>
                                    </div>
                                </div>
                                <div class="from-group  col-md-4">
                                    <label for="state" class="col-md-6 control-label">State</label>
                                    <div class="col-md-12">
                                        <input id="state" type="text" class="form-control" name="state" value="" required autofocus>
                                    </div>
                                </div>
                                <div class="from-group  col-md-4">
                                    <label for="country" class="col-md-4 control-label">Country</label>
                                    <div class="col-md-12">
                                        <input id="country" type="text" class="form-control" name="country" value="" required autofocus>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!--</div>-->
                </div>
                
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" style="min-width: 80px;">Update</button>
                    <button type="button" class="btn btn-default" style="min-width: 80px;" data-dismiss="modal">Close</button>
                </div>
            </form>
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
