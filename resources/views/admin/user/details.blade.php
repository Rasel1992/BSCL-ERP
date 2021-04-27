@extends('layouts.backend')

@section('title')
    User | Details
@endsection

@section('styles')
    <style>
        .nav-stacked > li > a {
            border-left: 3px solid transparent;
            border-radius: 0;
            border-top: 0;
            color: #444;
        }

        .nav-pills > li > a {
            border-radius: 4px;
        }

        .nav > li > a {
            position: relative;
            display: block;
            padding: 10px 15px;
        }
        .nav-stacked > li.active > a, .nav-stacked > li.active > a:hover {
            background: transparent;
            color: #444;
            border-top: 0;
            border-left-color: #3c8dbc;
        }
        .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus {
            border-bottom-color: #3c8dbc;
        }
        .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
            color: #fff;
            background-color: #337ab7;
        }

        .navbar-custom-nav {
            background: #FFFFFF;
            box-shadow: 0 3px 12px 0;
        }

        .nav {
            list-style: none;
        }

        .bg-cover {
            background-size: cover;
        }

        .bg-gray-dark {
            background-color: #3a3f51;
            color: #ffffff;
        }

        .p-lg {
            padding: 15px;
        }

        .p-xl {
            padding: 30px;
        }

        .mb-xl {
            margin-bottom: 30px;
        }

        .row-table {
            display: table;
            table-layout: fixed;
            height: 100%;
            width: 100%;
            margin: 0;
        }

        .row {
            margin-left: -15px;
            margin-right: -15px;
        }

        .text-white {
            color: #fff;
        }

        .mt-lg {
            margin-top: 15px;
        }

        .m0 {
            margin: 0;
        }

        .user-timer ul.timer {
            margin: 0px;
        }

        .user-timer ul.timer li {
            color: #fff;
            font-size: 24px;
            font-weight: bold;
        }

        .user-timer ul.timer li span {
            display: none;
        }

        .timer > li {
            font-size: 20px;
            text-align: center;
            display: inline-block;
            color: #555;
            font-weight: 600;
        }

        .user-timer ul.timer > li.dots {
            padding: 6px 2px;
            font-size: 14px;
        }

        .timer > li.dots {
            vertical-align: top;
        }

        .timer {
            padding: 0;
            text-align: center;
            list-style: none;
        }

        .form-horizontal {
            margin-left: -15px;
            margin-right: -15px;
        }

    </style>
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">User Details</h3><a href="{{ route('admin.users.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> Back to List</a>
            </div>
            <div class="panel-body">
                @if (isset($user))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="unwrap">
                                <div class="cover-photo bg-cover">
                                    <div class="p-xl text-white">
                                        <div class="row col-sm-4">
                                            <div class="row pull-left col-sm-6">
                                                <div class=" row-table row-flush">
                                                    <div class="pull-left text-white ">
                                                        <div class="">
                                                            <h4 class="mt-sm mb0">0 </h4>
                                                            <p class="mb0 text-muted">Total Absent</p>
                                                            <small><a href="" class="mt0 mb0">More info <i class="fa fa-arrow-circle-right"></i></a></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-lg row-table row-flush">
                                                    <div class="pull-left">
                                                        <div class="">
                                                            <h4 class="mt-sm mb0">0 </h4>
                                                            <p class="mb0 text-muted">Total Leave</p>
                                                            <small><a href="" class="mt0 mb0">More info <i class="fa fa-arrow-circle-right"></i></a></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pull-right col-sm-6">
                                                <div class=" row-table row-flush">
                                                    <div class="pull-left text-white ">
                                                        <div class="">
                                                            <h4 class="mt-sm mb0">0 </h4>
                                                            <p class="mb0 text-muted">Open Tasks</p>
                                                            <small><a href="" class="mt0 mb0">More info <i class="fa fa-arrow-circle-right"></i></a></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-lg row-table row-flush">
                                                    <div class="pull-left">
                                                        <div class="">
                                                            <h4 class="mt-sm mb0">0 </h4>
                                                            <p class="mb0 text-muted">Complete Tasks</p>
                                                            <small><a href="" class="mt0 mb0">More info<i class="fa fa-arrow-circle-right"></i></a></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="text-center ">
                                                @if(isset($user->image))
                                                    {!! viewImg('user', $user->image, ['thumb' => 1, 'class' => 'img-circle', 'style' => 'width:128px; height:128px;']) !!}
{{--                                                    <img src="{{ asset('user/'.$user->image.'') }}" width="128px" height="128px" class="img-circle">--}}
                                                @else
                                                    <img src="{{ asset('storage/user/blank-profile-picture-973460_1280.png') }}" width="128px" height="128px" class="img-circle" alt="Avatar">
                                                @endif
                                            </div>
                                            <h3 class="m0 text-center text-white">{{ $user->name }}</h3>
                                            <p class="text-center text-white">EMP ID: {{ $user->user_id ?? 'N/A' }}</p>
                                            <p class="text-center text-white">{{ $user->departments ? $user->departments->department : 'N/A' }}⇒ {{ $user->designation ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="pull-left col-sm-6">
                                                <div class=" row-table row-flush">
                                                    <div class="pull-left text-white ">
                                                        <div class="">
                                                            <h4 class="mt-sm mb0">0 / 21 </h4>
                                                            <p class="mb0 text-muted">Monthly Attendance</p>
                                                            <small><a href="" class="mt0 mb0">More info <i class="fa fa-arrow-circle-right"></i></a></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-lg row-table row-flush">
                                                    <div class="pull-left">
                                                        <div class="">
                                                            <h4 class="mt-sm mb0">0 </h4>
                                                            <p class="mb0 text-muted">Monthly Leave</p>
                                                            <small><a href="" class="mt0 mb0">More info <i class="fa fa-arrow-circle-right"></i></a></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pull-right col-sm-6">
                                                <div class=" row-table row-flush">
                                                    <div class="pull-left text-white ">
                                                        <div class="">
                                                            <h4 class="mt-sm mb0">0 </h4>
                                                            <p class="mb0 text-muted">Monthly Absent</p>
                                                            <small><a href="" class="mt0 mb0">More info <i class="fa fa-arrow-circle-right"></i></a></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-lg row-table row-flush">
                                                    <div class="pull-left">
                                                        <div class="">
                                                            <h4 class="mt-sm mb0">0 </h4>
                                                            <p class="mb0 text-muted">Total Award</p>
                                                            <small><a href="" class="mt0 mb0">More info<i class="fa fa-arrow-circle-right"></i></a></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center bg-gray-dark p-lg mb-xl">
                                    <div class="row row-table">
                                        <div class="col-md-4 user-timer">
                                            <h3 class="m0">
                                                <ul class="timer">
                                                    <li>0<span> Hours</span></li>
                                                    <li class="dots">:</li>
                                                    <li>0<span> Minutes</span></li>
                                                    <li class="dots">:</li>
                                                    <li>0<span>Seconds</span></li>
                                                </ul>
                                            </h3>
                                            <span class="hidden-xs">Tasks Hours</span>
                                        </div>
                                        <div class="col-md-4 user-timer">
                                            <h3 class="m0">0 : 0 m</h3>
                                            <span class="hidden-xs">This month Working Hours</span>
                                        </div>
                                        <div class="col-md-4 user-timer">
                                            <h3 class="m0">0 : 0 m</h3>
                                            <span class="hidden-xs">Working Hours</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-lg">
                                <div class="col-sm-3">
                                    <ul class="nav nav-pills nav-stacked navbar-custom-nav">
                                        <li class="active"><a href="#basic_info" data-toggle="tab">Basic Details</a>
                                        </li>
                                        <li><a href="#inventory_details" data-toggle="tab">Inventory Details</a></li>
                                        <li><a href="#stock_details" data-toggle="tab">Stock Details</a></li>
                                        <li><a href="#shift" data-toggle="tab">Shift</a></li>
                                        <li><a href="#bank_details" data-toggle="tab">Bank Details</a></li>
                                        <li><a href="#document_details" data-toggle="tab">Documents Details</a></li>
                                        <li><a href="#salary_details" data-toggle="tab">Salary Details</a></li>
                                        <li><a href="#leave_details" data-toggle="tab">Leave Details</a></li>
                                        <li><a href="#provident_found" data-toggle="tab">Provident Found</a></li>
                                        <li><a href="#Overtime_details" data-toggle="tab">Overtime Details</a></li>
                                        <li><a href="#tasks_details" data-toggle="tab">Tasks</a></li>
                                        <li><a href="#tasks_details" data-toggle="tab">Education</a></li>
                                        <li><a href="#tasks_details" data-toggle="tab">Training</a></li>
                                        <li><a href="#tasks_details" data-toggle="tab">Experience</a></li>
                                        <li><a href="#tasks_details" data-toggle="tab">Nominee</a></li>
                                        <li><a href="#tasks_details" data-toggle="tab">Reference</a></li>
                                        <li><a href="#tasks_details" data-toggle="tab">Reporting</a></li>
                                        <li><a href="#tasks_details" data-toggle="tab">Office Device</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-9">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="basic_info">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <strong>{{ $user->name }}</strong>
                                                        <div class="pull-right">
                                                        <span>
                                                        <a href="{{route('admin.users.edit', $user->id)}}" class="text-default text-sm ml">Update</a>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-body form-horizontal">
                                                    <div class="form-group mb0  col-sm-6">
                                                        <label class="control-label col-sm-5"><strong>EMP ID :</strong></label>
                                                        <div class="col-sm-7 ">
                                                            <p class="form-control-static">{{ $user->user_id ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb0  col-sm-6">
                                                        <label class="control-label col-sm-5"><strong>Full Name
                                                                :</strong></label>
                                                        <div class="col-sm-7 ">
                                                            <p class="form-control-static">{{ $user->name }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb0  col-sm-6">
                                                        <label class="col-sm-5 control-label">Department : </label>
                                                        <div class="col-sm-7">
                                                            <p class="form-control-static">{{ $user->departments ? $user->departments->department : 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb0  col-sm-6">
                                                        <label class="col-sm-5 control-label">Designation : </label>
                                                        <div class="col-sm-7">
                                                            <p class="form-control-static">{{ $user->designation ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb0  col-sm-6">
                                                        <label class="col-sm-5 control-label">Joining Date: </label>
                                                        <div class="col-sm-7">
                                                            <p class="form-control-static">{{ $user->joining_date ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb0  col-sm-6">
                                                        <label class="col-sm-5 control-label">Gender:</label>
                                                        <div class="col-sm-7">
                                                            <p class="form-control-static">{{ $user->sex ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb0  col-sm-6">
                                                        <label class="col-sm-5 control-label">Date Of Birth: </label>
                                                        <div class="col-sm-7">
                                                            <p class="form-control-static">{{ $user->dob ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb0  col-sm-6">
                                                        <label class="col-sm-5 control-label">Fathers Name: </label>
                                                        <div class="col-sm-7">
                                                            <p class="form-control-static">{{ $user->father_name ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb0  col-sm-6">
                                                        <label class="col-sm-5 control-label">Mothers Name: </label>
                                                        <div class="col-sm-7">
                                                            <p class="form-control-static">{{ $user->mother_name ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb0  col-sm-6">
                                                        <label class="col-sm-5 control-label">Email : </label>
                                                        <div class="col-sm-7">
                                                            <p class="form-control-static">{{ $user->email }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb0  col-sm-6">
                                                        <label class="col-sm-5 control-label">Mobile : </label>
                                                        <div class="col-sm-7">
                                                            <p class="form-control-static">{{ $user->mobile ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb0  col-sm-6">
                                                        <label class="col-sm-5 control-label">Blood Group : </label>
                                                        <div class="col-sm-7">
                                                            <p class="form-control-static">{{ $user->blood_group ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb0  col-sm-6">
                                                        <label class="col-sm-5 control-label">NID : </label>
                                                        <div class="col-sm-7">
                                                            <p class="form-control-static">{{ $user->nid ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb0  col-sm-6">
                                                        <label class="col-sm-5 control-label">Passport : </label>
                                                        <div class="col-sm-7">
                                                            <p class="form-control-static">{{ $user->passport ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb0  col-sm-6">
                                                        <label class="col-sm-5 control-label">Present Address : </label>
                                                        <div class="col-sm-7">
                                                            <p class="form-control-static">{{ $user->present_address ?? 'N/A'}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb0  col-sm-6">
                                                        <label class="col-sm-5 control-label">Permanent Address
                                                            : </label>
                                                        <div class="col-sm-7">
                                                            <p class="form-control-static">{{ $user->permanent_address ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb0  col-sm-6">
                                                        <label class="col-sm-5 control-label">Signature
                                                            : </label>
                                                        <div class="col-sm-7">
                                                            <p class="form-control-static">
                                                                @if(isset($user->signature))
                                                                    {!! viewImg('user/signature', $user->signature, ['thumb' => 1,'alt'=>'Avatar', 'class' => 'img-circle', 'style' => 'width:40px; height:40px;']) !!}
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="inventory_details">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">Assigned Inventories</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>SL</th>
                                                            <th>Inventory Category</th>
                                                            <th>Inventory Qty</th>
                                                            <th>Assigned Date</th>
                                                        </tr>
                                                        </thead>
                                                        @if($user->inventories)
                                                            @foreach($user->inventories as $key => $inventory)
                                                                <tbody>
                                                                <td> {{++ $key}}</td>
                                                                <td> {{ $inventory->category->category_name }}</td>
                                                                <td>{{$inventory->qty}}<br></td>
                                                                <td>{{$inventory->purchase_date}}<br></td>
                                                                </tbody>
                                                            @endforeach
                                                        @endif
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="stock_details" style="position: relative;">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">Assigned Stocks</h4>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>SL</th>
                                                            <th>Stock Category</th>
                                                            <th>Stock Qty</th>
                                                            <th>Assigned Date</th>
                                                        </tr>
                                                        </thead>
                                                        @if($user->stocks)
                                                            @foreach($user->stocks as $key => $stock)
                                                                <tbody>
                                                                <td> {{++ $key}}</td>
                                                                <td> {{ $stock->stock->category->category_name }}</td>
                                                                <td>{{$stock->qty}}<br></td>
                                                                <td>{{$stock->assign_date}}<br></td>
                                                                </tbody>
                                                            @endforeach
                                                        @endif
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="shift" style="position: relative;">
                                            <div id="panelChart4" class="panel panel-custom">
                                                <div class="panel-heading">
                                                    <div class="panel-title">Total Working Hours</div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="form-group col-sm-12">
                                                        <ul class="timer">
                                                            <li>{{show_hour($totalWorkHours->totalHour)}}<span> Hours</span></li>
                                                            <li class="dots">:</li>
                                                            <li>{{show_min($totalWorkHours->totalHour)}}<span> Minutes</span></li>
                                                            <li class="dots">:</li>
                                                            <li>00<span> Seconds</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">Total Working Details</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>SL</th>
                                                            <th>Date</th>
                                                            <th>Shift</th>
                                                            <th>Time</th>
                                                            <th>Hours</th>
                                                        </tr>
                                                        </thead>
                                                        @if($user->rosters)
                                                            @foreach($user->rosters as $key => $roster)
                                                                <tbody>
                                                                <td> {{++ $key}}</td>
                                                                <td>{{$roster->roster_date}}<br></td>
                                                                <td> {{ $roster->shift->name }}</td>
                                                                <td> {{ $roster->shift->from }} - {{ $roster->shift->to }}</td>
                                                                <td> {{ $roster->shift->total_hours }}</td>
                                                                </tbody>
                                                            @endforeach
                                                                <tfoot>
                                                                <tr>
                                                                    <td class="text-right" colspan="4"><strong>Total Hours : </strong></td>
                                                                    <td>{{short_string($totalWorkHours ->totalHour)}}</td>
                                                                </tr>
                                                                </tfoot>
                                                        @endif
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="bank_details" style="position: relative;">
                                            <div class="panel panel-custom">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">Bank Details
                                                        <div class="pull-right hidden-print">
                                                    <span data-placement="top" data-toggle="tooltip" title=""
                                                          data-original-title="New Bank">
                                                    <a data-toggle="modal" data-target="#myModal" href=""
                                                       class="text-default text-sm ml">Update</a>
                                                    </span>
                                                        </div>
                                                    </h4>
                                                </div>
                                                <div class="panel-body form-horizontal">
                                                    <table class="table table-striped " cellspacing="0" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Bank</th>
                                                            <th>Branch Name</th>
                                                            <th>Account Name</th>
                                                            <th>A/C Number</th>
                                                            <th class="hidden-print">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane " id="document_details" style="position: relative;">
                                            <div class="panel panel-custom">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">User Documents
                                                        <div class="pull-right hidden-print">
                                                    <span data-placement="top" data-toggle="tooltip" title=""
                                                          data-original-title="">
                                                    <a data-toggle="modal" data-target="#myModal" href=""
                                                       class="text-default text-sm ml">Update</a>
                                                    </span>
                                                        </div>
                                                    </h4>
                                                </div>
                                                <div class="panel-body form-horizontal">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane " id="salary_details" style="position: relative;">
                                            <div class="form-horizontal">
                                                <div class="panel panel-custom">
                                                    <div class="panel-heading">
                                                        <div class="panel-title">
                                                            <strong>Salary Details</strong>
                                                        </div>
                                                    </div>
                                                    There is no data to display!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane " id="leave_details" style="position: relative;">
                                            <div class="panel panel-custom">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <strong>Leave Details Of Dr. Shahjahan Mahmood</strong>
                                                    </div>
                                                </div>
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <td><strong> XBD</strong>:</td>
                                                        <td class="hidden-print">
                                                            0/30
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong> Maternity</strong>:</td>
                                                        <td class="hidden-print">
                                                            0/180
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong> Casual </strong>:</td>
                                                        <td class="hidden-print">
                                                            0/15
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #e8e8e8; font-size: 14px; font-weight: bold;">
                                                            <strong> Total</strong>:
                                                        </td>
                                                        <td style="background-color: #e8e8e8; font-size: 14px; font-weight: bold;"
                                                            class="hidden-print"> 0 /225
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="panel panel-custom">
                                                <div class="panel-heading">Leave Report</div>
                                                <div class="panel-body">
                                                    <div id="panelChart5">
                                                        <div class="chart-pie-my flot-chart"
                                                             style="padding: 0px; position: relative;">
                                                            <canvas class="flot-base" width="100" height="250"
                                                                    style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 100px; height: 250px;"></canvas>
                                                            <canvas class="flot-overlay" width="100" height="250"
                                                                    style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 100px; height: 250px;"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane " id="provident_found" style="position: relative;">
                                            <div class="panel panel-custom">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <strong><i class="fa fa-calendar"></i> Provident Found 2021
                                                        </strong>
                                                        <div class="pull-right hidden-print">
                                                            <span class="hidden-print"><a
                                                                    href="/hrm/admin/user/provident_fund_pdf/2021/2"
                                                                    class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                                    data-placement="top" title=""
                                                                    data-original-title="PDF"><span <i="" class="fa fa-file-pdf-o"></span></a></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form id="attendance-form" role="form" enctype="multipart/form-data"
                                                      action="2/8" method="post"
                                                      class="form-horizontal form-groups-bordered">
                                                    <div class="form-group">
                                                        <label for="field-1" class="col-sm-3 control-label">Year<span
                                                                class="required"> *</span></label>
                                                        <div class="col-sm-5">
                                                            <div class="input-group">
                                                                <input type="text" name="year"
                                                                       class="form-control years" value="2021"
                                                                       data-format="yyyy">
                                                                <div class="input-group-addon">
                                                                    <a href="#"><i class="fa fa-calendar"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2 ">
                                                            <button type="submit" id="sbtn" class="btn btn-primary">Go
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>Payment Month</th>
                                                        <th>Payment Date</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr class="total_amount">
                                                        <td colspan="2" style="text-align: right;">
                                                            <strong>Total Provident Fund : </strong></td>
                                                        <td colspan="3" style="padding-left: 8px;" class="hidden-print">
                                                            <strong>BDT 0.00</strong></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane " id="Overtime_details" style="position: relative;">
                                            <div class="panel panel-custom">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <strong><i class="fa fa-calendar"></i> Overtime Details 2021
                                                        </strong>
                                                        <div class="pull-right hidden-print">
                                                            <span class="hidden-print"><a
                                                                    href="/hrm/admin/user/overtime_report_pdf/2021/2"
                                                                    class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                                    data-placement="top" title=""
                                                                    data-original-title="PDF"><span> <i class="fa fa-file-pdf-o"></i></span></a></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form id="attendance-form" role="form" enctype="multipart/form-data"
                                                      action="2/9" method="post"
                                                      class="form-horizontal form-groups-bordered">
                                                    <div class="form-group">
                                                        <label for="field-1" class="col-sm-3 control-label">Year<span
                                                                class="required"> *</span></label>
                                                        <div class="col-sm-5">
                                                            <div class="input-group">
                                                                <input type="text" name="overtime_year"
                                                                       class="form-control years" value="2021"
                                                                       data-format="yyyy">
                                                                <div class="input-group-addon">
                                                                    <a href="#"><i class="fa fa-calendar"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2 ">
                                                            <button type="submit" id="sbtn" class="btn btn-primary">Go
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>Overtime Date</th>
                                                        <th>Overtime Hours</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr class="total_amount">
                                                        <td style="text-align: right;">
                                                            <strong>Total Overtime Hour : </strong></td>
                                                        <td colspan="2" style="padding-left: 8px;" class="hidden-print">
                                                            <strong>0 : 0 m</strong></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
