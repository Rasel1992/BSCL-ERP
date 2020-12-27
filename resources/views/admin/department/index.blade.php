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
                    <a href="{{ route('admin.departments.create') }}" class="button add"> Add Department</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <table class="table table-hover table-2nd-no-sort" id="file_export">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Created at</th>
                        <th> </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($departments as $key => $department)
                        <tr>
                            <td> {{ ++$key }}</td>
                            <td> {{ $department->department }}</td>
                            <td> {{ $department->designation }}</td>
                            <td>
                                {{ $department->created_at->format('M d, Y') }}
                            </td>
                            <td class="row-options text-muted small">
                                <a href="{{route('admin.departments.edit', $department->id) }}" class="ajax-modal-btn"><i data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-edit"></i></a>&nbsp;
                                <form method="POST" action="{{ route('admin.departments.destroy', $department->id) }}" accept-charset="UTF-8" class="data-form">
                                    @csrf
                                    @method('delete')
                                    <a href="javascript:void(0)" @click="destroy" class="confirm ajax-silent" title="Trash" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash-o"></i></a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($departments->total())
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="dataTables_info" id="sortable_info" role="status" aria-live="polite">
                                showing {{ $departments->firstItem() }} to {{ $departments->lastItem() }} of {{ $departments->total() }} entries
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                                {{ $departments->links() }}
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

