@extends('layouts.backend')

@section('title')
    Stocks
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Bill Register</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('admin.bills.create') }}" class="button add"> Add Bill</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <table class="table table-hover table-2nd-no-sort">
                    <thead>
                    <tr>
                        <th>Bill No</th>
                        <th>Bill Date</th>
                        <th>Shop Info</th>
                        <th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Item Name</th>
                        <th>Subject</th>
                        <th>Qty</th>
                        <th>Category</th>
                        <th>Cost</th>
                        <th>Location</th>
                        <th>Assign To</th>
                        <th>QR Code</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bills as $bill)
                        <tr>
                            <td> {{ $bill->item_name }}</td>
                            <td> {{ $bill->item_serial }}</td>
                            <td> {{ $bill->category->category_name }}</td>
                            <td> {{ $bill->quantity }}</td>
                            <td> {{ $bill->purchase_date }}</td>
                            <td> {{ $bill->location }}</td>
                            <td> {{ $bill->assign_user }}</td>
                            <td> {{ $bill->qr_code }}</td>
                            <td>
                                {{ $bill->created_at->format('M d, Y') }}
                            </td>
                            <td class="row-options text-muted small">
                                <a href="{{route('admin.bills.edit', $bill->id) }}" class="ajax-modal-btn"><i data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-edit"></i></a>&nbsp;
                                <form method="POST" action="{{ route('admin.bills.destroy', $bill->id) }}" accept-charset="UTF-8" class="data-form">
                                    @csrf
                                    @method('delete')
                                    <a href="javascript:void(0)" @click="destroy" class="confirm ajax-silent" title="Trash" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash-o"></i></a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($bills->total())
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="dataTables_info" id="sortable_info" role="status" aria-live="polite">
                                showing {{ $bills->firstItem() }} to {{ $bills->lastItem() }} of {{ $bills->total() }} entries
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                                {{ $bills->links() }}
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

