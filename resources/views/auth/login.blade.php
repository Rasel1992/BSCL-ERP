@extends('layouts.app')
@section('title')
    User | Log in
@endsection
@section('content')
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form method="post" action="{{ route('login') }}">
            @csrf
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="login" value="{{ old('login') }}" placeholder="Email Or Mobile Or User ID" required>

                @error('login')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-group has-feedback">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>


        <!-- /.social-auth-links -->
        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                I forgot my password
            </a>
        @endif
    </div>
    <!-- /.login-box-body -->
    </div>
@endsection
