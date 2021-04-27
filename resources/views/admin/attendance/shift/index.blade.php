@extends('layouts.backend')

@section('title')
    Shifts
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Shifts</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('admin.shifts.create').qString() }}" class="button add"> Add Shift</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <table class="table table-hover table-2nd-no-sort">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Hours</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($shifts as $key => $shift)
                        <tr>
                            <td> {{$key + $shifts->firstItem()}}</td>
                            <td> {{ $shift->name }}</td>
                            <td> {{ $shift->from }}</td>
                            <td> {{ $shift->from }}</td>
                            <td> {{ $shift->total_hours }}</td>
                            <td>
                            <span class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                                <i class="fa fa-cogs"></i> <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu" style="left: -115px;">
                                                 <form method="POST" action="{{ route('admin.shifts.destroy', $shift->id).qString() }}" accept-charset="UTF-8" class="data-form">
                                                     @csrf
                                                     @method('delete')
                                                     <li><a href="{{ route('admin.shifts.edit', $shift->id).qString() }}"><i class="fa fa-edit"></i></a></li>
                                                    <li><a href="javascript:void(0)" @click="destroy"><i class="fa fa-trash-o"></i> </a></li>
                                                  </form>
                                            </ul>
                                        </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($shifts->total())
                    <div class="row">
                        <div class="col-sm-5">

                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                                {{ $shifts->appends(Request::except('page'))->links() }}
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

