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
                    @can('see inventory all summary')
                    <a class="button add" href="{{ route('admin.inventories.summary').qString() }}">All Summary</a>
                    @endcan
                    @can('see inventory summary')
                    <a class="button add" href="{{ route('admin.inventories.location.summary').qString() }}">Summary</a>
                    @endcan
                    @can('see inventory QR code list')
                    <a class="button add" href="{{ route('admin.inventories.qr-code-list').qString() }}">QR Code List</a>
                    @endcan
                    @can('add inventory')
                    <a href="{{ route('admin.inventories.create').qString() }}" class="button add"> Add Inventory</a>
                    @endcan

                </div>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="GET" action="{{ route('admin.inventories.index') }}"
                              class="form-inline float-right">
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
                                                <option
                                                    value="{{ $nc->id }}" {{ ($nc->id==Request::get('category_id'))?'selected':''}}>
                                                    {{ $nc->category_name }} [ {{ $nc->category_code }} ]</option>
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
                                    @php $inventoryPage = $inventories->count();
                                    $perPage = Request::get('per_page') ?? 50;
                                    @endphp
                                    <option value="">Select page</option>
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
                                    <option value="{{ $inventoryPage }}" {{ ($inventoryPage == $perPage) ? 'selected' : '' }}>Total Data
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Search</button>&nbsp
                            <a href="{{ route('admin.inventories.index') }}" class="btn btn-warning mb-2"><i
                                    class="fa fa-times"></i></a>
                        </form>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="service-box-wrapper" id="service-box">
                            <div class="panel-body table-responsive no-padding">
                                <table class="table" id="file_export">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Asset Code</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Assign To</th>
                                        <th>Assign Date</th>
                                        <th>Voucher No</th>
                                        <th>Qty</th>
                                        <th>Cost</th>
                                        <th>Location</th>
                                        <th>QR Code</th>
                                        <th>Purchase Date</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($inventories as $inventory)
                                        <tr>
                                            <td>  {{ $serial++ }}</td>
                                            <td> {{ $inventory->asset_code  }}</td>
                                            <td> {{ $inventory->description }}</td>
                                            <td> {{ $inventory->category->category_name }} [ {{ $inventory->category->category_code }} ]</td>
                                            <td>
                                                @if($inventory->assign_to == 'user') <strong>Person:</strong>
                                                <br> <a href="{{ route('admin.users.show',$inventory->user_id ).qString() }}">{{$inventory->user->name }} [ {{$inventory->user->user_id }} ] </a>
                                                @else
                                                    <strong>Department:</strong>
                                                    <br> <a href="{{ route('admin.departments.show',$inventory->dept_id ).qString() }}">{{ $inventory->department->department}} [ {{ $inventory->department->department_id }} ] </a>
                                                @endif
                                            </td>
                                            <td>{{ $inventory->assign_date ?? '-' }}</td>
                                            <td> {{ $inventory->voucher_no }}</td>
                                            <td> {{ $inventory->qty }}</td>
                                            <td> {{ $inventory->cost }}</td>
                                            <td> @if($inventory->location == 'hq') Head
                                                Quarter @elseif($inventory->location == 'gs1') GS Gazipur @else GS
                                                Bethbunia @endif</td>
                                            <td>  {!! QrCode::size(50)->generate(url('inventories',$inventory->id)); !!}</td>
                                            <td>{{ $inventory->purchase_date ?? '-' }}</td>
                                            <td>
                                 <span class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"><i class="fa fa-cogs"></i> <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu" style="left: -115px;">
                                                 <form method="POST" action="{{ route('admin.inventories.destroy', $inventory->id).qString() }}" accept-charset="UTF-8" class="data-form">
                                                     @csrf
                                                     @method('delete')

                                                     @can('see inventory details')
                                                     <li><a href="{{ route('admin.inventories.show', $inventory->id).qString() }}" class="ajax-modal-btn"><i data-toggle="tooltip" data-placement="top" title="Details" class="fa fa-expand"></i></a></li>
                                                     @endcan

                                                     @can('edit inventory')
                                                     <li><a href="{{route('admin.inventories.edit', $inventory->id).qString() }}" class="ajax-modal-btn"><i data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-edit"></i></a>&nbsp;</li>
                                                     @endcan

                                                     @can('delete inventory')
                                                    <li><a href="javascript:void(0)" @click="destroy"><i class="fa fa-trash-o"></i> </a></li>
                                                     @endcan
                                                  </form>
                                            </ul>
                                        </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- /.box-body -->
            <div class="row">
                <div class="col-sm-5">
                </div>
                <div class="col-sm-7">
                    <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                        {{ $inventories->appends(Request::except('page'))->links() }}
                    </div>
                </div>
            </div>
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
                @include('admin.inventory.form_import')
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

        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush

