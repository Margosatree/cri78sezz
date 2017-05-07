@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Cricket Profile</div>
                <div class="panel-body">
                    @if (Session::has('msg'))
                        <div class="alert alert-success">
                            {{Session::get('msg')}}
                        </div>
                    @endif
                    <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;" action="/User/bulkUpload" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <input type="file" name="import_file" />
                        {{ csrf_field() }}
                        <button class="btn btn-primary">Import File</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection