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
                <div class="row" id="printableArea">
                    <div class="col-md-12">
                        @foreach($inventories as $key => $inventory)
                            @php
                                $allQrCode = $inventory->count();
                            @endphp
                                <div class="col-md-{{ ++$key == $allQrCode && $key & 1 ? '12':'6' }}">
                                    {!! QrCode::size(100)->generate(url('inventories',$inventory->id)); !!}<br>
                                    {{ $inventory->asset_code  }}
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


