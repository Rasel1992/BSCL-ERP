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
        .navbar-custom-nav {
            background: #FFFFFF;
            box-shadow: 0 3px 12px 0;
        }
        .nav {
            list-style: none;
        }
        .nav > li.active {
            background: #E4E4E4;
        }
        .bg-cover {
            background-size: cover;
        }
        .bg-gray-dark {
            background-color: #3a3f51;
            color: #ffffff !important;
        }
        .p-lg {
            padding: 15px !important;
        }
        .p-xl {
            padding: 30px !important;
        }
        .mb-xl {
            margin-bottom: 30px !important;
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
        .thumb128 {
            width: 128px !important;
            height: 128px !important;
        }
        .img-circle1 {
            border-radius: 50%;
        }
        .img-thumbnail1 {
            padding: 2px;
            line-height: 1.52857143;
            background-color: #e1e2e3;
            border: 1px solid #e1e2e3;
            border-radius: 3px;
            -webkit-transition: all 0.2s ease-in-out;
            -o-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
            display: inline-block;
            max-width: 100%;
            height: auto;
        }
        .text-white {
            color: #fff;
        }
        .mt-lg {
            margin-top: 15px !important;
        }
        .row {
            margin-left: -15px;
            margin-right: -15px;
        }
        .m0 {
            margin: 0 !important;
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
            font-size: 46px;
            text-align: center;
            display: inline-block;
            color: #555;
            font-weight: 300;
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

    </style>
@endsection

@section('content')
    <section class="content">
        <div class="content-wrapper">
            <div class="content-heading">
                <a class="text-muted" href="/hrm/admin/user/user_list">User</a>
                <div class="pull-right">
                    <form method="post" action="/hrm/admin/dashboard/set_clocking/">
                        <div>
                            <small class="text-sm"> &nbsp;Friday 2nd April - 2021,&nbsp;Time&nbsp;<span id="txt">10:54:09 AM </span></small>
                            <input type="hidden" name="clock_date" value="2021-04-02" id="date">
                            <input type="hidden" name="clock_time" value="10:54:9" id="clock_time">
                            <button name="clocktime" type="submit" id="sbtn" value="1" class="btn btn-success clock_in_button"><i class="fa fa-sign-out"></i> Clock In </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
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
                                                    <small><a href="/hrm/admin/transactions/deposit" class="mt0 mb0">More info <i class="fa fa-arrow-circle-right"></i></a></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-lg row-table row-flush">
                                            <div class="pull-left">
                                                <div class="">
                                                    <h4 class="mt-sm mb0">0 </h4>
                                                    <p class="mb0 text-muted">Total Leave</p>
                                                    <small><a href="/hrm/admin/transactions/deposit" class="mt0 mb0">More info <i class="fa fa-arrow-circle-right"></i></a></small>
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
                                                    <small><a href="/hrm/admin/tasks/all_task" class="mt0 mb0">More info <i class="fa fa-arrow-circle-right"></i></a></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-lg row-table row-flush">
                                            <div class="pull-left">
                                                <div class="">
                                                    <h4 class="mt-sm mb0">0 </h4>
                                                    <p class="mb0 text-muted">Complete Tasks</p>
                                                    <small><a href="/hrm/admin/tasks/all_task" class="mt0 mb0">More info<i class="fa fa-arrow-circle-right"></i></a></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="text-center ">
                                        <img src="{{asset('assets/images/Dr._Shahjahan_Mahmood_.jpg')}}" class="img-thumbnail1 img-circle1 thumb128 ">
                                    </div>
                                    <h3 class="m0 text-center text-white">Dr. Shahjahan Mahmood </h3>
                                    <p class="text-center text-white">EMP ID: BCSCL CH 02</p>
                                    <p class="text-center text-white">Chairman Department ⇒ Chairman
                                    </p>
                                </div>
                                <div class="col-sm-5">
                                    <div class="pull-left col-sm-6">
                                        <div class=" row-table row-flush">
                                            <div class="pull-left text-white ">
                                                <div class="">
                                                    <h4 class="mt-sm mb0">0 / 21 </h4>
                                                    <p class="mb0 text-muted">Monthly Attendance</p>
                                                    <small><a href="/hrm/admin/attendance/attendance_report" class="mt0 mb0">More info <i class="fa fa-arrow-circle-right"></i></a></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-lg row-table row-flush">
                                            <div class="pull-left">
                                                <div class="">
                                                    <h4 class="mt-sm mb0">0 </h4>
                                                    <p class="mb0 text-muted">Monthly Leave</p>
                                                    <small><a href="/hrm/admin/leave_management" class="mt0 mb0">More info <i class="fa fa-arrow-circle-right"></i></a></small>
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
                                                    <small><a href="/hrm/admin/attendance/attendance_report" class="mt0 mb0">More info <i class="fa fa-arrow-circle-right"></i></a></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-lg row-table row-flush">
                                            <div class="pull-left">
                                                <div class="">
                                                    <h4 class="mt-sm mb0">0 </h4>
                                                    <p class="mb0 text-muted">Total Award</p>
                                                    <small><a href="/hrm/admin/award" class="mt0 mb0">More info <i class="fa fa-arrow-circle-right"></i></a></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center bg-gray-dark p-lg mb-xl">
                            <div class="row row-table">
                                <div class="col-xs-4 br user-timer">
                                    <h3 class="m0"><ul class="timer"><li>0<span> Hours</span></li><li class="dots">:</li><li>0<span> Minutes</span></li><li class="dots">:</li><li>0<span>Seconds</span></li></ul></h3>
                                    <span class="hidden-xs">Tasks Hours</span>
                                </div>
                                <div class="col-xs-4 br user-timer">
                                    <h3 class="m0">0 : 0 m</h3>
                                    <span class="hidden-xs">This month Working Hours</span>
                                </div>
                                <div class="col-xs-4 user-timer">
                                    <h3 class="m0">0 : 0 m</h3>
                                    <span class="hidden-xs">Working Hours</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-lg">
                        <div class="col-sm-3">
                            <ul class="nav nav-pills nav-stacked navbar-custom-nav">
                                <li class="active"><a href="#basic_info" data-toggle="tab">Basic Details</a></li>
                                <li class=""><a href="#bank_details" data-toggle="tab">Bank Details</a></li>
                                <li class=""><a href="#document_details" data-toggle="tab">Documents Details</a>
                                </li>
                                <li class=""><a href="#salary_details" data-toggle="tab">Salary Details</a></li>
                                <li class=""><a href="#timecard_details" data-toggle="tab">Timecard Details</a>
                                </li>
                                <li class=""><a href="#leave_details" data-toggle="tab">Leave Details</a></li>
                                <li class=""><a href="#provident_found" data-toggle="tab">Provident Found</a></li>
                                <li class=""><a href="#Overtime_details" data-toggle="tab">Overtime Details</a>
                                </li>
                                <li class=""><a href="#tasks_details" data-toggle="tab">Tasks</a></li>
                                <li class=""><a href="#tasks_details" data-toggle="tab">Education</a></li>
                                <li class=""><a href="#tasks_details" data-toggle="tab">Training</a></li>
                                <li class=""><a href="#tasks_details" data-toggle="tab">Experience</a></li>
                                <li class=""><a href="#tasks_details" data-toggle="tab">Nominee</a></li>
                                <li class=""><a href="#tasks_details" data-toggle="tab">Reference</a></li>
                                <li class=""><a href="#tasks_details" data-toggle="tab">Reporting</a></li>
                                <li class=""><a href="#tasks_details" data-toggle="tab">Shift</a></li>
                                <li class=""><a href="#tasks_details" data-toggle="tab">Office Device</a></li>
                                <li class=""><a href="#tasks_details" data-toggle="tab">Vehical Tracking</a></li>
                                <li class=""><a href="#tasks_details" data-toggle="tab">CV</a></li>
                                <li class=""><a href="#bugs_details" data-toggle="tab"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-9">
                            <div class="tab-content" style="border: 0;padding:0;">
                                <div class="tab-pane active" id="basic_info" style="position: relative;">
                                    <div class="panel panel-custom">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <strong>Dr. Shahjahan Mahmood</strong>
                                                <div class="pull-right">
<span data-placement="top" data-toggle="tooltip" title="" data-original-title="">
<a data-toggle="modal" data-target="#myModal" href="/hrm/admin/user/update_contact/1/7" class="text-default text-sm ml">Update</a>
</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body form-horizontal">
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="control-label col-sm-5"><strong>EMP ID :</strong></label>
                                                <div class="col-sm-7 ">
                                                    <p class="form-control-static">BCSCL CH 02</p>
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="control-label col-sm-5"><strong>Full Name :</strong></label>
                                                <div class="col-sm-7 ">
                                                    <p class="form-control-static">Dr. Shahjahan Mahmood</p>
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="control-label col-sm-5"><strong>Username :</strong></label>
                                                <div class="col-sm-7 ">
                                                    <p class="form-control-static">CH_02</p>
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="control-label col-sm-5"><strong>Password :</strong></label>
                                                <div class="col-sm-7 ">
                                                    <p class="form-control-static"><a href="/hrm/admin/user/reset_password/2">Reset Password</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="col-sm-5 control-label">Joining Date: </label>
                                                <div class="col-sm-7">
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="col-sm-5 control-label">Gender:</label>
                                                <div class="col-sm-7">
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="col-sm-5 control-label">Date Of Birth: </label>
                                                <div class="col-sm-7">
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="col-sm-5 control-label">Maratial Status:</label>
                                                <div class="col-sm-7">
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="col-sm-5 control-label">Fathers Name: </label>
                                                <div class="col-sm-7">
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="col-sm-5 control-label">Mothers Name: </label>
                                                <div class="col-sm-7">
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="col-sm-5 control-label">Email : </label>
                                                <div class="col-sm-7">
                                                    <p class="form-control-static">chairman@bcscl.com.bd</p>
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="col-sm-5 control-label">Phone : </label>
                                                <div class="col-sm-7">
                                                    <p class="form-control-static">+8801723908375</p>
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="col-sm-5 control-label">Mobile : </label>
                                                <div class="col-sm-7">
                                                    <p class="form-control-static"></p>
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="col-sm-5 control-label">Skype id : </label>
                                                <div class="col-sm-7">
                                                    <p class="form-control-static"></p>
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="col-sm-5 control-label">Blood Group : </label>
                                                <div class="col-sm-7">
                                                    <p class="form-control-static"></p>
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="col-sm-5 control-label">NID : </label>
                                                <div class="col-sm-7">
                                                    <p class="form-control-static"></p>
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="col-sm-5 control-label">Passport : </label>
                                                <div class="col-sm-7">
                                                    <p class="form-control-static"></p>
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="col-sm-5 control-label">TIN : </label>
                                                <div class="col-sm-7">
                                                    <p class="form-control-static"></p>
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="col-sm-5 control-label">Present Address : </label>
                                                <div class="col-sm-7">
                                                    <p class="form-control-static"></p>
                                                </div>
                                            </div>
                                            <div class="form-group mb0  col-sm-6">
                                                <label class="col-sm-5 control-label">Permanent Address
                                                    : </label>
                                                <div class="col-sm-7">
                                                    <p class="form-control-static"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane " id="bank_details" style="position: relative;">
                                    <div class="panel panel-custom">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">Bank Details <div class="pull-right hidden-print">
<span data-placement="top" data-toggle="tooltip" title="" data-original-title="New Bank">
<a data-toggle="modal" data-target="#myModal" href="/hrm/admin/user/new_bank/2" class="text-default text-sm ml">Update</a>
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
                                            <h4 class="panel-title">User Documents <div class="pull-right hidden-print">
<span data-placement="top" data-toggle="tooltip" title="" data-original-title="">
<a data-toggle="modal" data-target="#myModal" href="/hrm/admin/user/user_documents/2" class="text-default text-sm ml">Update</a>
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
                                            There is no data to display! </div>
                                    </div>
                                </div>
                                <div class="tab-pane " id="timecard_details" style="position: relative;">
                                    <div class="form-horizontal">
                                        <div class="panel panel-custom">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <strong>Timecard Details</strong>
                                                    <div class="pull-right ">
                                                        <span><a href="/hrm/admin/user/timecard_details_pdf/2/2021-4" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="PDF"><span <i="" class="fa fa-file-pdf-o"></span></a></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <form id="attendance-form" role="form" enctype="multipart/form-data" action="2/6" method="post" class="form-horizontal form-groups-bordered">
                                                    <div class="form-group">
                                                        <label for="field-1" class="col-sm-3 control-label">Month<span class="required"> *</span></label>
                                                        <div class="col-sm-5">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control monthyear" value="2021-4" name="date">
                                                                <div class="input-group-addon">
                                                                    <a href="#"><i class="fa fa-calendar"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2 ">
                                                            <button type="submit" id="sbtn" class="btn btn-primary">Go</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="row">
                                                    <div class="panel panel-custom ">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <strong>Works Hours Details ofApril-2021</strong>
                                                            </h4>
                                                        </div>
                                                        <div class="box-header" style="border-bottom: 1px solid red">
                                                            <h4 class="box-title" style="font-size: 15px">
                                                                <strong>Week : 13 </strong>
                                                            </h4>
                                                        </div>
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                            <tr>
                                                                <th>
                                                                    01-04-2021</th>
                                                                <th>
                                                                    02-04-2021</th>
                                                                <th>
                                                                    03-04-2021</th>
                                                                <th>
                                                                    04-04-2021</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>
                                                                    0 : 0 m </td>
                                                                <td>
                                                                    <span style="font-size: 12px;" class="label label-info std_p">Holiday</span> </td>
                                                                <td>
                                                                    <span style="font-size: 12px;" class="label label-info std_p">Holiday</span> </td>
                                                                <td class="hidden-print">
                                                                    0 : 0 m </td>
                                                            </tr>
                                                            </tbody></table><table>
                                                            <tbody><tr>
                                                                <td colspan="2" class="text-right">
                                                                    <strong style="margin-right: 10px; ">Total Working Hour : </strong>
                                                                </td>
                                                                <td class="hidden-print">
                                                                    0 : 0 m </td>
                                                            </tr>
                                                            </tbody></table>


                                                        <div class="box-header" style="border-bottom: 1px solid red">
                                                            <h4 class="box-title" style="font-size: 15px">
                                                                <strong>Week : 14 </strong>
                                                            </h4>
                                                        </div>
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                            <tr>
                                                                <th>
                                                                    05-04-2021</th>
                                                                <th>
                                                                    06-04-2021</th>
                                                                <th>
                                                                    07-04-2021</th>
                                                                <th>
                                                                    08-04-2021</th>
                                                                <th>
                                                                    09-04-2021</th>
                                                                <th>
                                                                    10-04-2021</th>
                                                                <th>
                                                                    11-04-2021</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>
                                                                    0 : 0 m </td>
                                                                <td>
                                                                    0 : 0 m </td>
                                                                <td>
                                                                    0 : 0 m </td>
                                                                <td>
                                                                    0 : 0 m </td>
                                                                <td>
                                                                    <span style="font-size: 12px;" class="label label-info std_p">Holiday</span> </td>
                                                                <td>
                                                                    <span style="font-size: 12px;" class="label label-info std_p">Holiday</span> </td>
                                                                <td class="hidden-print">
                                                                    0 : 0 m </td>
                                                            </tr>
                                                            </tbody></table><table>
                                                            <tbody><tr>
                                                                <td colspan="2" class="text-right">
                                                                    <strong style="margin-right: 10px; ">Total Working Hour : </strong>
                                                                </td>
                                                                <td class="hidden-print">
                                                                    0 : 0 m </td>
                                                            </tr>
                                                            </tbody></table>


                                                        <div class="box-header" style="border-bottom: 1px solid red">
                                                            <h4 class="box-title" style="font-size: 15px">
                                                                <strong>Week : 15 </strong>
                                                            </h4>
                                                        </div>
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                            <tr>
                                                                <th>
                                                                    12-04-2021</th>
                                                                <th>
                                                                    13-04-2021</th>
                                                                <th>
                                                                    14-04-2021</th>
                                                                <th>
                                                                    15-04-2021</th>
                                                                <th>
                                                                    16-04-2021</th>
                                                                <th>
                                                                    17-04-2021</th>
                                                                <th>
                                                                    18-04-2021</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>
                                                                    0 : 0 m </td>
                                                                <td>
                                                                    0 : 0 m </td>
                                                                <td>
                                                                    0 : 0 m </td>
                                                                <td>
                                                                    0 : 0 m </td>
                                                                <td>
                                                                    <span style="font-size: 12px;" class="label label-info std_p">Holiday</span> </td>
                                                                <td>
                                                                    <span style="font-size: 12px;" class="label label-info std_p">Holiday</span> </td>
                                                                <td class="hidden-print">
                                                                    0 : 0 m </td>
                                                            </tr>
                                                            </tbody></table><table>
                                                            <tbody><tr>
                                                                <td colspan="2" class="text-right">
                                                                    <strong style="margin-right: 10px; ">Total Working Hour : </strong>
                                                                </td>
                                                                <td class="hidden-print">
                                                                    0 : 0 m </td>
                                                            </tr>
                                                            </tbody></table>


                                                        <div class="box-header" style="border-bottom: 1px solid red">
                                                            <h4 class="box-title" style="font-size: 15px">
                                                                <strong>Week : 16 </strong>
                                                            </h4>
                                                        </div>
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                            <tr>
                                                                <th>
                                                                    19-04-2021</th>
                                                                <th>
                                                                    20-04-2021</th>
                                                                <th>
                                                                    21-04-2021</th>
                                                                <th>
                                                                    22-04-2021</th>
                                                                <th>
                                                                    23-04-2021</th>
                                                                <th>
                                                                    24-04-2021</th>
                                                                <th>
                                                                    25-04-2021</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>
                                                                    0 : 0 m </td>
                                                                <td>
                                                                    0 : 0 m </td>
                                                                <td>
                                                                    0 : 0 m </td>
                                                                <td>
                                                                    0 : 0 m </td>
                                                                <td>
                                                                    <span style="font-size: 12px;" class="label label-info std_p">Holiday</span> </td>
                                                                <td>
                                                                    <span style="font-size: 12px;" class="label label-info std_p">Holiday</span> </td>
                                                                <td class="hidden-print">
                                                                    0 : 0 m </td>
                                                            </tr>
                                                            </tbody></table><table>
                                                            <tbody><tr>
                                                                <td colspan="2" class="text-right">
                                                                    <strong style="margin-right: 10px; ">Total Working Hour : </strong>
                                                                </td>
                                                                <td class="hidden-print">
                                                                    0 : 0 m </td>
                                                            </tr>
                                                            </tbody></table>


                                                        <div class="box-header" style="border-bottom: 1px solid red">
                                                            <h4 class="box-title" style="font-size: 15px">
                                                                <strong>Week : 17 </strong>
                                                            </h4>
                                                        </div>
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                            <tr>
                                                                <th>
                                                                    26-04-2021</th>
                                                                <th>
                                                                    27-04-2021</th>
                                                                <th>
                                                                    28-04-2021</th>
                                                                <th>
                                                                    29-04-2021</th>
                                                                <th>
                                                                    30-04-2021</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>
                                                                    0 : 0 m </td>
                                                                <td>
                                                                    0 : 0 m </td>
                                                                <td>
                                                                    0 : 0 m </td>
                                                                <td>
                                                                    0 : 0 m </td>
                                                                <td class="hidden-print">
                                                                    <span style="font-size: 12px;" class="label label-info std_p">Holiday</span> </td>
                                                            </tr>
                                                            </tbody></table><table>
                                                            <tbody><tr>
                                                                <td colspan="2" class="text-right">
                                                                    <strong style="margin-right: 10px; ">Total Working Hour : </strong>
                                                                </td>
                                                                <td class="hidden-print">
                                                                    0 : 0 m </td>
                                                            </tr>
                                                            </tbody></table>


                                                    </div>
                                                </div>
                                            </div>
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
                                                    0/30 </td>
                                            </tr>
                                            <tr>
                                                <td><strong> Maternity</strong>:</td>
                                                <td class="hidden-print">
                                                    0/180 </td>
                                            </tr>
                                            <tr>
                                                <td><strong> Casual </strong>:</td>
                                                <td class="hidden-print">
                                                    0/15 </td>
                                            </tr>
                                            <tr>
                                                <td style="background-color: #e8e8e8; font-size: 14px; font-weight: bold;">
                                                    <strong> Total</strong>:
                                                </td>
                                                <td style="background-color: #e8e8e8; font-size: 14px; font-weight: bold;" class="hidden-print"> 0 /225 </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="panel panel-custom">
                                        <div class="panel-heading">Leave Report</div>
                                        <div class="panel-body">
                                            <div id="panelChart5">
                                                <div class="chart-pie-my flot-chart" style="padding: 0px; position: relative;"><canvas class="flot-base" width="100" height="250" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 100px; height: 250px;"></canvas><canvas class="flot-overlay" width="100" height="250" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 100px; height: 250px;"></canvas></div>
                                            </div>
                                        </div>
                                    </div> </div>
                                <div class="tab-pane " id="provident_found" style="position: relative;">
                                    <div class="panel panel-custom">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <strong><i class="fa fa-calendar"></i> Provident Found 2021 </strong>
                                                <div class="pull-right hidden-print">
                                                    <span class="hidden-print"><a href="/hrm/admin/user/provident_fund_pdf/2021/2" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="PDF"><span <i="" class="fa fa-file-pdf-o"></span></a></span>
                                                </div>
                                            </div>
                                        </div>
                                        <form id="attendance-form" role="form" enctype="multipart/form-data" action="2/8" method="post" class="form-horizontal form-groups-bordered">
                                            <div class="form-group">
                                                <label for="field-1" class="col-sm-3 control-label">Year<span class="required"> *</span></label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <input type="text" name="year" class="form-control years" value="2021" data-format="yyyy">
                                                        <div class="input-group-addon">
                                                            <a href="#"><i class="fa fa-calendar"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 ">
                                                    <button type="submit" id="sbtn" class="btn btn-primary">Go</button>
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
                                                <td colspan="3" style="padding-left: 8px;" class="hidden-print"><strong>BDT 0.00</strong></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div> </div>
                                <div class="tab-pane " id="Overtime_details" style="position: relative;">
                                    <div class="panel panel-custom">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <strong><i class="fa fa-calendar"></i> Overtime Details 2021 </strong>
                                                <div class="pull-right hidden-print">
                                                    <span class="hidden-print"><a href="/hrm/admin/user/overtime_report_pdf/2021/2" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="PDF"><span <i="" class="fa fa-file-pdf-o"></span></a></span>
                                                </div>
                                            </div>
                                        </div>
                                        <form id="attendance-form" role="form" enctype="multipart/form-data" action="2/9" method="post" class="form-horizontal form-groups-bordered">
                                            <div class="form-group">
                                                <label for="field-1" class="col-sm-3 control-label">Year<span class="required"> *</span></label>
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <input type="text" name="overtime_year" class="form-control years" value="2021" data-format="yyyy">
                                                        <div class="input-group-addon">
                                                            <a href="#"><i class="fa fa-calendar"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 ">
                                                    <button type="submit" id="sbtn" class="btn btn-primary">Go</button>
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
                                                <td colspan="2" style="padding-left: 8px;" class="hidden-print"><strong>0 : 0 m</strong></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div> </div>
                                <div class="tab-pane " id="tasks_details" style="position: relative;">
                                    <div id="panelChart4" class="panel panel-custom">
                                        <div class="panel-heading">
                                            <div class="panel-title">Total Task Time Spent</div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group col-sm-12">
                                                <ul class="timer"><li>0<span> Hours</span></li><li class="dots">:</li><li>0<span> Minutes</span></li><li class="dots">:</li><li>0<span>Seconds</span></li></ul> </div>
                                        </div>
                                    </div>
                                    <div id="panelChart5" class="panel panel-custom">
                                        <div class="panel-heading">
                                            <div class="panel-title">Task Reports</div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="chart-pie flot-chart" style="padding: 0px; position: relative;"><canvas class="flot-base" width="100" height="250" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 100px; height: 250px;"></canvas><canvas class="flot-overlay" width="100" height="250" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 100px; height: 250px;"></canvas><div class="legend"><div style="position: absolute; width: 0px; height: 0px; top: 5px; right: 5px; background-color: rgb(255, 255, 255); opacity: 0.85;"> </div><table style="position:absolute;top:5px;right:5px;;font-size:smaller;color:#545454"><tbody><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid #23b7e5;overflow:hidden"></div></div></td><td class="legendLabel">Not Started</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid #ff902b;overflow:hidden"></div></div></td><td class="legendLabel">In Progress</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid #27c24c;overflow:hidden"></div></div></td><td class="legendLabel">Completed</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid #f05050;overflow:hidden"></div></div></td><td class="legendLabel">Deferred</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid #ff902b;overflow:hidden"></div></div></td><td class="legendLabel">Waiting For Someone</td></tr></tbody></table></div><div class="pieLabelBackground" style="position: absolute; width: 0px; height: 0px; top: 165px; left: 50px; background-color: rgb(34, 34, 34); opacity: 0.8;"></div><span class="pieLabel" id="pieLabel2" style="position:absolute;top:165px;left:50px;"><div class="flot-pie-label">100%</div></span></div>
                                        </div>
                                    </div>
                                    <script>
                                        $(document).ready(function () {
                                            // CHART PIE
                                            // -----------------------------------
                                            (function (window, document, $, undefined) {

                                                $(function () {

                                                    var data = [{
                                                        "label": "Not Started",
                                                        "color": "#23b7e5",
                                                        "data": 0                }, {
                                                        "label": "In Progress",
                                                        "color": "#ff902b",
                                                        "data": 0                }, {
                                                        "label": "Completed",
                                                        "color": "#27c24c",
                                                        "data": 3                }, {
                                                        "label": "Deferred",
                                                        "color": "#f05050",
                                                        "data": 0                }, {
                                                        "label": "Waiting For Someone",
                                                        "color": "#ff902b",
                                                        "data": 0                },];

                                                    var options = {
                                                        series: {
                                                            pie: {
                                                                show: true,
                                                                innerRadius: 0,
                                                                label: {
                                                                    show: true,
                                                                    radius: 0.8,
                                                                    formatter: function (label, series) {
                                                                        return '<div class="flot-pie-label">' +
                                                                            //label + ' : ' +
                                                                            Math.round(series.percent) +
                                                                            '%</div>';
                                                                    },
                                                                    background: {
                                                                        opacity: 0.8,
                                                                        color: '#222'
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    };

                                                    var chart = $('.chart-pie');
                                                    if (chart.length)
                                                        $.plot(chart, data, options);

                                                });

                                            })(window, document, window.jQuery);

                                        });

                                    </script> </div>
                            </div>
                        </div>
                    </div>
                    <script src="/hrm/assets/plugins/Flot/jquery.flot.js"></script>
                    <script src="/hrm/assets/plugins/Flot/jquery.flot.tooltip.min.js"></script>
                    <script src="/hrm/assets/plugins/Flot/jquery.flot.resize.js"></script>
                    <script src="/hrm/assets/plugins/Flot/jquery.flot.pie.js"></script>
                    <script src="/hrm/assets/plugins/Flot/jquery.flot.time.js"></script>
                    <script src="/hrm/assets/plugins/Flot/jquery.flot.categories.js"></script>
                    <script src="/hrm/assets/plugins/Flot/jquery.flot.spline.min.js"></script>
                    <script>
                        // CHART PIE
                        // -----------------------------------
                        (function (window, document, $, undefined) {

                            $(function () {

                                var data = [
                                ];

                                var options = {
                                    series: {
                                        pie: {
                                            show: true,
                                            innerRadius: 0,
                                            label: {
                                                show: true,
                                                radius: 0.8,
                                                formatter: function (label, series) {
                                                    return '<div class="flot-pie-label">' +
                                                        //label + ' : ' +
                                                        Math.round(series.percent) +
                                                        '%</div>';
                                                },
                                                background: {
                                                    opacity: 0.8,
                                                    color: '#222'
                                                }
                                            }
                                        }
                                    }
                                };

                                var chart = $('.chart-pie-my');
                                if (chart.length)
                                    $.plot(chart, data, options);

                            });

                        })(window, document, window.jQuery);

                    </script>
                </div>
            </div>
        </div>
    </section>
@endsection
