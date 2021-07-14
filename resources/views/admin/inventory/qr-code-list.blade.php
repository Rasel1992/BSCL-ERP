@extends('layouts.backend')

@section('title')
    Inventory | QR Code List
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Inventory QR Code Lists
                    </h3>
                <div class="box-tools pull-right">
                    <a href="javascript:void(0)" class="btn btn-success pull-left" onclick="printDiv('printableArea')">Print</a>&nbsp;&nbsp;
                    <a href="{{ route('admin.inventories.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> List of Inventory</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('admin.inventories.qr-code-list') }}"
                              class="form-inline float-right">
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
                            <a href="{{ route('admin.inventories.qr-code-list') }}" class="btn btn-warning mb-2"><i
                                    class="fa fa-times"></i></a>
                        </form>
                    </div>
                </div>
                <br>
                <div class="row" id="printableArea">
                    <div class="col-md-12">
                        @foreach($inventories as $key => $inventory)
                            @php
                                $allQrCode = $inventory->count();
                            @endphp
                                <div align="center" style="margin-bottom: 50px;" class="col-md-{{ ++$key == $allQrCode && $key & 1 ? '12':'6' }}">
                                    {!! QrCode::size(150)->generate(url('inventories',$inventory->id)); !!}<br>
                                    <div align="center"> {{ $inventory->asset_code  }}</div>
                                </div>
                        @endforeach

                    </div>
                </div>

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
            </div> <!-- /.box-body -->
        </div> <!-- /.box -->
    </section>
@endsection
@push('scripts')
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush


