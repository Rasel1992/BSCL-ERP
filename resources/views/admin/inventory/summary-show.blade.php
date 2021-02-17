@extends('layouts.backend')

@section('title')
    Inventories
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Inventories ({{$data['category']->category_name }} )</h3>
                <div class="box-tools pull-right">
                    <a class="button add" href="{{ route('admin.inventories.summary') }}">Summary</a>
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
                        <th>Assign To</th>
                        <th>Voucher No</th>
                        <th>Qty</th>
                        <th>Cost</th>
                        <th>Location</th>
                        <th>QR Code</th>
                        <th width="10%">Purchase Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['inventories'] as $key => $inventory)
                        <tr>
                            <td> {{$key + $data['inventories']->firstItem()}}</td>
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
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($data['inventories']->total())
                    <div class="row">
                        <div class="col-sm-5">
                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                                {{ $data['inventories']->appends(Request::except('page'))->links() }}
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

