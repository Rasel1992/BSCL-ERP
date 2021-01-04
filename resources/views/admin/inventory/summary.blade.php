@extends('layouts.backend')

@section('title')
    Inventories
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Inventories Summary</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('admin.inventories.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> Back to List</a>
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
                               <tbody>
                               @foreach($data['categories_head'] as $category)
                                   <tr>
                                       <th>Category Name</th>
                                       <th>:</th>
                                       <td><a href="#">{{ $category->category_name }}({{ count($category->inventories) }})</a></td>
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
                               <tbody>
                               @foreach($data['categories_gs1'] as $category)
                                   <tr>
                                       <th>Category Name</th>
                                       <th>:</th>
                                       <td><a href="#">{{ $category->category_name }}({{ count($category->inventories) }})</a></td>
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
                               <tbody>
                               @foreach($data['categories_gs2'] as $category)
                                   <tr>
                                       <th>Category Name</th>
                                       <th>:</th>
                                       <td><a href="#">{{ $category->category_name }}({{ count($category->inventories) }})</a></td>
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

