@extends('layouts.app')

@section('title')
    Registration Page
@endsection

@section('content')

    <div class="register-box-body">
        <p class="login-box-msg">Register a new membership</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group has-feedback">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Full name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Retype password" required autocomplete="new-password">
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.form-box -->
    </div>
@endsection
