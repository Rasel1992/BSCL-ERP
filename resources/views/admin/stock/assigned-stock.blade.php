@extends('layouts.backend')

@section('title')
    Assigned Stocks
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Assigned Stocks</h3>
                <a href="{{ route('admin.stocks.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> List of Stock</a>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="GET" action="{{ route('admin.stocks.assigned-stock') }}"
                              class="form-inline float-right">
                            <div class="form-group mx-sm-3 mb-2">
                                <div class="input-group">
                                    <span class="input-group-addon">From</span>
                                    <input type="date" class="form-control" name="from" value="{{ Request::get('from') }}">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">To</span>
                                    <input type="date" class="form-control" name="to" value="{{ Request::get('to') }}">
                                </div>
                            </div>
                            <div class="form-group" style="width: 15%">
                                <select class="form-control select2" id="category_id" name="category_id">
                                    <option value="">Select Category</option>
                                    @foreach($categoryData as $cat)
                                        <option
                                            value="{{ $cat->id }}" disabled>{{ $cat->category_name }}</option>
                                        @if(!empty($cat->nested))
                                            @foreach($cat->nested as $nc)
                                                <option value="{{ $nc->id }}" {{ ($nc->id==Request::get('category_id'))?'selected':''}}>-- {{ $nc->category_name }}</option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>
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
                            <button type="submit" class="btn btn-info mb-2"><i class="fa fa-search"></i> Search</button>
                            <a href="{{ route('admin.stocks.assigned-stock') }}" class="btn btn-warning mb-2"><i class="fa fa-times"></i></a>
                        </form>
                    </div>
                </div>
                <br>
                <table class="table table-hover table-2nd-no-sort" id="file_export">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Stock Category</th>
                        <th>Assign To</th>
                        <th>Apply No.</th>
                        <th>Assigned Qty</th>
                        <th>Qty In Stock</th>
                        <th>Location</th>
                        <th>Assign Date</th>
                        <th>Remark</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($assignedStocks as  $key => $stock)
                        <tr>
                            <td> {{$key + $assignedStocks->firstItem()}}</td>
                            <td>@if($stock->stock) {{ $stock->stock->category->category_name }} @endif</td>
                            <td>
                                @if($stock->assign_to == 'user') <strong>Person:</strong><br><a href="{{ route('admin.users.show',$stock->user->id ) }}">{{$stock->user->name }}</a>
                                @else
                                    <strong>Department:</strong><br><a href="{{ route('admin.departments.show',$stock->department->id ) }}">{{ $stock->department->department}}</a>
                                @endif
                            </td>
                            <td> {{ $stock->apply_no ?? '-'}}</td>
                            <td> {{ $stock->qty }}</td>
                            <td> @if($stock->stock){{ $stock->stock->qty }}@endif</td>
                            <td> @if($stock->stock) @if($stock->stock->location == 'hq') HeadQuarter @elseif($stock->stock->location == 'gs1') GS Gazipur @else GSBethbunia @endif @else - @endif</td>
                            <td> {{ $stock->assign_date }} </td>
                            <td> {{ $stock->remark ?? '-' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($assignedStocks->total())
                    <div class="row">
                        <div class="col-sm-5">
                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                                {{ $assignedStocks->appends(Request::except('page'))->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div> <!-- /.box-body -->
        </div> <!-- /.box -->
    </section>
@endsection

@push('scripts')
    <script>
        new Vue({
            el: '#app',
            methods: {
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

