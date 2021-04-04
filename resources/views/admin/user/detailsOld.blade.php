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
                        <div class="row">
                            <div class="col-md-12">
                                <caption><h3>User Details <a href="{{ route('admin.users.index') }}"
                                                             class="btn btn-info pull-right"><i
                                                class="fa fa-angle-double-up"></i> Back </a></h3></caption>
                                <div class="col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Avatar</label>
                                        @if(isset($user->image))
                                            {!! viewImg('user', $user->image, ['class' => 'thumbnail', 'style' => 'width:100%;']) !!}
                                        @else
                                            <img src="https://placehold.it/250x400/eee?text=No Image Found"
                                                 class="thumbnail" width="100%" alt="Avatar">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                        <tr>
                                            <th style="width:120px;">User ID</th>
                                            <th style="width:10px;">:</th>
                                            <td>
                                                {{ $user->user_id ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width:120px;">User Name</th>
                                            <th style="width:10px;">:</th>
                                            <td>
                                                {{ $user->name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width:120px;">Department</th>
                                            <th style="width:10px;">:</th>
                                            <td>@if($user->departments){{ $user->departments->department }}@endif</td>
                                        </tr>
                                        <tr>
                                            <th style="width:120px;">Designation</th>
                                            <th style="width:10px;">:</th>
                                            <td>
                                                {{ $user->designation ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width:120px;">Type</th>
                                            <th style="width:10px;">:</th>
                                            <td>
                                                {{ $user->type }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width:120px;">Email</th>
                                            <th style="width:10px;">:</th>
                                            <td> {{ $user->email }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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

                        <table class="table">
                            <thead>
                            <tr>
                                <caption><h3>Assigned Inventories</h3></caption>
                            </tr>
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
                @endif
            </div>
        </div>
    </section>
@endsection
