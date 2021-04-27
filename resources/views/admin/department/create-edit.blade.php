@extends('layouts.backend')

@section('title')
    @if(isset($department)) Edit @else Create  @endif | Department
@endsection

@section('content')
    <section class="content">
        <form method="POST"
              action="{{ isset($department) ? route('admin.departments.update', $department->id) : route('admin.departments.store') }}"
              accept-charset="UTF-8" id="create-edit-form" data-toggle="validator" enctype="multipart/form-data"
              novalidate="true">
            @csrf
            @if (isset($department))
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <h3 class="box-title">@if(isset($department)) Edit @else Add @endif Department <a
                            href="{{ route('admin.departments.index') }}" class="btn btn-info pull-right">List of
                            Department</a></h3>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('department') has-error @enderror">
                                            <label class="col-md-3">Department<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Department" name="department"
                                                       value="{{ old('department', isset($department) ? $department->department : '') }}"
                                                       type="text" required>
                                                @error('department')
                                                <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                                @enderror
                                            </div>
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
                <div class="col-md-1"></div>
            </div>
        </form>
    </section>
@endsection
