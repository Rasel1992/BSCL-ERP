@extends('layouts.backend')

@section('title')
    Change Password
@endsection

@section('content')
    <section class="content">
        <form method="POST" action="{{route('admin.profile.updatePassword')}}" accept-charset="UTF-8" id="create-edit-form" data-toggle="validator" enctype="multipart/form-data" novalidate="true">
            @csrf
        <div class="row">
            <div class="col-md-2 col-lg-2"></div>
            <div class="col-md-8 col-lg-8">
                <h3 class="box-title">Update Password <a href="{{ route('admin.profile') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> Back to Profile</a></h3>
                <div class="panel">
                    <div class="panel-body">
                        <div class="modal-body">
                            <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                                <label for="old_password">Current Password</label>
                                <input class="form-control" id="old_password" placeholder="Current Password"
                                       data-minlength="8" name="old_password" type="password" value="{{old('old_password')}}" required>
                                @if ($errors->has('old_password'))
                                    <span
                                        class="help-block"><strong>{{ $errors->first('old_password') }}</strong></span>
                                @endif

                                @if (session('error'))
                                    <span class="help-block"> <strong>{{ session('error') }}</strong></span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                                <label for="password">New Password</label>
                                <div class="row">
                                    <div class="col-md-6 nopadding-right">
                                        <input class="form-control" id="password" placeholder="Password"
                                               data-minlength="8" name="new_password" type="password" value="{{old('new_password')}}" required>
                                        @if ($errors->has('new_password'))
                                            <span
                                                class="help-block"><strong>{{ $errors->first('new_password') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 nopadding-left">
                                        <input class="form-control" placeholder="Confirm Password"
                                               data-match="#password" name="confirm_password" type="password" value="{{old('confirm_password')}}"
                                               required>
                                        @if ($errors->has('confirm_password'))
                                            <span
                                                class="help-block"><strong>{{ $errors->first('confirm_password') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right form-footer">
                    <button class="button delete" type="reset">Clear</button>
                    <button class="button save" type="submit">Save</button>
                </div>
            </div>
            <div class="col-md-2 col-lg-2"></div>
        </div>
        </form>
    </section>
@endsection
