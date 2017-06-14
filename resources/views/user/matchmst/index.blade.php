@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-20 ">
            <div class="panel panel-default">
                <div class="panel-heading"style="padding: 15px">
                    <h3 style="display:inline;">Match List</h3>
                    <a href="/tour/{{$Tournament}}/match/create"><span class=" pull-right btn btn-info">Add Match <i class="fa fa-plus"></i></span></a>
                </div>
                <div class="panel-body">
                    @if(count($Matches) > 0 )
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Ground/Type</th>
                                    <th>Overs/Innings</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($Matches as $Matche)
                                    <tr>
                                        <td>
                                            <img src ="{{asset('images/'.$Matche->Team1Name->team_logo)}}" style="width: 30%;height: 30%" class="img-rounded"/>
                                            Vs
                                            <img src ="{{asset('images/'.$Matche->Team2Name->team_logo)}}" style="width: 30%;height: 30%" class="img-rounded"/>
                                        </td>
                                        <td>{{ $Matche->ground_name .'/'.$Matche->match_type}}</td>
                                        <td>{{ $Matche->overs .'/'.$Matche->innings}}</td>
                                        <td>{{ $Matche->match_date }}</td>
                                        <td>
                                            <a href="/tour/{{$Tournament}}/match/{{$Matche->match_id}}/edit" class="btn btn-info">
                                               <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                            <a onclick="deleteEntry({{$Tournament.','.$Matche->match_id}})" class="btn btn-info">
                                                <span ><i class="fa fa-times"></i></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info">
                            <b>No Match Found</b>
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
            <form id="deleteFrm" method="Post" action="">
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
    $(document).ready(function() {
//        $.noConflict(function() {
            $('#example').DataTable();
//        });
    } );
    function deleteEntry(tour,match){
        $('#deleteFrm').attr('Action', '/tour/'+tour+'/match/'+match);
        $('#deleteModal').modal('toggle');
    }
</script>
@endsection
