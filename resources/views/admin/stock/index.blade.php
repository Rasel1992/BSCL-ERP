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
                    <a href="{{ route('admin.stocks.create') }}" class="button add"> Add Stock</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <table class="table table-hover table-2nd-no-sort" id="file_export">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Qty</th>
                        <th>Location</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stocks as  $key => $stock)
                        <tr>
                            <td> {{$key + $stocks->firstItem()}}</td>
                            <td> {{ $stock->description }}</td>
                            <td> {{ $stock->category->category_name }}</td>
                            <td> {{ $stock->qty }}</td>
                            <td> @if($stock->location == 'hq') Head Quarter @elseif($stock->location == 'gs1') GS Gazipur @else GS Bethbunia @endif</td>

                            <td class="row-options text-muted small">
                                <a href="{{route('admin.stocks.edit', $stock->id) }}" class="ajax-modal-btn"><i data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-edit"></i></a>&nbsp;
                                <form method="POST" action="{{route('admin.stocks.destroy', $stock->id) }}" accept-charset="UTF-8" class="data-form">
                                    @csrf
                                    @method('delete')
                                    <a href="{{route('admin.stocks.get-assign-stock-form', $stock->id) }}" class="confirm ajax-silent" title="Assign Stock"><i class="fa fa-plus"></i></a>
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

