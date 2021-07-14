@extends('layouts.backend')

@section('title')
    Activity Log
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- /#global-alert-box -->
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Activity Log</h3>
            </div>
            <!-- /.box-header -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="GET" action="{{ route('admin.users.index') }}" class="form-inline float-right">
                            <div class="input-group">
                                <span class="input-group-addon">From</span>
                                <input type="date" class="form-control" name="from"
                                       value="{{ Request::get('from') }}" placeholder="Start date">
                            </div>

                            <div class="input-group">
                                <span class="input-group-addon">To</span>
                                <input type="date" class="form-control" name="to" value="{{ Request::get('to') }}" placeholder="End date">
                            </div>

                            <div class="form-group mb-2" style="width: 15%">
                                <select class="form-control select2" name="account">
                                    <option value="">Account</option>
                                    @foreach($panelAdmins as $pa)
                                        <option value="{{ $pa->id }}" {{ (Request::get('account')==$pa->id)?'selected':'' }}>{{ $pa->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2" style="width: 15%">
                                <select class="form-control select2" name="event">
                                    <option value="">Event</option>
                                    @foreach($logNames as $pa)
                                        <option value="{{ $pa->log_name }}" {{ (Request::get('event')==$pa->log_name)?'selected':'' }}>{{ $pa->log_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label class="sr-only">&nbsp;</label>
                                <input type="text" class="form-control" name="details" value="{{ Request::get('details') }}" placeholder="Write your search text...">
                            </div>

                            <button type="submit" class="btn btn-info mb-2"><i class="fa fa-search"></i> Search</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-warning mb-2"><i class="fa fa-times"></i></a>
                        </form>
                    </div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>SL.</th>
                        <th>Date</th>
                        <th>Account</th>
                        <th>Event</th>
                        <th>Details</th>
                        <th>IP Address</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($activities as $key => $val)
                        <tr>
                            <td> {{ $serial++ }}</td>
                            <td>{{ $val->created_at }}</td>
                            <td>{{ $val->name }}</td>
                            <td>{{ $val->log_name  }}</td>
                            <td>{{ $val->description }}</td>
                            <td>{{ $val->ip }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($activities->total())
                    <div class="row">
                        <div class="col-sm-5">
                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                                {{ $activities->appends(Request::except('page'))->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <!-- /.box-body -->
        </div>
    </section>
    <!-- /.content -->
@endsection
