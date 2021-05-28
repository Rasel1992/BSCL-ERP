@extends('layouts.backend')

@section('title')
    Roles
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Roles</h3>

                @can('add role')
                <div class="box-tools pull-right">
                    <a href="{{ route('admin.setting.role.create').qString() }}" class="button add"> Add Role</a>
                </div>
                @endcan
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <table class="table table-hover table-2nd-no-sort">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $key => $val)
                        <tr>
                            <td> {{$key + $roles->firstItem()}}</td>
                            <td> {{ $val->name }} </td>
                            <td>
                            <span class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                    <i class="fa fa-cogs"></i> <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" style="left: -115px;">
                                     <form method="POST" action="{{ route('admin.setting.role.destroy', $val->id).qString() }}" accept-charset="UTF-8" class="data-form">
                                         @csrf
                                         @method('delete')

                                         @can('see role details')
                                         <li><a href="{{ route('admin.setting.role.edit', $val->id).qString() }}"><i class="fa fa-edit"></i></a></li>
                                         @endcan

                                         @can('edit role')
                                         <li><a href="{{ route('admin.setting.role.show', $val->id).qString() }}"><i class="fa fa-eye"></i></a></li>
                                         @endcan

                                         @can('delete role')
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
                @if($roles->total())
                    <div class="row">
                        <div class="col-sm-5">

                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                                {{ $roles->appends(Request::except('page'))->links() }}
                            </div>
                        </div>
                    </div>
                @endif
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

