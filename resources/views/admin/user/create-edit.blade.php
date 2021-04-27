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
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <h3 class="box-title">@if(isset($user)) Edit @else Add @endif User
                        <a href="{{ route('admin.users.index') }}" class="btn btn-info pull-right"> List of User</a>
                    </h3>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('user_id') has-error @enderror">
                                            <label class="col-md-3" for="name">User ID<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Enter User ID" required name="user_id"
                                                       value="{{old('user_id')}}" type="text" id="user_id" v-model="user.user_id">
                                                @error('user_id')
                                                <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row @error('name') has-error @enderror">
                                            <label class="col-md-3" for="name">Name<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" placeholder="Enter your name" required name="name"
                                                   value="{{old('name')}}" type="text" id="name" v-model="user.name">
                                                @error('name')
                                                <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('type') has-error @enderror">
                                            <label class="col-md-3" for="sex">User Type<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <select class="form-control select2" id="type" name="type" v-model="user.type" required
                                                        v-select2>
                                                    <option value="">Select Type</option>
                                                    <option value="super-admin" {{ old('type') == 'super-admin' ? 'selected' : '' }}>Super Admin</option>
                                                    <option value="admin" {{ old('type') == 'admin' ? 'selected' : '' }}>Admin</option>
                                                    <option value="staff" {{ old('type') == 'staff' ? 'selected' : '' }}>Staff</option>
                                                </select>
                                                @error('type')
                                                <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row @error('email') has-error @enderror">
                                            <label class="col-md-3" for="email">Email<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Enter your email" required name="email"
                                                       value="{{old('email')}}" type="email" id="email" v-model="user.email">
                                                @error('email')
                                                <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                        <div class="col-md-12">
                                            @if(!isset($user))
                                            <div class="col-md-6">
                                                <div class="form-group row @error('password') has-error @enderror">
                                                    <label class="col-md-3" for="password">Password<span class="text-danger">*</span></label>
                                                    <div class="col-md-8">
                                                    <input class="form-control" id="password" placeholder="Enter your password"
                                                           data-minlength="6" required name="password"
                                                           value="{{old('password')}}" type="password">
                                                        @error('password')
                                                        <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                                <div class="col-md-6">
                                                    <div class="form-group row @error('father_name') has-error @enderror">
                                                        <label class="col-md-3" for="father_name">Fathers Name</label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" placeholder="Enter your fathers name" name="father_name"
                                                                   value="{{old('father_name')}}" type="text" id="name" v-model="user.father_name">
                                                            @error('father_name')
                                                            <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-md-6">
                                                <div class="form-group row @error('mobile') has-error @enderror">
                                                    <label class="col-md-3" for="mobile">Mobile<span class="text-danger">*</span></label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" placeholder="Enter your Mobile Number" required name="mobile"
                                                               value="{{old('mobile')}}" type="text" id="mobile" v-model="user.mobile">
                                                        @error('mobile')
                                                        <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <div class="col-md-12">
                                    @if(!isset($user))
                                    <div class="col-md-6">
                                        <div class="form-group row @error('password_confirmation') has-error @enderror">
                                            <label class="col-md-3">Confirm Password<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Confirm Password"
                                                       data-match="#password" required name="password_confirmation"
                                                       value="{{old('password_confirmation')}}" type="password">
                                                @error('password_confirmation')
                                                <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                        <div class="col-md-6">
                                            <div class="form-group row @error('mother_name') has-error @enderror">
                                                <label class="col-md-3" for="mother_name">Mothers Name</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" placeholder="Enter your mothers name" name="mother_name"
                                                           value="{{old('mother_name')}}" type="text" id="mother_name" v-model="user.mother_name">
                                                    @error('mother_name')
                                                    <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                        <div class="col-md-6">
                                            <div class="form-group row @error('sex') has-error @enderror">
                                                <label class="col-md-3" for="sex">Gender</label>
                                                <div class="col-md-8">
                                                    <select class="form-control select2" id="sex" name="sex" v-model="user.sex" v-select2>
                                                        <option value="">Select</option>
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
                                            </div>
                                        </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('dept_id') has-error @enderror">
                                            <label class="col-md-3" for="dept_id">Department<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <select class="form-control select2" id="dept_id" name="dept_id"
                                                        v-model="user.dept_id" v-select2 required>
                                                    @foreach($departments as $department)
                                                        <option value="{{$department->id}}">{{$department->department}}</option>
                                                    @endforeach
                                                </select>
                                                @error('dept_id')
                                                <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row @error('dob') has-error @enderror">
                                            <label class="col-md-3" for="dob">DOB</label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Date Of Birth" name="dob"
                                                       value="{{old('dob')}}" type="date" id="dob" v-model="user.dob">
                                                @error('dob')
                                                <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('designation') has-error @enderror">
                                            <label class="col-md-3">Designation<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" placeholder="Designation" name="designation" value="{{ old('designation') }}" v-model="user.designation" type="text" required>
                                                @error('designation')
                                                <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row @error('image') has-error @enderror">
                                            <label class="col-md-3" for="exampleInputFile">Avatar</label>
                                            <span style="margin-left: 10px;">
                                            @if(isset($user->image))
                                            {!! viewImg('user', $user->image, ['thumb' => 1,'alt'=>'Avatar', 'class' => 'img-circle', 'style' => 'width:40px; height:40px;']) !!}@endif
                                             </span>
                                            <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-8 nopadding-right">
                                                    <input id="uploadFile" placeholder="Choose avatar" class="form-control"
                                                           disabled="disabled" style="height: 28px;">
                                                </div>
                                                <div class="col-md-4 nopadding-left">
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
                                </div>
                                @if(isset($user))
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('nid') has-error @enderror">
                                            <label class="col-md-3" for="nid">NID</label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="NID" name="nid"
                                                       value="{{old('nid')}}" type="text" id="nid" v-model="user.nid">
                                                @error('nid')
                                                <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row @error('joining_date') has-error @enderror">
                                            <label class="col-md-3" for="joining_date">Joining Date</label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Joining date" name="joining_date"
                                                       value="{{old('joining_date')}}" type="date" id="joining_date" v-model="user.joining_date">
                                                @error('joining_date')
                                                <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('passport') has-error @enderror">
                                            <label class="col-md-3" for="passport">Passport</label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Passport" name="passport"
                                                       value="{{old('passport')}}" type="text" id="passport" v-model="user.passport">
                                                @error('passport')
                                                <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row @error('present_address') has-error @enderror">
                                            <label class="col-md-3" for="present_address">Present Address</label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Present address" name="present_address"
                                                       value="{{old('present_address')}}" type="text" id="present_address" v-model="user.present_address">
                                                @error('present_address')
                                                <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('blood_group') has-error @enderror">
                                            <label class="col-md-3" for="blood_group">Blood Group</label>
                                            <div class="col-md-8">
                                                <select class="form-control select2" id="blood_group" name="blood_group" v-model="user.blood_group"
                                                        v-select2>
                                                    <option value="">Select</option>
                                                    @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $type)
                                                        <option value="{{ $type }}" {{ old('blood_group') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                                    @endforeach
                                                </select>
                                                @error('blood_group')
                                                <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row @error('permanent_address') has-error @enderror">
                                            <label class="col-md-3" for="permanent_address">Permanent Address</label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Permanent address" name="permanent_address"
                                                       value="{{old('permanent_address')}}" type="text" id="permanent_address" v-model="user.permanent_address">
                                                @error('permanent_address')
                                                <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('signature') has-error @enderror">
                                            <label class="col-md-3" for="exampleInputFile">Signature</label>
                                            <span style="margin-left: 10px;">
                                            @if(isset($user->signature))
                                                    {!! viewImg('user/signature', $user->signature, ['thumb' => 1,'alt'=>'Avatar', 'class' => 'img-circle', 'style' => 'width:40px; height:40px;']) !!}
                                                @endif
                                             </span>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-8 nopadding-right">
                                                        <input id="uploadsig" placeholder="Choose signature" class="form-control"
                                                               disabled="disabled" style="height: 28px;">
                                                    </div>
                                                    <div class="col-md-4 nopadding-left">
                                                        <div class="fileUpload btn btn-primary btn-block btn-flat">
                                                            <span>UPLOAD</span>
                                                            <input type="file" name="signature" value="{{old('signature')}}"
                                                                   @change="fileChosen('#uploadsig')" id="uploadBtn1" class="upload"
                                                                   accept="image/*">
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('signature')
                                                <span class="help-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            </div>
                    </div>
                    <div class="text-right form-footer">
                        <button class="button delete" type="reset">Clear</button>
                        <button class="button save" type="submit">Save</button>
                    </div>
                </div>
                <div class="col-md-1"></div>
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
                    user_id: '{{ old('user_id', $user->user_id ?? '') }}',
                    name: '{{ old('name', $user->name ?? '') }}',
                    type: '{{ old('type', $user->type ?? '') }}',
                    email: '{{ old('email', $user->email ?? '') }}',
                    mobile: '{{ old('mobile', $user->mobile ?? '') }}',
                    dob: '{{ old('dob', $user->dob ?? '') }}',
                    sex: '{{ old('sex', $user->sex ?? '') }}',
                    dept_id: '{{ old('dept_id', $user->dept_id  ?? '') }}',
                    designation: '{{ old('designation', $user->designation  ?? '') }}',
                    image: '',
                    joining_date: '{{ old('joining_date', $user->joining_date ?? '') }}',
                    father_name: '{{ old('father_name', $user->father_name ?? '') }}',
                    mother_name: '{{ old('mother_name', $user->mother_name ?? '') }}',
                    blood_group: '{{ old('blood_group', $user->blood_group ?? '') }}',
                    nid: '{{ old('nid', $user->nid ?? '') }}',
                    passport: '{{ old('passport', $user->passport ?? '') }}',
                    present_address: '{{ old('present_address', $user->present_address ?? '') }}',
                    permanent_address: '{{ old('permanent_address', $user->permanent_address ?? '') }}',
                    signature: '',
                },
            },
            mounted() {
                this.initLibs();
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
