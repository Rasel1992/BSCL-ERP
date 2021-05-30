@extends('layouts.backend')

@section('title')
    Requisition Lists
@endsection
@section('styles')
    <style>
        .file-up {

            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .content-text {
            justify-content: center;
        }

        .file-upload {
            height: 30px;
            width: 30px;
            border-radius: 50px;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 4px solid #FFFFFF;
            overflow: hidden;
            background-image: linear-gradient(to bottom, #2590EB 50%, #FFFFFF 50%);
            background-size: 100% 200%;
            transition: all 1s;
            color: #FFFFFF;
            font-size: 20px;
        }

        input[type='file'] {
            height: 200px;
            width: 200px;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            cursor: pointer;

        }

    </style>
@endsection
@section('content')
    <section class="content">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li {{ (isset($list)) ? 'class=active' : '' }}><a href="{{ route('admin.request.requisition.index') }}">Receive</a></li>
                                <li {{ (isset($send)) ? 'class=active' : '' }}><a href="{{ route('admin.request.requisition.send') }}" >Send</a></li>
                                <li {{ (isset($create)) ? 'class=active' : '' }}><a href="{{ route('admin.request.requisition.create') }}">Apply</a></li>
                                @if (isset($show))
                                    <li class="active">
                                        <a href="#">
                                            <i class="fa fa-list-alt" aria-hidden="true"></i> Details
                                        </a>
                                    </li>
                                @endif
                            </ul>
                            <div class="tab-content">
                                @if(isset($list))
                                <div class="tab-pane active">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Received Requisition Lists</h3>
                                        </div> <!-- /.box-header -->
                                    <br>
                                            <table class="table table-hover table-2nd-no-sort">
                                                <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Requisition By</th>
                                                    <th>Department</th>
                                                    <th>Designation</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($requisition_to as $key => $to)
                                                    <tr>
                                                        <td> {{$key + $requisition_to->firstItem()}}</td>
                                                        <td>{{$to->requisitionBy->name}}</td>
                                                        <td>{{$to->requisitionBy->departments->department}}</td>
                                                        <td>{{$to->requisitionBy->designation}}</td>
                                                        <td>
                            <span class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                                <i class="fa fa-cogs"></i> <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu" style="left: -115px;">
                                                 <form method="POST" action="{{ route('admin.request.requisition.destroy', $to->id).qString() }}" accept-charset="UTF-8" class="data-form">
                                                     @csrf
                                                     @method('delete')
                                                     <li><a href="{{ route('admin.request.requisition.show', $to->id) }}"><i class="fa fa-eye"></i></a></li>
                                                    <li><a href="javascript:void(0)" @click="destroy"><i class="fa fa-trash-o"></i> </a></li>
                                                  </form>
                                            </ul>
                                        </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            @if($requisition_to->total())
                                                <div class="row">
                                                    <div class="col-sm-5">

                                                    </div>
                                                    <div class="col-sm-7">
                                                        <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                                                            {{ $requisition_to->appends(Request::except('page'))->links() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                </div>

                                @elseif(isset($send))
                                        <div class="tab-pane active">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Send Requisition Lists</h3>
                                            </div> <!-- /.box-header -->
                                            <br>
                                            <table class="table table-hover table-2nd-no-sort">
                                                <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Requisition By</th>
                                                    <th>Department</th>
                                                    <th>Designation</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($requisition_by as $key => $by)
                                                    <tr>
                                                        <td> {{$key + $requisition_by->firstItem()}}</td>
                                                        <td>{{$by->requisitionBy->name}}</td>
                                                        <td>{{$by->requisitionBy->departments->department}}</td>
                                                        <td>{{$by->requisitionBy->designation}}</td>
                                                        <td>
                            <span class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                                <i class="fa fa-cogs"></i> <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu" style="left: -115px;">
                                                 <form method="POST" action="{{ route('admin.request.requisition.destroy', $by->id).qString() }}" accept-charset="UTF-8" class="data-form">
                                                     @csrf
                                                     @method('delete')
                                                     <li><a href="{{ route('admin.request.requisition.show', $by->id) }}"><i class="fa fa-eye"></i></a></li>
                                                    <li><a href="javascript:void(0)" @click="destroy"><i class="fa fa-trash-o"></i> </a></li>
                                                  </form>
                                            </ul>
                                        </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            @if($requisition_by->total())
                                                <div class="row">
                                                    <div class="col-sm-5">

                                                    </div>
                                                    <div class="col-sm-7">
                                                        <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                                                            {{ $requisition_by->appends(Request::except('page'))->links() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                @elseif(isset($create))

                                <div class="tab-pane active">
                                    <div class="box box-info">
                                        <div class="box-header">
                                            <i class="fa fa-envelope"></i>

                                            <h3 class="box-title">Requisition Form</h3>
                                            <!-- tools box -->
                                            <div class="pull-right box-tools">
                                                <a href="{{ route('admin.request.requisition.index') }}" class="btn btn-info pull-right">Back to list</a>
                                            </div>
                                            <!-- /. tools -->
                                        </div>
                                        <div class="box-body">
                                            <form action="{{route('admin.request.requisition.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="input-group date">
                                                                    <div class="input-group-addon">
                                                                        Requisition SL No. :
                                                                    </div>
                                                                    @php $randomNum=substr(str_shuffle("0123456789"), 0, 2); @endphp

                                                                    <input type="text" class="form-control" name="sl_number" value="{{$randomNum}}" readonly>
                                                                </div>
                                                                <!-- /.input group -->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6"></div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="input-group date">
                                                                    <div class="input-group-addon">
                                                                        Requisition By :
                                                                    </div>
                                                                    <input type="text" class="form-control" name="requisition_by" value="{{Auth::user()->name}}" readonly>
                                                                </div>
                                                                <!-- /.input group -->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6"></div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="input-group date">
                                                                    <div class="input-group-addon">
                                                                        Requisition To :
                                                                    </div>
                                                                    <select class="form-control" id="requisition_to" name="requisition_to">
                                                                        <option value="">Select</option>
                                                                        @foreach($users as $user)
                                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <!-- /.input group -->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6"></div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="input-group date">
                                                                    <div class="input-group-addon">
                                                                        Actual User :
                                                                    </div>
                                                                    <input type="text" class="form-control" name="actual_user" value="{{old('actual_user')}}">
                                                                </div>
                                                                <!-- /.input group -->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6"></div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="input-group date">
                                                                    <div class="input-group-addon">
                                                                        Designation :
                                                                    </div>
                                                                    <input type="text" class="form-control" name="designation" value="{{Auth::user()->designation}}" readonly>
                                                                </div>
                                                                <!-- /.input group -->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6"></div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="input-group date">
                                                                    <div class="input-group-addon">
                                                                        Department :
                                                                    </div>
                                                                    <input type="text" class="form-control" name="dept" value="{{Auth::user()->departments->department}}" readonly>
                                                                </div>
                                                                <!-- /.input group -->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6"></div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="input-group date">
                                                                    <div class="input-group-addon">
                                                                        Date :
                                                                    </div>
                                                                    <input type="date" class="form-control" name="requisition_date" value="{{date('Y-m-d')}}" readonly>
                                                                </div>
                                                                <!-- /.input group -->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6"></div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="box-body">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Sl. No</th>
                                                                    <th>Item Code</th>
                                                                    <th>Particulars</th>
                                                                    <th>Quantity</th>
                                                                    <th>Disbursement</th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr v-for="(field, index) in requisition.fields">
                                                                    <td><input type="number" step="any" min="1" class="form-control" name="s_no[]" v-model="field.s_no" id="s_no" value="" required></td>
                                                                    <td><input type="text" step="any" min="1" class="form-control" name="item_code[]" v-model="field.item_code" id="item_code" value="" required></td>
                                                                    <td><input type="text" step="any" min="1" class="form-control" name="particulars[]" v-model="field.particulars" id="particulars" value="" required></td>
                                                                    <td><input type="number" step="any" min="1" class="form-control" name="qty[]" v-model="field.qty" id="qty" value="" required></td>
                                                                    <td><input type="text" step="any" min="1" class="form-control" name="disbursement[]" v-model="field.disbursement" id="disbursement" value="" required></td>
                                                                    <td><a v-if="requisition.fields.length > 1" class="pull-right" href="javascript:void(0)" @click="requisition.fields.splice(index, 1)"><i class="fa fa-times"></i></a> <span v-else>&nbsp;</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><button class="btn btn-success" type="button" @click="addFields"><i class="fa fa-plus"></i></button></td>
                                                                    <td colspan="5"></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-md-1"></div>&nbsp;
                                                        <div class="col-md-2">
                                                            @if(isset(Auth::user()->signature))
                                                                {!! viewImg('user/signature', Auth::user()->signature, ['class' => 'thumbnail', 'style' => 'width:100px; height:30px;']) !!}
                                                            @else
                                                                <div class="file-up">
                                                                    <div class="file-upload">
                                                                        <input type="file" name="signature" />
                                                                        <i class="fa fa-arrow-up"></i>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <hr>
                                                            <label>Requisitioned By</label>
                                                        </div> &nbsp;
                                                        <div class="col-md-2">
                                                            <div class="file-up">
                                                                <div class="file-upload">
                                                                    <input disabled type="file" name="signature" />
                                                                    <i class="fa fa-arrow-up"></i>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <label>Verified By Wing</label>
                                                        </div>&nbsp;
                                                        <div class="col-md-2">
                                                            <div class="file-up">
                                                                <div class="file-upload">
                                                                    <input disabled type="file" name="signature" />
                                                                    <i class="fa fa-arrow-up"></i>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <label>Approved By</label>
                                                        </div>&nbsp;
                                                        <div class="col-md-2">
                                                            <div class="file-up">
                                                                <div class="file-upload">
                                                                    <input disabled type="file" name="signature" />
                                                                    <i class="fa fa-arrow-up"></i>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <label>Received By</label>
                                                        </div>&nbsp;
                                                        <div class="col-md-2">
                                                            <div class="file-up">
                                                                <div class="file-upload">
                                                                    <input disabled type="file" name="signature" />
                                                                    <i class="fa fa-arrow-up"></i>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <label class="">Disbursed By</label>
                                                        </div>&nbsp;
                                                        <div class="col-md-1"></div>
                                                    </div>
                                                </div>
                                                <div class="box-footer clearfix">
                                                    <button type="submit" class="pull-right btn btn-success">Send
                                                        <i class="fa fa-arrow-circle-right"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @else
                                    <div class="tab-pane active">
                                        <div class="box box-info">
                                            <div class="box-header">
                                                <i class="fa fa-envelope"></i>

                                                <h3 class="box-title">Requisition Details</h3>
                                                <!-- tools box -->
                                                <div class="pull-right box-tools">
                                                    <a href="{{ route('admin.request.requisition.index') }}" class="btn btn-info pull-right">Back to list</a>
                                                </div>
                                                <!-- /. tools -->
                                            </div>
                                            <div class="box-body">
                                                <form action="{{route('admin.request.requisition.store') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            Requisition SL No. :
                                                                        </div>
                                                                        @php $randomNum=substr(str_shuffle("0123456789"), 0, 2); @endphp

                                                                        <input type="text" class="form-control" name="requisition_by" value="{{ $data->sl_number }}" readonly>
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"></div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            Requisition By :
                                                                        </div>
                                                                        <input type="text" class="form-control" value="{{ $data->requisitionBy->name }}" readonly>
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"></div>
                                                        </div>
                                                        @if(empty($data->verified_by) && isset( $data->requisitionBy->name))
                                                            <div class="col-md-12">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <div class="input-group date">
                                                                            <div class="input-group-addon">
                                                                                Verified By :
                                                                            </div>
                                                                            <input type="text" class="form-control" name="verified_by" value="{{Auth::user()->name}}" readonly>
                                                                        </div>
                                                                        <!-- /.input group -->
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6"></div>
                                                            </div>
                                                        @endif
                                                        @if(empty($data->approved_by) && isset( $data->requisitionBy->name) && isset( $data->verifiedBy->name))
                                                            <div class="col-md-12">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <div class="input-group date">
                                                                            <div class="input-group-addon">
                                                                                Approved By :
                                                                            </div>
                                                                            <input type="text" class="form-control" name="approved_by" value="{{Auth::user()->name}}" readonly>
                                                                        </div>
                                                                        <!-- /.input group -->
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6"></div>
                                                            </div>
                                                        @endif
                                                        @if(empty($data->received_by) && isset( $data->requisitionBy->name) && isset( $data->verifiedBy->name) && isset( $data->approvedBy->name))
                                                            <div class="col-md-12">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <div class="input-group date">
                                                                            <div class="input-group-addon">
                                                                                Received By :
                                                                            </div>
                                                                            <input type="text" class="form-control" name="received_by" value="{{Auth::user()->name}}" readonly>
                                                                        </div>
                                                                        <!-- /.input group -->
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6"></div>
                                                            </div>
                                                        @endif
                                                        @if(empty($data->disbursed_by) && isset( $data->requisitionBy->name) && isset( $data->verifiedBy->name) && isset( $data->approvedBy->name) && isset( $data->receivedBy->name))
                                                            <div class="col-md-12">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <div class="input-group date">
                                                                            <div class="input-group-addon">
                                                                                Disbursed By :
                                                                            </div>
                                                                            <input type="text" class="form-control" name="disbursed_by" value="{{Auth::user()->name}}" readonly>
                                                                        </div>
                                                                        <!-- /.input group -->
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6"></div>
                                                            </div>
                                                        @endif
                                                        @if(isset($data->verified_by))
                                                        <div class="col-md-12">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            Verified By :
                                                                        </div>
                                                                        <input type="text" class="form-control" name="verified_by" value="{{ $data->verifiedBy->name }}" readonly>
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"></div>
                                                        </div>
                                                        @endif

                                                        @if(isset($data->approved_by))
                                                        <div class="col-md-12">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            Approved By :
                                                                        </div>
                                                                        <input type="text" class="form-control" name="approved_by" value="{{ $data->approvedBy->name }}" readonly>
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"></div>
                                                        </div>
                                                        @endif

                                                        @if(isset($data->received_by))
                                                        <div class="col-md-12">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            Received By :
                                                                        </div>
                                                                        <input type="text" class="form-control" name="received_by" value="{{ $data->receivedBy->name }}" readonly>
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"></div>
                                                        </div>
                                                        @endif

                                                        @if(isset($data->disbursed_by))
                                                        <div class="col-md-12">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            Disbursed By :
                                                                        </div>
                                                                        <input type="text" class="form-control" name="disbursed_by" value="{{ $data->disbursedBy->name }}" readonly>
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"></div>
                                                        </div>
                                                        @endif
                                                        <div class="col-md-12">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            Actual User :
                                                                        </div>
                                                                        <input type="text" class="form-control" name="actual_user" value="{{isset($data->actual_user) ? $data->actual_user : ''}}">
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"></div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            Designation :
                                                                        </div>
                                                                        <input type="text" class="form-control" name="designation" value="{{ $data->requisitionBy->name }}" readonly>
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"></div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            Department :
                                                                        </div>
                                                                        <input type="text" class="form-control" name="dept" value="{{ $data->requisitionBy->departments->department }}" readonly>
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"></div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            Date :
                                                                        </div>
                                                                        <input type="date" class="form-control" name="requisition_date" value="{{ $data->requisition_date }}" readonly>
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"></div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="box-body">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Sl. No</th>
                                                                        <th>Item Code</th>
                                                                        <th>Particulars</th>
                                                                        <th>Quantity</th>
                                                                        <th>Disbursement</th>
                                                                        <th></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($data->requisitionItems as $key => $val)
                                                                        <tr>
                                                                            <td>{{++$key}}</td>
                                                                            <td>{{$val->item_code}}</td>
                                                                            <td>{{$val->particulars}}</td>
                                                                            <td>{{$val->qty}}</td>
                                                                            <td>{{$val->disbursement}}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="col-md-1"></div>&nbsp;
                                                            <div class="col-md-2">
                                                                @if($data->requisitionBy->signature)
                                                                    {!! viewImg('user/signature', $data->requisitionBy->signature, ['class' => 'thumbnail', 'style' => 'width:100px; height:30px;']) !!}
                                                                @endif

                                                                <hr>
                                                                <label>Requisitioned By</label>
                                                            </div> &nbsp;
                                                            <div class="col-md-2">
                                                                @if(isset(Auth::user()->signature))
                                                                    {!! viewImg('user/signature', Auth::user()->signature, ['class' => 'thumbnail', 'style' => 'width:100px; height:30px;']) !!}
                                                                @else
                                                                    <div class="file-up">
                                                                        <div class="file-upload">
                                                                            <input type="file" name="signature" />
                                                                            <i class="fa fa-arrow-up"></i>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                <hr>
                                                                <label>Verified By Wing</label>
                                                            </div>&nbsp;
                                                            <div class="col-md-2">
                                                                <div class="file-up">
                                                                    <div class="file-upload">
                                                                        <input disabled type="file" name="signature" />
                                                                        <i class="fa fa-arrow-up"></i>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <label>Approved By</label>
                                                            </div>&nbsp;
                                                            <div class="col-md-2">
                                                                <div class="file-up">
                                                                    <div class="file-upload">
                                                                        <input disabled type="file" name="signature" />
                                                                        <i class="fa fa-arrow-up"></i>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <label>Received By</label>
                                                            </div>&nbsp;
                                                            <div class="col-md-2">
                                                                <div class="file-up">
                                                                    <div class="file-upload">
                                                                        <input disabled type="file" name="signature" />
                                                                        <i class="fa fa-arrow-up"></i>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <label class="">Disbursed By</label>
                                                            </div>&nbsp;
                                                            <div class="col-md-1"></div>
                                                        </div>
                                                    </div>
                                                    <div class="box-footer clearfix">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-4"></div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <div class="input-group date">
                                                                            <div class="input-group-addon">
                                                                                Send To :
                                                                            </div>
                                                                            <select class="form-control" id="requisition_to" name="requisition_to">
                                                                                <option value="">Select</option>
                                                                                @foreach($users as $user)
                                                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <!-- /.input group -->
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <button type="submit" class="pull-right btn btn-success">Send
                                                                        <i class="fa fa-arrow-circle-right"></i></button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                @endif
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        new Vue({
            el: '#app',
            data: {
                isEdit: false,
                requisition: {
                    fields: [{
                        s_no: '',
                        item_code: '',
                        particulars: '',
                        qty: '',
                        disbursement: '',
                    }]
                }
            },
            methods: {
                addFields: function () {
                    this.requisition.fields.push({
                        s_no: '',
                        item_code: '',
                        particulars: '',
                        qty: '',
                        disbursement: '',
                    });
                },
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
