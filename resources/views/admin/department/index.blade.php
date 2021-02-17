@extends('layouts.backend')

@section('title')
    Departments
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Departments</h3>
                <div class="box-tools pull-right">
{{--                    <a class="btn btn-success" href="{{ route('admin.export.departments') }}">Export</a>--}}
                    <a href="{{ route('admin.departments.create') }}" class="button add"> Add Department</a>
                </div>
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

                            <button type="submit" class="btn btn-info mb-2"><i class="fa fa-search"></i> Search</button>
                            <a href="{{ route('admin.departments.index') }}" class="btn btn-warning mb-2"><i class="fa fa-times"></i></a>
                        </form>
                    </div>
                </div>
                <table class="table table-hover table-2nd-no-sort" id="file_export">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Department</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($departments as $key => $department)
                        <tr>
                            <td> {{$key + $departments->firstItem()}}</td>
                            <td><a href="{{ route('admin.departments.show',$department->id ) }}"> {{ $department->department }} </a></td>
                            <td>
                            <span class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                                <i class="fa fa-cogs"></i> <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu" style="left: -115px;">
                                                 <form method="POST" action="{{ route('admin.departments.destroy', $department->id) }}" accept-charset="UTF-8" class="data-form">
                                                     @csrf
                                                     @method('delete')
                                                     <li><a href="{{ route('admin.departments.edit', $department->id) }}"><i class="fa fa-edit"></i></a></li>
                                                    <li><a href="javascript:void(0)" @click="destroy"><i class="fa fa-trash-o"></i> </a></li>
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
        @include('admin.department.form_import')
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

