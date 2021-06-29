@extends('layouts.backend')

@section('title')
    Category | Details
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="panel-body">
                @if (isset($cat))
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <caption><h3>Category Details <a href="{{ route('admin.inventory-category.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> Back </a></h3></caption>
                            <tbody>
                            <tr>
                                <th style="width:120px;">Category Name</th>
                                <th style="width:10px;">:</th>
                                <td>{{ ($cat->parent_mother!='')?$cat->parent_mother.' > ':'' }}
                                    {{ ($cat->parent_name!='')?$cat->parent_name.' > ':'' }}
                                    {{ $cat->category_name }}</td>
                            </tr>
                            <tr>
                                <th style="width:120px;">Type</th>
                                <th style="width:10px;">:</th>
                                <td>
                                    {{ $cat->type }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
