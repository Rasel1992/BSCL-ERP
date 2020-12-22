@extends('layouts.backend')

@section('title')
    {{ __('category.category_show') }}
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="panel-body">
                @if (isset($category))
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <caption><h3>Category Details <a href="{{ route('admin.categories.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> Back </a></h3></caption>
                            <tbody>
                            <tr>
                                <th style="width:120px;">Category Name</th>
                                <th style="width:10px;">:</th>
                                <td>
                                    {{ $category->parent_name }}
                                   </td>
                            </tr>
                            <tr>
                                <th style="width:120px;">Sub Category Name</th>
                                <th style="width:10px;">:</th>
                                <td>{{ ($category->parent_mother!='')?$category->parent_mother.' > ':'' }}
                                    {{ ($category->parent_name!='')?$category->parent_name.' > ':'' }}
                                    {{ $category->category_name }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
