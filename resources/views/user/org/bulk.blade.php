@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Bulk User</div>
                <div class="panel-body">
                    <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;" action="/User/bulkUpload" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <input type="file" name="import_file" />
                        {{ csrf_field() }}
                        <button class="btn btn-primary">Import File</button>
                    </form>
                    @if (Session::has('msg'))
                        <div class="alert alert-success">
                            {{Session::get('msg')}}
                        </div>
                    Session::forget('msg');
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection