@extends('layouts.backend')

@section('title')
    Department | Details
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="panel-body">
                @if (isset($department))
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <caption><h3>Department Details <a href="{{ route('admin.departments.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> Back </a></h3></caption>
                                    <tbody>
                                    <tr>
                                        <th style="width:120px;">Department Name</th>
                                        <th style="width:10px;">:</th>
                                        <td>
                                            {{ $department->department }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width:120px;">Designation</th>
                                        <th style="width:10px;">:</th>
                                        <td>
                                            {{ $department->designation }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <caption><h3>Assigned Stocks</h3></caption>
                                </tr>
                                <tr>
                                    <th>SL</th>
                                    <th>Stock Category</th>
                                    <th>Stock Qty</th>
                                    <th>Assigned Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($department->stocks)
                                    @foreach($department->stocks as $key => $stock)
                                        <td> {{++ $key}}</td>
                                        <td> {{ $stock->stock->category->category_name }}</td>
                                        <td>{{$stock->qty}}<br></td>
                                        <td>{{$stock->assign_date}}<br></td>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                    </div>
                @endif
            </div>
    </section>
@endsection
