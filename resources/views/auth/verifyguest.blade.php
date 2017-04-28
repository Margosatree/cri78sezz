@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                @if(count($token))
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('verifes.guest') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token or old('token') }}">

                        <div class="form-group{{ $errors->has('verify_email') ? ' has-error' : '' }}">
                            <label for="verify_email" class="col-md-4 control-label">E-Mail OTP</label>

                            <div class="col-md-6">
                                <input id="verify_email" type="verify_email" class="form-control" name="verify_email" value="{{ old('verify_email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('verify_email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('verify_phone') ? ' has-error' : '' }}">
                            <label for="verify_phone" class="col-md-4 control-label">Phone OTP</label>

                            <div class="col-md-6">
                                <input id="verify_phone" type="verify_phone" class="form-control" name="verify_phone" value="{{ old('verify_phone') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('verify_phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-4">
                                <button type="submit" style="width: 100%"class="btn btn-primary">
                                    Verify
                                </button>
                            </div>
                            <div class="col-md-3">
                            <button type="reset" style="width: 100%"class="btn btn-primary">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @else
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
