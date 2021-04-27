@extends('layouts.backend')

@section('title')
    Rosters
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Rosters</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('admin.rosters.create').qString() }}" class="button add"> Set Rosters</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <div class="panel">
                            <div class="box-header with-border">
                                <h3 class="box-title text-center">Shifts</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover table-2nd-no-sort">
                                            <thead>
                                            <tr>
                                                <th>Time</th>
                                                <th>Name</th>
                                                <th>Hours</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($shifts as $key => $shift)
                                                <tr>
                                                    <td>{{$shift->from}} - {{$shift->to}}</td>
                                                    <td>{{$shift->name}}</td>
                                                    <td>{{$shift->total_hours}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-hover table-2nd-no-sort">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Day</th>
                        <th>User</th>
                        <th>Shift</th>
                        <th>Hours</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($rosters as $key => $value)
                        <tr>
                            <td> {{$key + $rosters->firstItem()}}</td>
                            <td> {{ $value->roster_date }}</td>
                            <td> {{ $value->day }}</td>
                            <td> {{ $value->user->name }}</td>
                            <td> {{ $value->shift->name}}</td>
                            <td> {{ $value->shift->total_hours}}</td>
                            <td>
                            <span class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                                <i class="fa fa-cogs"></i> <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu" style="left: -115px;">
                                                 <form method="POST" action="{{ route('admin.rosters.destroy', $value->id).qString() }}" accept-charset="UTF-8" class="data-form">
                                                     @csrf
                                                     @method('delete')
                                                     <li><a href="{{ route('admin.rosters.edit', $value->id).qString() }}"><i class="fa fa-edit"></i></a></li>
                                                    <li><a href="javascript:void(0)" @click="destroy"><i class="fa fa-trash-o"></i> </a></li>
                                                  </form>
                                            </ul>
                                        </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($rosters->total())
                    <div class="row">
                        <div class="col-sm-5">

                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                                {{ $rosters->appends(Request::except('page'))->links() }}
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

