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
                <a href="{{ route('admin.inventories.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> List of Inventory</a>
            </div> <!-- /.box-header -->
            <div class="panel-body">


            </div> <!-- /.box-body -->
        </div> <!-- /.box -->
    </section>
@endsection



