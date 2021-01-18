@extends('layouts.backend')

@section('title')
    Inventory | QR Code List
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Inventory QR Code Lists</h3>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <table class="table table-hover table-2nd-no-sort">
                    <thead>
                    <tr>
                        <th align="center">QR Code</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($inventories as $key => $inventory)
                        <tr>
                            <td class="float-right"> {!! QrCode::size(100)->generate(url('inventories',$inventory->id)); !!}<br>
                                {{ $inventory->asset_code  }}
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
    </section>
@endsection



