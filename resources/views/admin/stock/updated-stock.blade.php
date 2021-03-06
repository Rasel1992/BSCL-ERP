@extends('layouts.backend')

@section('title')
    Updated Stocks
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Updated Stocks</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('admin.stocks.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> List of Stock</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="GET" action="{{ route('admin.stocks.updated.list') }}" class="form-inline float-right">
                            <div class="input-group">
                                <span class="input-group-addon">From</span>
                                <input type="date" class="form-control" name="from"
                                       value="{{ Request::get('from') }}">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">To</span>
                                <input type="date" class="form-control" name="to" value="{{ Request::get('to') }}">
                            </div>
                            <div class="form-group" style="width: 15%">
                                <select class="form-control select2" id="category_id" name="category_id">
                                    <option value="">Select Category</option>
                                    @foreach($categoryData as $cat)
                                        <option value="{{ $cat->id }}" disabled>{{ $cat->category_name }}</option>
                                        @if(!empty($cat->nested))
                                            @foreach($cat->nested as $nc)
                                                <option value="{{ $nc->id }}" {{ ($nc->id==Request::get('category_id'))?'selected':''}}>{{ $nc->category_name }} [ {{ $nc->category_code }}] </option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            @if(Auth::user()->type == 'super-admin')
                            <div class="form-group" style="width: 15%">
                                <select class="form-control select2" id="location" name="location">
                                    <option value="">Select Location</option>
                                    <option value="hq" {{'hq' == Request::get('location')?'selected':''}} >Head Quarter
                                    </option>
                                    <option value="gs1" {{'gs1' == Request::get('location')?'selected':''}}>GS Gazipur
                                    </option>
                                    <option value="gs2" {{'gs2' == Request::get('location')?'selected':''}}>GS Bethbunia
                                    </option>
                                </select>
                            </div>
                            @endif
                            <div class="form-group">
                                <label class="sr-only">&nbsp;</label>
                                <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}"
                                       placeholder="Input your search text...">
                            </div>
                            <div class="form-group" style="width: 15%">
                                <select class="form-control select2" id="per_page" name="per_page">
                                    @php $stockPage = $stocks->count();
                                    $perPage = Request::get('per_page') ?? 50;
                                    @endphp
                                    <option value="">Select Location</option>
                                    <option value="25" {{ ('25' == $perPage) ? 'selected' : '' }}>25
                                    </option>
                                    <option value="50" {{ ('50' == $perPage) ? 'selected' : '' }}>50
                                    </option>
                                    <option value="100" {{ ('100' == $perPage) ? 'selected' : '' }}>100
                                    </option>
                                    <option value="150" {{ ('150' == $perPage) ? 'selected' : '' }}>150
                                    </option>
                                    <option value="200" {{ ('200' == $perPage) ? 'selected' : '' }}>200
                                    </option>
                                    <option value="{{ $stockPage }}" {{ ($stockPage == $perPage) ? 'selected' : '' }}>Total Data
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info mb-2"><i class="fa fa-search"></i> Search</button>
                            <a href="{{ route('admin.stocks.updated.list') }}" class="btn btn-warning mb-2"><i class="fa fa-times"></i></a>
                        </form>
                    </div>
                </div>
                <br>
                <table class="table table-hover table-2nd-no-sort">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Stock Code</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Qty</th>
                        <th>Location</th>
                        <th>Date</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stocks as  $key => $stock)
                        <tr>
                            <td>  {{ $serial++ }}</td>
                            <td> {{ $stock->stock_code }}</td>
                            <td> {{ $stock->description }}</td>
                            <td> {{ $stock->category->category_name }} [{{ $stock->category->category_code }}] </td>
                            <td> @if($stock->qty < 5) <span style="color: red">{{ $stock->qty }}</span> @else {{ $stock->qty }} @endif</td>
                            <td> @if($stock->location == 'hq') Head Quarter @elseif($stock->location == 'gs1') GSGazipur @else GS Bethbunia @endif</td>
                            <td>{{ $stock->stock_date }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($stocks->total())
                    <div class="row">
                        <div class="col-sm-5">
                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                                {{ $stocks->appends(Request::except('page'))->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection


