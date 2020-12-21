@extends('layouts.app')
@section('title')
    Reset Password
@endsection
@section('content')
    <!-- /.login-logo -->
    <div class="login-box-body">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group has-feedback">
                <label for="email">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
            </div>

            <div class="form-group has-feedback">
                <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
            </div>

            <div class="form-group has-feedback">
                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Reset Password') }}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
@endsection
