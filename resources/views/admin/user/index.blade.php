@extends('layouts.backend')

@section('title')
  Users
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- /#global-alert-box -->
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Users</h3>

                @can('add user')
                <div class="box-tools pull-right">
                    <a href="{{ route('admin.users.create').qString() }}" class="button add" >Add User</a>
                </div>
                @endcan

            </div>
            <!-- /.box-header -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('admin.users.index') }}" class="form-inline float-right">
                            <div class="form-group mb-2">
                                <select class="form-control select2" id="type" name="type">
                                    <option value="">Select</option>
                                    <option value="admin"  {{'admin' == Request::get('type')?'selected':''}} >Admin</option>
                                    <option value="staff" {{'staff' == Request::get('type')?'selected':''}}>Staff</option>
                                </select>
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label class="sr-only">&nbsp;</label>
                                <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Input your search text...">
                            </div>

                            <button type="submit" class="btn btn-info mb-2"><i class="fa fa-search"></i> Search</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-warning mb-2"><i class="fa fa-times"></i></a>
                        </form>
                    </div>
                </div>
                <table class="table table-hover" id="file_export">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Avatar</th>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Email</th>
                        <th> </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $key => $user)
                        <tr>
                            <td> {{$key + $users->firstItem()}}</td>
                            <td>
                                @if($user->image)
                                    {!! viewImg('user', $user->image, ['thumb' => 1, 'class' => 'img-circle', 'style' => 'width:40px; height:40px;']) !!}
                                @endif
                            </td>
                            <td>{{ $user->user_id }}</td>
                            <td><a href="{{ route('admin.users.show',$user->id ).qString() }}">{{ $user->name }}</a> </td>
                            <td><span class="label label-outline">{{ $user->type }}</span></td>
                            <td>@if($user->dept_id){{ $user->departments->department }}@endif</td>
                            <td>{{ $user->designation }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @can('edit user')
                                <a href="{{route('admin.users.edit', $user->id).qString() }}" class="ajax-modal-btn"><i data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-edit"></i></a>&nbsp;
                                @endcan

                                @can('change password')
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#change-password-modal" @click="showPasswordUpdateModal('{{ $user->id }}')" class="ajax-modal-btn"><i data-toggle="tooltip" data-placement="top" title="Change password" class="fa fa-lock"></i></a>&nbsp;
                                @endcan

                                <form method="POST" action="{{ route('admin.users.destroy', $user->id).qString() }}" accept-charset="UTF-8" class="data-form">
                                    @csrf
                                    @method('delete')

                                    @can('delete user')
                                    <a href="javascript:void(0)" @click="destroy" class="confirm ajax-silent" title="Trash" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash-o"></i></a>
                                    @endcan

                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($users->total())
                    <div class="row">
                        <div class="col-sm-5">
                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                                {{ $users->appends(Request::except('page'))->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <!-- /.box-body -->
        </div>
        <x-user.password-update/>
    </section>
    <!-- /.content -->
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
                },
                showPasswordUpdateModal: function (id) {
                    $('#change-password-form').attr('action', window.location.origin + '/admin/users/' + id + '/password/update');
                },
                fileChosen: function (id) {
                    if (event.target.value) {
                        $(id).val(event.target.files[0].name);
                    } else {
                        $(id).val('');
                    }
                },
            }
        })
    </script>
@endpush
