@extends('layouts.backend')

@section('title')
    Requisition Lists
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Requisition Lists</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('admin.request.requisition.create').qString() }}" class="button add"> Add Requisition</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <table class="table table-hover table-2nd-no-sort" id="file_export">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Requisition By</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($requisitions as $key => $requisition)
                        <tr>
                            <td> {{$key + $requisitions->firstItem()}}</td>
                           <td>{{$requisition->requisitionBy->name}}</td>
                           <td>{{$requisition->requisitionBy->departments->department}}</td>
                           <td>{{$requisition->requisitionBy->designation}}</td>
                            <td>
                            <span class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                                <i class="fa fa-cogs"></i> <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu" style="left: -115px;">
                                                 <form method="POST" action="{{ route('admin.request.requisition.destroy', $requisition->id).qString() }}" accept-charset="UTF-8" class="data-form">
                                                     @csrf
                                                     @method('delete')
                                                    <li><a href="javascript:void(0)" @click="destroy"><i class="fa fa-trash-o"></i> </a></li>
                                                  </form>
                                            </ul>
                                        </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($requisitions->total())
                    <div class="row">
                        <div class="col-sm-5">

                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                                {{ $requisitions->appends(Request::except('page'))->links() }}
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

