@extends('layouts.backend')

@section('title')
    @if(isset($user)) Edit @else Create @endif
@endsection

@section('content')
    <section class="content">
        <form method="POST" action="{{isset($user) ? route('admin.users.update',$user->id) : route('admin.users.store')}}" accept-charset="UTF-8" id="create-edit-form" data-toggle="validator" enctype="multipart/form-data" novalidate="true">
            @csrf
            @if(isset($user))
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h3 class="box-title">@if(isset($user)) Edit @else Add @endif User
                        <a href="{{ route('admin.users.index') }}" class="btn btn-info pull-right"> List of User</a>
                    </h3>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="form-group @error('name') has-error @enderror">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter your name" required name="name"
                                       value="{{old('name')}}" type="text" id="name" v-model="user.name">
                                @error('name')
                                <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group @error('type') has-error @enderror">
                                <label for="sex">User Type</label>
                                <select class="form-control select2" id="type" name="type" v-model="user.type"
                                        v-select2>
                                    <option value="admin" {{ old('type') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="staff" {{ old('type') == 'staff' ? 'selected' : '' }}>Staff</option>
                                </select>
                                @error('sex')
                                <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group @error('email') has-error @enderror">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Enter your email" required name="email"
                                       value="{{old('email')}}" type="email" id="email" v-model="user.email">
                                @error('email')
                                <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            @if(!isset($user))
                            <div class="form-group @error('password') has-error @enderror">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input class="form-control" id="password" placeholder="Enter your password"
                                           data-minlength="6" required name="password"
                                           value="{{old('password')}}" type="password">
                                    @error('password')
                                    <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            <div class="form-group @error('password_confirmation') has-error @enderror">
                                    <label>Confirm Password <span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Confirm Password"
                                           data-match="#password" required name="password_confirmation"
                                           value="{{old('password_confirmation')}}" type="password">
                                    @error('password_confirmation')
                                    <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endif
                            <div class="form-group @error('dob') has-error @enderror">
                                <label for="dob">Date Of Birth</label>
                                <input class="form-control" placeholder="Date Of Birth" name="dob"
                                       value="{{old('dob')}}" type="date" id="dob" v-model="user.dob">
                                @error('dob')
                                <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group @error('sex') has-error @enderror">
                                <label for="sex">Gender</label>
                                <select class="form-control select2" id="sex" name="sex" v-model="user.sex"
                                        v-model="user.sex" v-select2>
                                    <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>Female
                                    </option>
                                    <option value="other" {{ old('sex') == 'other' ? 'selected' : '' }}>Others
                                    </option>
                                </select>
                                @error('sex')
                                <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group @error('image') has-error @enderror">
                                <label for="exampleInputFile">Avatar</label>
                                <span style="margin-left: 10px;">
                                     @if(isset($user->image))
                                        {!! viewImg('user', $user->image, ['thumb' => 1,'alt'=>'Avatar', 'class' => 'thumbnail', 'style' => 'width:100%']) !!}@endif
                                     </span>
                                <div class="row">
                                    <div class="col-md-9 nopadding-right">
                                        <input id="uploadFile" placeholder="Choose avatar" class="form-control"
                                               disabled="disabled" style="height: 28px;">
                                    </div>
                                    <div class="col-md-3 nopadding-left">
                                        <div class="fileUpload btn btn-primary btn-block btn-flat">
                                            <span>UPLOAD</span>
                                            <input type="file" name="image" value="{{old('image')}}"
                                                   @change="fileChosen('#uploadFile')" id="uploadBtn" class="upload"
                                                   accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                @error('image')
                                <span class="help-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="text-right form-footer">
                        <button class="button delete" type="reset">Clear</button>
                        <button class="button save" type="submit">Save</button>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script>
        new Vue({
            el: '#app',
            data: {
                user: {
                    name: '{{ old('name', $user->name ?? '') }}',
                    type: '{{ old('type', $user->type ?? '') }}',
                    email: '{{ old('email', $user->email ?? '') }}',
                    dob: '{{ old('dob', $user->dob ?? '') }}',
                    sex: '{{ old('sex', $user->sex ?? '') }}',
                    image: ''
                },
            },
            methods: {
                initLibs: function () {
                    setTimeout(function () {
                        $('.select2').select2({
                            width: '100%',
                            placeholder: 'Select',
                        });
                    }, 10);
                },
                fileChosen: function (id) {
                    if (event.target.value) {
                        $(id).val(event.target.files[0].name);
                    } else {
                        $(id).val('');
                    }
                }
            }
        })
    </script>
@endpush
