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
                                    @foreach($permissionArr as $module => $moduleArr)
                                        <tr>
                                            <td>
                                                <strong>{{ ucwords($module) }}</strong>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    @foreach($moduleArr as $md)
                                                        <div class="col-sm-2 custom-control custom-checkbox">
                                                            {{ ucwords(str_replace($module, '', $md->name)) }}<br>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
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
