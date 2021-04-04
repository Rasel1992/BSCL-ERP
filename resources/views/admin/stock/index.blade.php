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
                    <a class="button add" href="{{ route('admin.stocks.summary') }}">Summary</a>
                    <a href="{{ route('admin.stocks.create').qString() }}" class="button add"> Add Stock</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('admin.stocks.index') }}" class="form-inline float-right">
                            <div class="form-group" style="width: 25%">
                                <select class="form-control select2" id="category_id" name="category_id">
                                    <option value="">Select Category</option>
                                    @foreach($categoryData as $cat)
                                        <option value="{{ $cat->id }}" disabled>{{ $cat->category_name }}</option>
                                        @if(!empty($cat->nested))
                                            @foreach($cat->nested as $nc)
                                                <option value="{{ $nc->id }}" {{ ($nc->id==Request::get('category_id'))?'selected':''}}>-- {{ $nc->category_name }}</option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" style="width: 25%">
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

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stocks as  $key => $stock)
                        <tr>
                            <td> {{$key + $stocks->firstItem()}}</td>
                            <td> {{ $stock->stock_code }}</td>
                            <td> {{ $stock->description }}</td>
                            <td> {{ $stock->category->category_name }}</td>
                            <td> {{ $stock->qty }}</td>
                            <td> @if($stock->location == 'hq') Head Quarter @elseif($stock->location == 'gs1') GSGazipur @else GS Bethbunia @endif</td>

                            <td class="row-options text-muted small">
                                <a href="{{route('admin.stocks.edit', $stock->id).qString() }}" class="ajax-modal-btn"><i data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-edit"></i></a>&nbsp;
                                <form method="POST" action="{{route('admin.stocks.destroy', $stock->id).qString() }}" accept-charset="UTF-8" class="data-form">
                                    @csrf
                                    @method('delete')
                                    <a href="{{route('admin.stocks.get-assign-stock-form', $stock->id).qString() }}" class="confirm ajax-silent" title="Assign Stock"><i class="fa fa-plus"></i></a>
                                    <a href="javascript:void(0)" @click="destroy" class="confirm ajax-silent" title="Trash" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash-o"></i></a>
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
        @include('admin.stock.form_import')
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

