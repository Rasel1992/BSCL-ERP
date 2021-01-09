@extends('layouts.backend')

@section('title')
    Inventories
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Inventories</h3>
                <div class="box-tools pull-right">
                    <a class="button add" href="{{ route('admin.inventories.summary') }}">Summary</a>
                    <a class="button add" href="{{ route('admin.inventories.qr-code-list') }}">QR Code List</a>
                    <a href="{{ route('admin.inventories.create') }}" class="button add"> Add Inventory</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <table class="table table-hover table-2nd-no-sort" id="file_export">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Asset Code</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Allocate To</th>
                        <th>Voucher No</th>
                        <th>Qty</th>
                        <th>Cost</th>
                        <th>Location</th>
                        <th>QR Code</th>
                        <th>Purchase Date</th>
                        <th> </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($inventories as $key => $inventory)
                        <tr>
                            <td> {{$key + $inventories->firstItem()}}</td>
                            <td> {{ $inventory->asset_code  }}</td>
                            <td> {{ $inventory->description }}</td>
                            <td> {{ $inventory->category->category_name }}</td>
                            <td>
                                @if($inventory->assign_to == 'user') <strong>Person:</strong><br> {{$inventory->user->name }}
                                @else
                                    <strong>Department:</strong><br> {{ $inventory->department->department}}
                                @endif
                            </td>

                            <td> {{ $inventory->voucher_no }}</td>
                            <td> {{ $inventory->qty }}</td>
                            <td> {{ $inventory->cost }}</td>
                            <td> @if($inventory->location == 'hq') Head Quarter @elseif($inventory->location == 'gs1') GS Gazipur @else GS Bethbunia @endif</td>
                            <td>  {!! QrCode::size(50)->generate(url('inventories',$inventory->id)); !!}</td>
                            <td>{{ $inventory->purchase_date}}</td>
                            <td class="row-options text-muted small">
                                <a href="{{ route('admin.inventories.show', $inventory->id) }}" class="ajax-modal-btn"><i data-toggle="tooltip" data-placement="top" title="Details" class="fa fa-expand"></i></a>&nbsp;
                                <a href="{{route('admin.inventories.edit', $inventory->id) }}" class="ajax-modal-btn"><i data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-edit"></i></a>&nbsp;
                                <form method="POST" action="{{ route('admin.inventories.destroy', $inventory->id) }}" accept-charset="UTF-8" class="data-form">
                                    @csrf
                                    @method('delete')
                                    <a href="javascript:void(0)" @click="destroy" class="confirm ajax-silent" title="Trash" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash-o"></i></a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($inventories->total())
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="dataTables_info" id="sortable_info" role="status" aria-live="polite">
                                showing {{ $inventories->firstItem() }} to {{ $inventories->lastItem() }} of {{ $inventories->total() }} entries
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                                {{ $inventories->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div> <!-- /.box-body -->
        </div> <!-- /.box -->
        @include('admin.inventory.form_import')
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

