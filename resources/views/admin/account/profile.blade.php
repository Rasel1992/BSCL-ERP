@extends('layouts.backend')
@section('title')
    Profile
@endsection
@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-user"></i> Profile</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Avatar</label>
                            @if(isset($user->image))
                                {!! viewImg('user', $user->image, ['thumb' => 1,'alt'=>'Avatar', 'class' => 'thumbnail', 'style' => 'width:100%']) !!}
                            @else
                                <img src="https://placehold.it/250x400/eee?text=No Image Found" class="thumbnail" width="100%" alt="Avatar">
                            @endif
                        </div>
                        <div class="form-group">
                            <form method="POST" action="{{ route('admin.image.update') }}" accept-charset="UTF-8" data-toggle="validator" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-7 nopadding-right">
                                        <div class="form-group @error('image') has-error @enderror">
                                            <input type="file" name="image">
                                            @error('image')
                                            <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-5 nopadding-left">
                                        <button type="submit" class="btn btn-info btn-block">Upload</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <form method="POST" action="{{ route('admin.profile.update') }}" accept-charset="UTF-8" id="form" data-toggle="validator" enctype="multipart/form-data">
                            @csrf
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group @error('name') has-error @enderror">
                                                <label for="name">Full Name</label>
                                                <input class="form-control" placeholder="Full Name" name="name" type="text" value="{{ isset($user->name)?$user->name:null }}" id="full_name">
                                                @error('name')
                                                <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group @error('email') has-error @enderror">
                                                <label for="email">Email-Address</label>
                                                <input class="form-control" placeholder="Email-Address" required name="email" type="email" value="{{ isset($user->email)?$user->email:null }}" id="email">
                                                @error('email')
                                                <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group @error('dob') has-error @enderror">
                                                <label for="dob">Date of birth</label>
                                                <input class="form-control" placeholder="Date of birth" name="dob" value="{{ isset($user->dob)?$user->dob:null }}" type="date" id="dob">
                                                @error('dob')
                                                <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group @error('sex') has-error @enderror">
                                                <label for="sex">Gender</label>
                                                <select class="form-control select2" id="sex" name="sex">
                                                    <option value="male" {{($user->sex == 'male') ? 'Selected' : ''}}>Male</option>
                                                    <option value="female" {{($user->sex == 'female') ? 'Selected' : ''}}>Female </option>
                                                    <option value="other" {{($user->sex == 'other') ? 'Selected' : ''}}>Other </option>
                                                </select>
                                                @error('sex')
                                                <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right form-footer">
                                <button class="button delete" type="reset">Clear</button>
                                <button class="button save" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <a href="{{ route('admin.profile.password.update.form') }}" class="button add"> <i class="fa fa-lock"></i> Change Password</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /.box -->

        <!-- /.content -->
        <!-- /.content-wrapper -->
    </section>
@endsection
