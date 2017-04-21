@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Organization Info</div>
                <div class="panel-body">
                    @if($Org->id > 0 )
                        <form class="form-horizontal" role="form" method="POST" action="/org/{{$Org->id}}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $Org->name }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="business_type" class="col-md-4 control-label">Business Type</label>
                            <div class="col-md-6">
                                <input id="business_type" type="text" class="form-control" name="business_type" value="{{ $Org->business_type }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="business_operation" class="col-md-4 control-label">Business Operation</label>
                            <div class="col-md-6">
                                <input id="business_operation" type="text" class="form-control" name="business_operation" value="{{ $Org->business_operation }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-4 control-label">Address</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ $Org->address }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="landmark" class="col-md-4 control-label">Landmark</label>
                            <div class="col-md-6">
                                <input id="landmark" type="text" class="form-control" name="landmark" value="{{ $Org->landmark }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city" class="col-md-4 control-label">City</label>
                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control" name="city" value="{{ $Org->city }}" required autofocus>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="state" class="col-md-4 control-label">State</label>
                            <div class="col-md-6">
                                <input id="state" type="text" class="form-control" name="state" value="{{ $Org->state }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="country" class="col-md-4 control-label">Country</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control " name="country" value="{{ $Org->country }}" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="pincode" class="col-md-4 control-label">PIN</label>
                            <div class="col-md-6">
                                <input id="pincode" type="number" class="form-control" max="999999" minlength="6" maxlength="6" name="pincode" value="{{ $Org->pincode }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="spoc" class="col-md-4 control-label">Spoc</label>
                            <div class="col-md-6">
                                <input id="spoc" type="text" class="form-control"  name="spoc" value="{{ $Org->spoc }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="is_verified" class="col-md-4 control-label">Verified</label>
                            <div class="col-md-6">
                                <input id="is_verified" type="checkbox" class="" checked=""  name="is_verified" value="{{ $Org->is_verified }}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-4">
                                <button type="submit" style="width: 100%" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" onclick="event.preventDefault();
                                    document.getElementById('frmskip').submit();" 
                                    style="width: 100%" class="btn btn-primary">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                    <form id="frmskip" method="get" action="/org/{{$Org->id}}">
                        {{ csrf_field() }}
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $( "#is_verified" ).trigger( "change" );
    $('#is_verified').on('click', function() {
        if ($('#is_verified').is(":checked")){
            $('#is_verified').val(1);
//            alert($('#is_verified').val());
        }else{
            $('#is_verified').val(0);
//            alert($('#is_verified').val());
        }
    });
</script>

@endsection