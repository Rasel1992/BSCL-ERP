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
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="GET" action="{{ route('admin.stocks.assigned-stock') }}" class="form-inline float-right">
                            <div class="form-group mx-sm-3 mb-2">
                                <div class="row">
                                    <div class="input-group inline">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">From</span>
                                        </div>
                                        <input type="date" class="form-control" name="from" value="{{ Request::get('from') }}">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">To</span>
                                        </div>
                                        <input type="date" class="form-control" name="to" value="{{ Request::get('to') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <select class="form-control" id="category_id" name="category_id">
                                    <option value="">Select Category</option>
                                    @foreach($categoryData as $cat)
                                        <option value="{{ $cat->id }}" {{ ($cat->id==Request::get('category_id'))?'selected':''}}>{{ $cat->category_name }}</option>
                                        @if(!empty($cat->nested))
                                            @foreach($cat->nested as $nc)
                                                <option value="{{ $nc->id }}"  {{ ($nc->id==Request::get('category_id'))?'selected':''}}> -- {{ $nc->category_name }}</option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <select class="form-control" id="location" name="location">
                                    <option value="">Select Location</option>
                                    <option value="hq" {{old('location') == Request::get('hq')?'selected':''}} >Head Quarter
                                    </option>
                                    <option value="gs1" {{old('location') == Request::get('gs1')?'selected':''}}>GS Gazipur
                                    </option>
                                    <option value="gs2" {{old('location') == Request::get('gs2')?'selected':''}}>GS Bethbunia
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info mb-2"><i class="fa fa-search"></i> Search</button>
                            <a href="{{ route('admin.stocks.assigned-stock') }}" class="btn btn-warning mb-2"><i class="fa fa-times"></i></a>
                        </form>
                    </div>
                </div>
                <table class="table table-hover table-2nd-no-sort" id="file_export">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Stock Category</th>
                        <th>Assign To</th>
                        <th>Qty</th>
                        <th>Location</th>
                        <th>Assign Date</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($assignedStocks as  $key => $stock)
                        <tr>
                            <td> {{$key + $assignedStocks->firstItem()}}</td>
                            <td> {{ $stock->stock->category->category_name }}</td>
                            <td>
                                @if($stock->assign_to == 'user') <strong>Person:</strong><br><a href="{{ route('admin.users.show',$stock->user->id ) }}">{{$stock->user->name }}</a>
                                @else
                                    <strong>Department:</strong><br><a href="{{ route('admin.departments.show',$stock->department->id ) }}">{{ $stock->department->department}}</a>
                                @endif
                            </td>
                            <td> {{ $stock->qty }}</td>
                            <td> @if($stock->stock->location == 'hq') Head Quarter @elseif($stock->stock->location == 'gs1') GS Gazipur @else GS Bethbunia @endif</td>
                            <td> {{ $stock->assign_date }} </td>
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

