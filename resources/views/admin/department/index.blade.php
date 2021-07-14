@extends('layouts.backend')

@section('title')
    Departments
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Departments</h3>
                @can('add department')
                <div class="box-tools pull-right">
{{--                    <a class="btn btn-success" href="{{ route('admin.export.departments') }}">Export</a>--}}
                    <a href="{{ route('admin.departments.create').qString() }}" class="button add"> Add Department</a>
                </div>
                @endcan
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <form method="GET" action="{{ route('admin.departments.index') }}" class="form-inline float-right">
                            <div class="form-group mx-sm-3 mb-2">
                                <label class="sr-only">&nbsp;</label>
                                <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Input your search text...">
                            </div>

                            <div class="form-group" style="width: 15%">
                                <select class="form-control select2" id="per_page" name="per_page">
                                    @php $departmentPage = $departments->count();
                                    $perPage = Request::get('per_page') ?? 50;
                                    @endphp
                                    <option value="">Select Location</option>
                                    <option value="25" {{ ('25' == $perPage) ? 'selected' : '' }}>25
                                    </option>
                                    <option value="50" {{ ('50' == $perPage) ? 'selected' : '' }}>50
                                    </option>
                                    <option value="100" {{ ('100' == $perPage) ? 'selected' : '' }}>100
                                    </option>
                                    <option value="150" {{ ('150' == $perPage) ? 'selected' : '' }}>150
                                    </option>
                                    <option value="200" {{ ('200' == $perPage) ? 'selected' : '' }}>200
                                    </option>
                                    <option value="{{ $departmentPage }}" {{ ($departmentPage == $perPage) ? 'selected' : '' }}>Total Stock Data
                                    </option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-info mb-2"><i class="fa fa-search"></i> Search</button>
                            <a href="{{ route('admin.departments.index') }}" class="btn btn-warning mb-2"><i class="fa fa-times"></i></a>
                        </form>
                    </div>
                </div>
                <br>
                <table class="table table-hover table-2nd-no-sort" id="file_export">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Department ID</th>
                        <th>Department</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($departments as $department)
                        <tr>
                            <td>  {{ $serial++ }} </td>
                            <td>{{$department->department_id }}</td>
                            <td><a href="{{ route('admin.departments.show',$department->id ).qString() }}"> {{ $department->department }} </a></td>
                            <td>
                            <span class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                    <i class="fa fa-cogs"></i> <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" style="left: -115px;">
                                     <form method="POST" action="{{ route('admin.departments.destroy', $department->id).qString() }}" accept-charset="UTF-8" class="data-form">
                                         @csrf
                                         @method('delete')

                                         @can('edit department')
                                         <li><a href="{{ route('admin.departments.edit', $department->id).qString() }}"><i class="fa fa-edit"></i></a></li>
                                         @endcan

                                         @can('delete department')
                                        <li><a href="javascript:void(0)" @click="destroy"><i class="fa fa-trash-o"></i> </a></li>
                                         @endcan
                                      </form>
                                </ul>
                            </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($departments->total())
                    <div class="row">
                        <div class="col-sm-5">

                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                                {{ $departments->appends(Request::except('page'))->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div> <!-- /.box-body -->
        </div> <!-- /.box -->

        <div class="box collapsed-box">
            <div class="box-header">
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <br>
            <div class="box-body">
                @include('admin.department.form_import')
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        new Vue({
            el: '#app',
            methods: {
                destroy: function () {
                    const $this = $(event.target);

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            $this.closest('form').submit();
                        }
                    });
                }
            }
        })
    </script>
@endpush

