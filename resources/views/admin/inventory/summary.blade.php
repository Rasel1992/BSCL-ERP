@extends('layouts.backend')

@section('title')
    Inventories
@endsection

@section('content')
    <section class="content">
        <div class="panel" id="printableArea">
            <div class="box-header with-border">
                <h3 class="box-title">Inventories Summary</h3>
                <div class="box-tools pull-right">
                    <a href="javascript:void(0)" class="btn btn-success pull-left" onclick="printDiv('printableArea')">Print</a>&nbsp;&nbsp;
                    <a href="{{ route('admin.inventories.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> List of Inventory</a>
                </div>
            </div> <!-- /.box-header -->
           <div class="panel-body">
               <div class="col-md-4 col-lg-4">
                   <div class="panel">
                       <div class="box-header">
                           <h3 class="box-title">Head Quarter </h3>
                       </div> <!-- /.box-header -->
                       <div class="panel-body">
                           <table class="table table-hover table-2nd-no-sort">
                               <thead>
                               <tr>
                                   <th>Category Name</th>
                                   <th>QTY</th>
                               </tr>
                               </thead>
                               <tbody>
                               @foreach($categories_head as $category)
                                   <tr>
                                       <td><a href="{{ route('admin.inventories.category', $category->id) }}">{{ $category->category_name }}</a></td>
                                       <td>{{ $category->inventories->sum('qty') }}</td>
                                   </tr>
                               @endforeach
                               </tbody>
                           </table>
                       </div> <!-- /.box-body -->
                   </div> <!-- /.box -->
               </div>
               <div class="col-md-4 col-lg-4">
                   <div class="panel">
                       <div class="box-header">
                           <h3 class="box-title">GS Gazipur </h3>
                       </div> <!-- /.box-header -->
                       <div class="panel-body">
                           <table class="table table-hover table-2nd-no-sort">
                               <thead>
                               <tr>
                                   <th>Category Name</th>
                                   <th>QTY</th>
                               </tr>
                               </thead>
                               <tbody>
                               @foreach($categories_gs1 as $category)
                                   <tr>
                                       <td><a href="{{ route('admin.inventories.category', $category->id) }}">{{ $category->category_name }}</a></td>
                                       <td>{{ $category->inventories->sum('qty') }}</td>
                                   </tr>
                               @endforeach
                               </tbody>
                           </table>
                       </div> <!-- /.box-body -->
                   </div> <!-- /.box -->
               </div>
               <div class="col-md-4 col-lg-4">
                   <div class="panel">
                       <div class="box-header">
                           <h3 class="box-title">GS Betbhunia </h3>
                       </div> <!-- /.box-header -->
                       <div class="panel-body">
                           <table class="table table-hover table-2nd-no-sort">
                               <thead>
                               <tr>
                                   <th>Category Name</th>
                                   <th>QTY</th>
                               </tr>
                               </thead>
                               <tbody>
                               @foreach($categories_gs2 as $category)
                                   <tr>
                                       <td><a href="{{ route('admin.inventories.category', $category->id) }}">{{ $category->category_name }}</a></td>
                                       <td>{{ $category->inventories->sum('qty') }}</td>
                                   </tr>
                               @endforeach
                               </tbody>
                           </table>
                       </div> <!-- /.box-body -->
                   </div> <!-- /.box -->
               </div>
           </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            var l = document.getElementsByTagName('a');
            for (var i =0; i<l.length; i++) {
                l[i].href = '#';
            }
            window.print();

            document.body.innerHTML = originalContents;

        }
    </script>
@endpush
