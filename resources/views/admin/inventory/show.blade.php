@extends('layouts.backend')

@section('title')
    Inventories
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Inventory Details</h3><a href="{{ route('admin.inventories.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> Back to List</a>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th class="float-center">Asset Code</th>
                            <td> {{ $inventory->asset_code  }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td> {{ $inventory->description  }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td> {{ $inventory->category->category_name }}</td>
                        </tr>
                        <tr>
                            <th>Allocate To</th>
                            <td> @if($inventory->assign_to == 'user') <strong>Person:</strong><br> {{$inventory->user->name }}
                                @else
                                    <strong>Department:</strong><br> {{ $inventory->department->department}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Voucher No</th>
                            <td> {{ $inventory->voucher_no }}</td>
                        </tr>
                        <tr>
                            <th>Qty</th>
                            <td> {{ $inventory->qty }}</td>
                        </tr>
                        <tr>
                            <th>Cost</th>
                            <td> {{ $inventory->cost }}</td>
                        </tr>
                        <tr>
                            <th>Location</th>
                            <td> @if($inventory->location == 'hq') Head Quarter @elseif($inventory->location == 'gs1') GS Gazipur @else GS Bethbunia @endif</td>
                        </tr>
                        <tr>
                            <th>QR Code</th>
                            <td>  {!! QrCode::size(50)->generate(url('inventories',$inventory->id)); !!}</td>
                        </tr>
                        <tr>
                            <th>Purchase Date</th>
                            <td>{{ $inventory->purchase_date}}</td>
                        </tr>
                        <tr>
                            <th>Assign Date</th>
                            <td>{{ $inventory->assign_date}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-3">
                </div>
            </div> <!-- /.box-body -->
        </div> <!-- /.box -->
    </section>
@endsection


