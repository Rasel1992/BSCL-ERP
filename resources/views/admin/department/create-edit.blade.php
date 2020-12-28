@extends('layouts.backend')

@section('title')
    @if(isset($department)) Edit @else Create @endif
@endsection

@section('content')
    <section class="content">
        <form method="POST" action="{{ isset($department) ? route('admin.departments.update', $department->id) : route('admin.departments.store') }}" accept-charset="UTF-8" id="create-edit-form" data-toggle="validator" enctype="multipart/form-data" novalidate="true">
            @csrf
            {!! (isset($department))?'<input name="_method" type="hidden" value="PUT">':'' !!}
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <h3 class="box-title">@if(isset($department)) Edit @else Add @endif Department <a href="{{ route('admin.departments.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> Back to List</a></h3>
                    <div class="panel">
                        <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="form-group @error('department') has-error @enderror">
                                        <label class="with-help">Department</label>
                                        <input class="form-control" placeholder="Department" name="department" value="{{old('department')}}" type="text" v-model="department.department" required>
                                        @error('department')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group @error('designation') has-error @enderror">
                                        <label class="with-help">Designation</label>
                                        <input class="form-control" placeholder="Designation" name="designation" value="{{old('designation')}}" type="text" v-model="department.designation" required>
                                        @error('designation')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <p class="help-block">* Required Fields.</p>
                <div class="text-right form-footer">
                    <button class="button delete" type="reset">Clear</button>
                    <button class="button save" type="submit">Save</button>
                </div>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script>
        new Vue({
            el: '#app',
            data: {
                department: {
                    department: '{{ old('department', $department->department ?? '') }}',
                    designation: '{{ old('designation', $department->designation ?? '') }}',
                },
            }
        })
    </script>
@endpush
