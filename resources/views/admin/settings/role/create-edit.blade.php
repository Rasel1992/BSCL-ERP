@extends('layouts.backend')

@section('title')
    @if(isset($data)) Edit @else Create  @endif | Role
@endsection

@section('content')
    <section class="content">
        <form method="POST" action="{{ isset($data) ? route('admin.setting.role.update', $data->id) : route('admin.setting.role.store') }}" accept-charset="UTF-8" id="create-edit-form" data-toggle="validator" enctype="multipart/form-data" novalidate="true">
            @csrf
            @if (isset($data))
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <h3 class="box-title">@if(isset($data)) Edit @else Add @endif Role <a href="{{ route('admin.setting.role.index') }}" class="btn btn-info pull-right">List of Role</a></h3>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('name') has-error @enderror">
                                            <label class="col-md-3">Name<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="name" value="{{ old('name', isset($data) ? $data->name : '') }}" required>
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
                                    <div class="form-group permissions">
                                        @php($i = 1)
                                        @foreach($permissionArr as $module => $moduleArr)
                                            <div class="box collapsed-box">
                                                <div class="box-header with-border">
                                                    <div class="checkbox">
                                                        <label for="module{{ $i }}">
                                                            <input type="checkbox" id="module{{ $i }}" onclick="moduleCheck({{ $i }})" @if(isset($edit)) {{ (array_key_exists($module, $rolePermission))?'checked':'' }} @endif>
                                                            {{ ucwords($module) }}
                                                        </label>
                                                    </div>
                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                                <div class="box-body">
                                                    <div id="moduleContent{{ $i }}">
                                                        @foreach($moduleArr as $md)
                                                            <div class="checkbox">
                                                                <label for="permission{{ $md->id }}">
                                                                <input id="permission{{ $md->id }}" name="permissions[]" type="checkbox" value="{{ $md->name }}" @if(isset($edit)) {{ (isset($rolePermission[$module]) && in_array($md->name, $rolePermission[$module]))?'checked':'' }}  @endif>
                                                                {{ ucwords(str_replace($module, '', $md->name)) }}</label><br>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @php($i++)
                                        @endforeach
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
                <div class="col-md-1"></div>
            </div>
        </form>
    </section>
@endsection
@push('scripts')
    <script>
        function moduleCheck(k) {
            if (document.getElementById('module' + k).checked == true) {
                $('#moduleContent' + k + ' input').prop('checked', true);
            } else {
                $('#moduleContent' + k + ' input').prop('checked', false);
            }
        }
    </script>
@endpush
