@extends('layouts.backend')

@section('title')
    Activity Log
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Activity Log</h3>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <div class="row">
                    <div class="form-group">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                From
                            </div>
                            <input type="text" class="form-control datepicker" name="from" value="{{ Request::get('from') }}" placeholder="Start date">
                        </div>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                To
                            </div>
                            <input type="text" class="form-control datepicker" name="to" value="{{ Request::get('to') }}" placeholder="End date">
                        </div>
                    </div>

                    <div class="form-group">
                        <select class="form-control select2" name="account">
                            <option value="">Account</option>
                            @foreach($panelAdmins as $pa)
                                <option value="{{ $pa->id }}" {{ (Request::get('account')==$pa->id)?'selected':'' }}>{{ $pa->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control select2" name="event">
                            <option value="">Event</option>
                            @foreach($logNames as $pa)
                                <option value="{{ $pa->log_name }}" {{ (Request::get('event')==$pa->log_name)?'selected':'' }}>{{ $pa->log_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="details" value="{{ Request::get('details') }}" placeholder="Write your search text...">
                    </div>
                </div>
                <br>
                <table class="table table-hover table-2nd-no-sort">
                    <thead>
                    <tr>
                        <th>SL.</th>
                        <td>Date</td>
                        <td>Account</td>
                        <td>Event</td>
                        <td>Details</td>
                        <td>IP Address</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($activities as $key => $val)
                        <tr>
                            <td> {{$key + $activities->firstItem()}}</td>
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
        </div>
    </section>
@endsection

