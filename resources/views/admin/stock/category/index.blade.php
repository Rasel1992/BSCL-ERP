@extends('layouts.backend')

@section('title')
    Category
@endsection
@section('styles')
    <style>
        .service-block__category-title {
            font-size: 14px;
            font-weight: 700;
            position: relative;
            color: #000;
        }

        .parent_selector {
            /*padding-top: 5px;*/
            overflow: hidden;
        }

        .service-block__checker {
            width: 60px;
            min-width: 60px;
            text-align: center;
            white-space: nowrap;
            position: relative;
        }

        .service-block__checker .service-block__drag {
            width: 12px;
            height: 17px;
            margin-right: 6px;
            /*margin-top: 3px;*/
        }

        /*.cat_check {
            margin-top: 4px;
        }*/

        td.service-block__id span {
            margin-top: 2px;
            display: block;
        }

        .service-block__drag svg {
            width: 14px;
            height: 14px;
            cursor: move;
            cursor: grab;
            cursor: -webkit-grab;
        }

        .check-single-item {
            margin-top: 0 !important;
        }

        .service-block__id {
            width: 50px;
            min-width: 50px;
        }

        .service-block__service {
            /*min-width: 340px;*/
            line-height: 1.3;
            padding-right: 4px;
            word-break: break-all;
        }

        .service-block__type {
            width: 220px;
            min-width: 220px;
            white-space: nowrap;
        }

        .service-block__provider {
            width: 170px;
            min-width: 170px;
            max-width: 170px;
            word-wrap: break-word;
            position: relative;
            text-align: right;
        }

        .service-block__rate {
            width: 75px;
            min-width: 60px;
        }

        .service-block__minorder {
            width: 85px;
            min-width: 75px;
            white-space: nowrap;
            position: relative;
        }

        .service-block__visibility {
            width: 80px;
            min-width: 80px;
        }

        .service-block__action {
            width: 90px;
            min-width: 90px;
            padding: 7px 10px !important;
        }
        .service-block__middle {
            min-width: 90px;
        }

        .service-block__middle_1 {
            width: 300px;
            min-width: 300px;
            padding: 7px 10px !important;
        }

        .service-block__collapse-button-counter {
            display: inline-block;
            color: #337ab7;
            border-bottom: 1px dashed #337ab7;
            font-size: 12px;
            padding-left: 3px;
            cursor: pointer;
        }

        .service-box-wrapper {
            /*padding: 5px 20px 5px 10px;*/
            overflow: auto;
            height: 100vh;
        }

        .service-block__header {
            width: 100%;
            border: 1px solid #ddd;
            background: #f8f8f8;
            border-radius: 3px;
            position: relative;
        }

        .service-block__hide-all {
            -webkit-transform: rotate(134deg);
            -ms-transform: rotate(134deg);
            transform: rotate(134deg);
            cursor: pointer;
        }

        .fa-compress-alt:before {
            content: "\f066";
        }

        .service-block__header th {
            height: 45px;
            padding: 0 3px;
        }

        .service-box-wrapper .parent-pad-0 {
            padding: 0;
        }

        .service-box-wrapper .table > thead > tr > th,
        .service-box-wrapper .table > tbody > tr > th,
        .service-box-wrapper .table > tfoot > tr > th,
        .service-box-wrapper .table > thead > tr > td,
        .service-box-wrapper .table > tbody > tr > td,
        .service-box-wrapper .table > tfoot > tr > td {
            vertical-align: top;
        }
    </style>
@endsection
@section('content')
    <section class="content">
        <div class="panel" id="printableArea">
            <div class="box-header with-border">
                <h3 class="box-title">Category</h3>

                @can('add stock category')
                    <div class="box-tools pull-right">
                        <a href="{{ route('admin.stock-category.create') }}" class="button add">Add Category</a>
                    </div>
                @endcan

            </div> <!-- /.box-header -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('admin.stock-category.index') }}" class="form-inline float-right">
                            <div class="form-group mx-sm-3 mb-2">
                                <label class="sr-only">&nbsp;</label>
                                <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Input your search text...">
                            </div>
                            <button type="submit" class="btn btn-info mb-2"><i class="fa fa-search"></i> Search</button>
                            <a href="{{ route('admin.stock-category.index') }}" class="btn btn-warning mb-2"><i class="fa fa-times"></i></a>
                        </form>
                    </div>
                </div>
                <br>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="service-box-wrapper" id="service-box">
                            <div class="box-body table-responsive">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6">
                                            <span id="all_show_hide" @click="allCatChildShowHide" class="btn btn-info pull-right">Hide All</span>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-xs-12">
                                    <div class="panel">
                                        <div class="box-header">
                                            <h3 class="box-title">Stock Category</h3>
                                        </div> <!-- /.box-header -->
                                        <div class="panel-body">
                                            <table class="table" id="child">
                                                <thead>
                                                <tr class="parent_cat">
                                                    <td class="service-block__checker">
                                                    <td class="service-block__service">Category Name</td>
                                                </tr>
                                                </thead>
                                                <tbody id="grand-child">

                                                @foreach($categoryData as $key => $category)
                                                    <tr class="parent_cat parent-sort-row"
                                                        data-id="{{ $category->id }}">
                                                        <td class="service-block__checker">
                                                            <div class="parent_selector">
                                                                <div
                                                                    class="service-block__drag pull-left parent-drag-handle">
                                                                    {{ $serial++ }}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td colspan="3">
                                                            <table class="table">
                                                                <thead>
                                                                <tr>
                                                                    <td colspan="2" class="service-block__service">
                                                                        <strong class="service-block__category-title">{{ $category->category_name }}</strong>
                                                                        @if($category->nested->count())
                                                                            <small><span class="service-block__collapse-button-counter" @click="catShowHide({{ $category->id }})"><span id="show_hide_controll_{{ $category->id }}">Hide</span> Category ({{ $category->nested->count() }})</span></small>
                                                                        @endif
                                                                    </td>
                                                                    <td class="service-block__action">
                                                                        <div class="input-group-btn">
                                                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Actions
                                                                                <span class="fa fa-caret-down"></span>
                                                                            </button>

                                                                            <ul class="dropdown-menu dropleft">
                                                                                @can('see stock category details')
                                                                                <li>
                                                                                    <a href="{{ route('admin.stock-category.show', $category->id).qString() }}" class="ajax-modal-btn">Show</a>
                                                                                </li>
                                                                                @endcan

                                                                                @can('edit stock category')
                                                                                <li>
                                                                                    <a href="{{route('admin.stock-category.edit', $category->id).qString() }}" class="ajax-modal-btn">Edit</a>
                                                                                </li>
                                                                                @endcan
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($category->nested()->orderBy('id', 'ASC')->get() as $key1 => $childCat)
                                                                    <tr class="child child_cat_{{ $category->id }} child-sort-row"
                                                                        data-id="{{ $childCat->id }}">
                                                                        <td class="service-block__checker">
                                                                            <div class="service-block__drag pull-left child-drag-handle">
                                                                                {{ $childCat->category_code }}
                                                                            </div>
                                                                        </td>
                                                                        <td colspan="3"
                                                                            class="service-block__type parent-pad-0">
                                                                            <!-- Start child sub -->
                                                                            <table class="table">
                                                                                <thead>
                                                                                <tr>
                                                                                    <td class="service-block__service">
                                                                                        <strong class="service-block__category-title">{{ $childCat->category_name }}</strong>
                                                                                        @if($childCat->nested->count())
                                                                                            <small><span class="service-block__collapse-button-counter" @click="catShowHide({{ $childCat->id }})"><span id="show_hide_controll_{{ $childCat->id }}">Hide</span> Category ({{ $childCat->nested->count() }})</span></small>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="service-block__action">
                                                                                        <div class="input-group-btn">
                                                                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Actions
                                                                                                <span class="fa fa-caret-down"></span>
                                                                                            </button>

                                                                                            <ul class="dropdown-menu dropleft">
                                                                                                @can('see stock category details')
                                                                                                    <li>
                                                                                                        <a href="{{ route('admin.stock-category.show', $childCat->id).qString() }}" class="ajax-modal-btn">Show</a>
                                                                                                    </li>
                                                                                                @endcan

                                                                                                @can('edit stock category')
                                                                                                    <li>
                                                                                                        <a href="{{route('admin.stock-category.edit', $childCat->id).qString() }}" class="ajax-modal-btn">Edit</a>
                                                                                                    </li>
                                                                                                @endcan
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                </thead>
                                                                            </table>
                                                                            <!-- End Child sub -->
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div> <!-- /.box-body -->
                                    </div> <!-- /.box -->
                                </div>
                                @if($categoryData->total())
                                    <div class="row">
                                        <div class="col-sm-5">

                                        </div>
                                        <div class="col-sm-7">
                                            <div class="dataTables_paginate paging_simple_numbers"
                                                 id="sortable_paginate">
                                                {{ $categoryData->appends(Request::except('page'))->links() }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        new Vue({
            el: '#app',
            methods: {
                catShowHide: function (catId) {
                    $('.child_cat_' + catId).toggle();
                    const getText = $('#show_hide_controll_' + catId).html();

                    if (getText === 'Hide') {
                        $('#show_hide_controll_' + catId).html('Show');
                    } else {
                        $('#show_hide_controll_' + catId).html('Hide');
                    }
                },
                allCatChildShowHide: function () {
                    const getText = $('#all_show_hide').html();

                    if (getText === 'Hide All') {
                        $('#all_show_hide').html('Show All');
                        $('.child').hide();
                    } else {
                        $('#all_show_hide').html('Hide All');
                        $('.child').show();
                    }
                },
            }
        });
    </script>
@endpush
