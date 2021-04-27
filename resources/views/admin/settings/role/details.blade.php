@extends('layouts.backend')

@section('title')
    Role | Details
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="panel-body">
                @if (isset($data))
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <caption><h3>Role Details <a href="{{ route('admin.setting.role.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> Back </a></h3></caption>
                            <tbody>
                            <tr>
                                <th style="width:120px;"> Name</th>
                                <th style="width:10px;">:</th>
                                <td>{{ $data->name }}</td>
                            </tr>
                            </tbody>
                            <div class="form-group permissions">
                                <table class="table table-striped mb-0" id="dataTable-1">
                                    <thead>
                                    <tr>
                                        <th>{{__('Module')}} </th>
                                        <th>{{__('Permissions')}} </th>
                                    </tr>
                                    </thead>
                                    <tbody id="editData">
                                    @php($i = 1)
                                    @foreach($permissionArr as $module => $moduleArr)
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="module{{ $i }}" onclick="moduleCheck({{ $i }})" @if(isset($show)) {{ (array_key_exists($module, $rolePermission))?'checked':'' }} @endif>
                                                    <label class="custom-control-label" for="module{{ $i }}">{{ ucwords($module) }}</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row" id="moduleContent{{ $i }}">
                                                    @foreach($moduleArr as $md)
                                                        <div class="col-sm-2 custom-control custom-checkbox">
                                                            <input class="custom-control-input" id="permission{{ $md->id }}" name="permissions[]" type="checkbox" value="{{ $md->name }}"  @if(isset($show)) {{ (isset($rolePermission[$module]) && in_array($md->name, $rolePermission[$module]))?'checked':'' }}  @endif>
                                                            <label for="permission{{ $md->id }}" class="custom-control-label">{{ ucwords(str_replace($module, '', $md->name)) }}</label><br>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                        @php($i++)
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
