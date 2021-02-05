@extends('layouts.backend')

@section('title')
    User | Details
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="panel-body">
                @if (isset($user))
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <caption><h3>User Details <a href="{{ route('admin.users.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> Back </a></h3></caption>
                                    <tbody>
                                    <tr>
                                        <th style="width:120px;">User Name</th>
                                        <th style="width:10px;">:</th>
                                        <td>
                                            {{ $user->name }}
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
                                @if($user->stocks)
                                    @foreach($user->stocks as $key => $stock)
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
