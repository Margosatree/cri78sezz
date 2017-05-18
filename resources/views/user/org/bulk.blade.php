@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add Bulk User</div>
                <div class="panel-body">
                    <form id="frm" style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;" action="/User/bulkUpload" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <input id="file" type="file" name="import_file" accept=".csv,.xlsx,.xls" required/>
                        {{ csrf_field() }}
                        <button type="button" onclick="Validateform();" class="btn btn-primary">Import File</button>
                    </form>
                    @if(count($Errors) > 1)
                        <div class="alert alert-success">
                            <table id="example" class="display" cellspacing="0" width="100%">
                                <caption ><b>{{Session::get('msg')}}</b></caption>
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>User Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Errors as $Errorskey => $Error)
                                        <tr>
                                            <td><b>{{$Error['u_id']}}</b></td>
                                            <td>
                                                <ul style="list-style-type: none;padding-left: 5px;"><b>{{$Error['u_username']}}</b>
                                                    @foreach($Error['username'] as $username)
                                                        <br>{{$username}}
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <ul style="list-style-type: none;padding-left: 5px;"><b>{{$Error['u_phone']}}</b>
                                                    @foreach($Error['phone'] as $phone)
                                                        <br>{{$phone}}
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <ul style="list-style-type: none;padding-left: 5px;"><b>{{$Error['u_email']}}</b>
                                                    @foreach($Error['email'] as $email)
                                                        <br>{{$email}}
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@if(count($Errors) > 1)
<link href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<!--<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script src="https:////cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf', 'print'
                ]
            } );
        } );
    </script>
    
@endif
<script>
        function Validateform(){
            if($('#file').val() == "" || $('#file').val() == "undefined" || $('#file').val() == "NaN"){
                alert('Please Select File');
                return;
            }else{
                var str = $('#file').val();
                var mime = str.substring(str.lastIndexOf(".")+1, str.length);
                if(!(mime == "csv" || mime == "xlsx" || mime == "xls")){
                    alert("Please Select Valid File");
                    return;
                }
            }
            document.getElementById('frm').submit();
        }
    </script>
@endsection