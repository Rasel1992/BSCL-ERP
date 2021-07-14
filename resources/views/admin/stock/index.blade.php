@extends('layouts.backend')

@section('title')
    Stocks
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Stocks</h3>
                <div class="box-tools pull-right">
                    @can('see stock all summary')
                    <a class="button add" href="{{ route('admin.stocks.summary') }}">All Summary</a>
                    @endcan
                    @can('see stock summary')
                    <a class="button add" href="{{ route('admin.stocks.location.summary') }}">Summary</a>
                    @endcan
                    @can('see updated stock list')
                    <a class="button add" href="{{ route('admin.stocks.updated.list') }}">Updated Stock List</a>
                    @endcan
                    @can('add stock')
                    <a href="{{ route('admin.stocks.create').qString() }}" class="button add"> Add Stock</a>
                    @endcan

                </div>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="GET" action="{{ route('admin.stocks.index') }}" class="form-inline float-right">
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
                                    <option value="{{ $stockPage }}" {{ ($stockPage == $perPage) ? 'selected' : '' }}>Total Stock Data
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info mb-2"><i class="fa fa-search"></i> Search</button>
                            <a href="{{ route('admin.stocks.index') }}" class="btn btn-warning mb-2"><i class="fa fa-times"></i></a>
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
                            <td>  {{ $serial++ }} </td>
                            <td> {{ $stock->stock_code }}</td>
                            <td> {{ $stock->description }}</td>
                            <td> {{ $stock->category->category_name }} [ {{ $stock->category->category_code }} ] </td>
                            <td> @if($stock->qty < 5) <span style="color: red">{{ $stock->qty }}</span> @else {{ $stock->qty }} @endif</td>
                            <td> @if($stock->location == 'hq') Head Quarter @elseif($stock->location == 'gs1') GSGazipur @else GS Bethbunia @endif</td>
                            <td>{{ $stock->stock_date }}</td>

                            <td class="row-options text-muted small">
                                @can('edit stock')
                                <a href="{{route('admin.stocks.edit', $stock->id).qString() }}" class="ajax-modal-btn"><i data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-edit"></i></a>&nbsp;
                                @endcan

                                <form method="POST" action="{{route('admin.stocks.destroy', $stock->id).qString() }}" accept-charset="UTF-8" class="data-form">
                                    @csrf
                                    @method('delete')

                                    @can('assign stock')
                                    <a href="{{route('admin.stocks.get-assign-stock-form', $stock->id).qString() }}" class="confirm ajax-silent" title="Assign Stock"><i class="fa fa-plus"></i></a>
                                    @endcan

                                    @can('delete stock')
                                    <a href="javascript:void(0)" @click="destroy" class="confirm ajax-silent" title="Trash" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash-o"></i></a>
                                    @endcan
                                </form>
                            </td>
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
            </div> <!-- /.box-body -->
        </div> <!-- /.box -->
        <div class="box collapsed-box">
            <div class="box-header">
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <br>
            <div class="box-body">
                @include('admin.stock.form_import')
            </div>
        </div>
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

