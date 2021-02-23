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
                    <a href="javascript:void(0)" class="btn btn-success pull-left" onclick="printDiv('printableArea')">Print</a>&nbsp;&nbsp;
                    <a class="button add" href="{{ route('admin.inventories.summary') }}">Summary</a>
                    <a class="button add" href="{{ route('admin.inventories.qr-code-list') }}">QR Code List</a>
                    <a href="{{ route('admin.inventories.create') }}" class="button add"> Add Inventory</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="GET" action="{{ route('admin.inventories.index') }}" class="form-inline float-right">
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
                            <div class="form-group mx-sm-3 mb-2">
                                <label class="sr-only">&nbsp;</label>
                                <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Input your search text...">
                            </div>

                            <button type="submit" class="btn btn-info mb-2"><i class="fa fa-search"></i> Search</button>
                            <a href="{{ route('admin.inventories.index') }}" class="btn btn-warning mb-2"><i class="fa fa-times"></i></a>
                        </form>
                    </div>
                </div>
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
                        <th>Purchase Date</th>
                        <th width="5%"> </th>
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
                            <td>{{ $inventory->purchase_date ?? '-' }}</td>
                            <td>
                                 <span class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                                <i class="fa fa-cogs"></i> <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu" style="left: -115px;">
                                                 <form method="POST" action="{{ route('admin.inventories.destroy', $inventory->id) }}" accept-charset="UTF-8" class="data-form">
                                                     @csrf
                                                     @method('delete')
                                                     <li><a href="{{ route('admin.inventories.show', $inventory->id) }}" class="ajax-modal-btn"><i data-toggle="tooltip" data-placement="top" title="Details" class="fa fa-expand"></i></a></li>
                                                     <li><a href="{{route('admin.inventories.edit', $inventory->id) }}" class="ajax-modal-btn"><i data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-edit"></i></a>&nbsp;</li>
                                                    <li><a href="javascript:void(0)" @click="destroy"><i class="fa fa-trash-o"></i> </a></li>
                                                  </form>
                                            </ul>
                                        </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div> <!-- /.box-body -->
            @if($inventories->total())
                <div class="row">
                    <div class="col-sm-5">
                    </div>
                    <div class="col-sm-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                            {{ $inventories->appends(Request::except('page'))->links() }}
                        </div>
                    </div>
                </div>
            @endif
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

        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush

