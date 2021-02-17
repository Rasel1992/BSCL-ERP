@extends('layouts.backend')

@section('title')
    Category
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Categories</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('admin.categories.create') }}" class="button add"> Add Category</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <table class="table table-hover table-2nd-no-sort">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Category Type</th>
                        <th>Category</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $key => $category)
                        <tr>
                            <td> {{$key + $categories->firstItem()}}</td>
                            <td>{{ $category->type }}</td>
                            <td>
                                {{ ($category->parent_mother!='')?$category->parent_mother.' > ':'' }}
                                {{ ($category->parent_name!='')?$category->parent_name.' > ':'' }}
                                {{ $category->category_name }}
                            </td>
                            <td> {{ $category->created_at->format('M d, Y') }} </td>
                            <td class="row-options text-muted small">
                                <a href="{{ route('admin.categories.show', $category->id) }}" class="ajax-modal-btn"><i data-toggle="tooltip" data-placement="top" title="Details" class="fa fa-expand"></i></a>&nbsp;
                                <a href="{{route('admin.categories.edit', $category->id) }}" class="ajax-modal-btn"><i data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-edit"></i></a>&nbsp;
                                <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" accept-charset="UTF-8" class="data-form">
                                    @csrf
                                    @method('delete')
                                    <a href="javascript:void(0)" @click="destroy" class="confirm ajax-silent" title="Trash" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash-o"></i></a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($categories->total())
                    <div class="row">
                        <div class="col-sm-5">

                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                                {{ $categories->appends(Request::except('page'))->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div> <!-- /.box-body -->
        </div> <!-- /.box -->
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

