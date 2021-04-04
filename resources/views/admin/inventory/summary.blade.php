@extends('layouts.backend')

@section('title')
    Inventories | Summary
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
            width: 40px;
            min-width: 40px;
            text-align: center;
            white-space: nowrap;
            position: relative;
        }


        td.service-block__id span {
            margin-top: 2px;
            display: block;
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
                <h3 class="box-title">Inventories Summary</h3>
                <div class="box-tools pull-right">
                    <a href="javascript:void(0)" class="btn btn-success pull-left" onclick="printDiv('printableArea')">Print</a>&nbsp;&nbsp;
                    <a href="{{ route('admin.inventories.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> List of Inventory</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="service-box-wrapper" id="service-box">
                            <div class="box-body table-responsive no-padding">
                                <span id="all_show_hide" @click="allCatChildShowHide" class="btn btn-info pull-right">Hide All</span>
                                <br>
                                <br>
                                <div class="col-xs-4">
                                    <div class="panel">
                                        <div class="box-header">
                                            <h3 class="box-title">Head Quarter </h3>
                                        </div> <!-- /.box-header -->
                                        <div class="panel-body">
                                            <table class="table" id="child">
                                                <thead>
                                                <tr class="parent_cat">
                                                    <td class="service-block__checker">
                                                    <td class="service-block__service">Category Name</td>
                                                    <td class="service-block__service">QTY</td>
                                                </tr>
                                                </thead>
                                                <tbody id="grand-child">
                                                @foreach($categories as $key => $category)
                                                    <tr class="parent_cat parent-sort-row"
                                                        data-id="{{ $category->id }}">
                                                        <td class="service-block__checker">
                                                            <div class="parent_selector">
                                                                <div
                                                                    class="service-block__drag pull-left parent-drag-handle">
                                                                    {{ $key + $categories->firstItem()}}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td colspan="3">
                                                            <table class="table">
                                                                <thead>
                                                                <tr>
                                                                    <td colspan="2" class="service-block__service">
                                                                        <strong class="service-block__category-title"><a href="{{ route('admin.inventories.category', $category->id) }}">{{ $category->category_name }}</a></strong>
                                                                        @if($category->nested->count())
                                                                            <small><span class="service-block__collapse-button-counter" @click="catShowHide({{ $category->id }})"><span id="show_hide_controll_{{ $category->id }}">Hide</span> Category ({{ $category->nested->count() }})</span></small>
                                                                        @endif
                                                                    </td>
                                                                    @php
                                                                        $sum_tot_Price = 0;
                                                                        foreach($category->nested()->orderBy('id', 'ASC')->get() as $key1 => $childCat)
                                                                            $sum_tot_Price += $childCat->inventories->where('location', 'hq')->sum('qty')
                                                                    @endphp
                                                                    <td class="service-block__action"> {{ $sum_tot_Price}}</td>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($category->nested()->orderBy('id', 'ASC')->get() as $key1 => $childCat)
                                                                    <tr class="child child_cat_{{ $category->id }} child-sort-row"
                                                                        data-id="{{ $childCat->id }}">
                                                                        <td class="service-block__checker">
                                                                            <div class="service-block__drag pull-left child-drag-handle">
                                                                                {{ ++ $key1 }}
                                                                            </div>
                                                                        </td>
                                                                        <td colspan="3"
                                                                            class="service-block__type parent-pad-0">
                                                                            <!-- Start child sub -->
                                                                            <table class="table">
                                                                                <thead>
                                                                                <tr>
                                                                                    <td class="service-block__service">
                                                                                        <strong
                                                                                            class="service-block__category-title"><a href="{{ route('admin.inventories.category', $childCat->id) }}?location=hq">{{ $childCat->category_name }}</a></strong>
                                                                                        @if($childCat->nested->count())
                                                                                            <small><span
                                                                                                    class="service-block__collapse-button-counter"
                                                                                                    @click="catShowHide({{ $childCat->id }})"><span
                                                                                                        id="show_hide_controll_{{ $childCat->id }}">Hide</span> Category ({{ $childCat->nested->count() }})</span></small>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="service-block__action">{{ $childCat->inventories->where('location', 'hq')->sum('qty') }}</td>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                @foreach($childCat->nested()->orderBy('id', 'ASC')->get() as $key2 => $grandChildCat)
                                                                                    <tr class="child child_cat_{{ $childCat->id }} grand-child-sort-row"
                                                                                        data-id="{{ $grandChildCat->id }}">
                                                                                        <td colspan="1" class="service-block__checker">
                                                                                            <div class="service-block__drag pull-left grand-child-drag-handle">
                                                                                                {{ ++ $key2 }}
                                                                                            </div>
                                                                                        </td>
                                                                                        <td><strong class="service-block__category-title"><a href="{{ route('admin.inventories.category', $grandChildCat->id) }}?location=hq">{{ $grandChildCat->category_name }}</a></strong>
                                                                                        </td>
                                                                                        <td class="service-block__action">{{ $grandChildCat->inventories->where('location', 'hq')->sum('qty') }}</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                                </tbody>
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
                                <div class="col-xs-4">
                                    <div class="panel">
                                        <div class="box-header">
                                            <h3 class="box-title">GS Gazipur </h3>
                                        </div> <!-- /.box-header -->
                                        <div class="panel-body">
                                            <table class="table" id="child">
                                                <thead>
                                                <tr class="parent_cat">
                                                    <td class="service-block__checker">
                                                    <td class="service-block__service">Category Name</td>
                                                    <td class="service-block__service">QTY</td>
                                                </tr>
                                                </thead>
                                                <tbody id="grand-child">
                                                @foreach($categories as $key => $category)
                                                    <tr class="parent_cat parent-sort-row"
                                                        data-id="{{ $category->id }}">
                                                        <td class="service-block__checker">
                                                            <div class="parent_selector">
                                                                <div class="service-block__drag pull-left parent-drag-handle">
                                                                    {{ $key + $categories->firstItem()}}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td colspan="3">
                                                            <table class="table">
                                                                <thead>
                                                                <tr>
                                                                    <td colspan="2" class="service-block__service">
                                                                        <strong class="service-block__category-title"><a href="{{ route('admin.inventories.category', $category->id) }}">{{ $category->category_name }}</a></strong>
                                                                        @if($category->nested->count())
                                                                            <small><span class="service-block__collapse-button-counter" @click="catShowHideGs1({{ $category->id }})"><span id="show_hide_controll1_{{ $category->id }}">Hide</span> Category ({{ $category->nested->count() }})</span></small>
                                                                        @endif
                                                                    </td>
                                                                    @php
                                                                        $sum_tot_Price = 0;
                                                                        foreach($category->nested()->orderBy('id', 'ASC')->get() as $childCat)
                                                                            $sum_tot_Price += $childCat->inventories->where('location', 'gs1')->sum('qty')
                                                                    @endphp
                                                                    <td class="service-block__action"> {{ $sum_tot_Price}}</td>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($category->nested()->orderBy('id', 'ASC')->get() as $key1 => $childCat)
                                                                    <tr class="child child_cat1_{{ $category->id }} child-sort-row"
                                                                        data-id="{{ $childCat->id }}">
                                                                        <td class="service-block__checker">
                                                                            <div class="service-block__drag pull-left child-drag-handle">
                                                                                {{ ++ $key1 }}
                                                                            </div>
                                                                        </td>
                                                                        <td colspan="3"
                                                                            class="service-block__type parent-pad-0">
                                                                            <!-- Start child sub -->
                                                                            <table class="table">
                                                                                <thead>
                                                                                <tr>
                                                                                    <td class="service-block__service">
                                                                                        <strong class="service-block__category-title"><a href="{{ route('admin.inventories.category', $childCat->id) }}?location=gs1">{{ $childCat->category_name }}</a></strong>
                                                                                        @if($childCat->nested->count())
                                                                                            <small><span class="service-block__collapse-button-counter" @click="catShowHideGs1({{ $childCat->id }})"><span id="show_hide_controll1_{{ $childCat->id }}">Hide</span> Category ({{ $childCat->nested->count() }})</span></small>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="service-block__action">{{ $childCat->inventories->where('location', 'gs1')->sum('qty') }}</td>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                @foreach($childCat->nested()->orderBy('id', 'ASC')->get() as $key2 => $grandChildCat)
                                                                                    <tr class="child child_cat1_{{ $childCat->id }} grand-child-sort-row"
                                                                                        data-id="{{ $grandChildCat->id }}">
                                                                                        <td colspan="1" class="service-block__checker">
                                                                                            <div class="service-block__drag pull-left grand-child-drag-handle">
                                                                                                {{ ++ $key2 }}
                                                                                            </div>
                                                                                        </td>
                                                                                        <td><strong class="service-block__category-title"><a href="{{ route('admin.inventories.category', $grandChildCat->id) }}?location=gs1">{{ $grandChildCat->category_name }}</a></strong>
                                                                                        </td>
                                                                                        <td class="service-block__action">{{ $grandChildCat->inventories->where('location', 'gs1')->sum('qty') }}</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                                </tbody>
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
                                <div class="col-xs-4">
                                    <div class="panel">
                                        <div class="box-header">
                                            <h3 class="box-title">GS Betbhunia</h3>
                                        </div> <!-- /.box-header -->
                                        <div class="panel-body">
                                            <table class="table" id="child">
                                                <thead>
                                                <tr class="parent_cat">
                                                    <td class="service-block__checker">
                                                    <td class="service-block__service">Category Name</td>
                                                    <td class="service-block__service">QTY</td>
                                                </tr>
                                                </thead>
                                                <tbody id="grand-child">
                                                @foreach($categories as $key => $category)
                                                    <tr class="parent_cat parent-sort-row"
                                                        data-id="{{ $category->id }}">
                                                        <td class="service-block__checker">
                                                            <div class="parent_selector">
                                                                <div class="service-block__drag pull-left parent-drag-handle">
                                                                    {{ $key + $categories->firstItem()}}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td colspan="3">
                                                            <table class="table">
                                                                <thead>
                                                                <tr>
                                                                    <td colspan="2" class="service-block__service">
                                                                        <strong class="service-block__category-title"><a href="{{ route('admin.inventories.category', $category->id) }}">{{ $category->category_name }}</a></strong>
                                                                        @if($category->nested->count())
                                                                            <small><span class="service-block__collapse-button-counter" @click="catShowHideGs2({{ $category->id }})"><span id="show_hide_controll2_{{ $category->id }}">Hide</span> Category ({{ $category->nested->count() }})</span></small>
                                                                        @endif
                                                                    </td>
                                                                    @php
                                                                        $sum_tot_Price = 0;
                                                                        foreach($category->nested()->orderBy('id', 'ASC')->get() as $childCat)
                                                                            $sum_tot_Price += $childCat->inventories->where('location', 'gs2')->sum('qty')
                                                                    @endphp
                                                                    <td class="service-block__action"> {{ $sum_tot_Price}}</td>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($category->nested()->orderBy('id', 'ASC')->get() as $key1 => $childCat)
                                                                    <tr class="child child_cat2_{{ $category->id }} child-sort-row" data-id="{{ $childCat->id }}">
                                                                        <td class="service-block__checker">
                                                                            <div class="service-block__drag pull-left child-drag-handle">
                                                                                {{ ++ $key1 }}
                                                                            </div>
                                                                        </td>
                                                                        <td colspan="3"
                                                                            class="service-block__type parent-pad-0">
                                                                            <!-- Start child sub -->
                                                                            <table class="table">
                                                                                <thead>
                                                                                <tr>
                                                                                    <td class="service-block__service">
                                                                                        <strong class="service-block__category-title"><a href="{{ route('admin.inventories.category', $childCat->id) }}?location=gs2">{{ $childCat->category_name }}</a></strong>
                                                                                        @if($childCat->nested->count())
                                                                                            <small><span class="service-block__collapse-button-counter" @click="catShowHideGs2({{ $childCat->id }})"><span id="show_hide_controll2_{{ $childCat->id }}">Hide</span> Category ({{ $childCat->nested->count() }})</span></small>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="service-block__action">{{ $childCat->inventories->where('location', 'gs2')->sum('qty') }}</td>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                @foreach($childCat->nested()->orderBy('id', 'ASC')->get() as $key2 => $grandChildCat)
                                                                                    <tr class="child child_cat2_{{ $childCat->id }} grand-child-sort-row" data-id="{{ $grandChildCat->id }}">
                                                                                        <td colspan="1" class="service-block__checker">
                                                                                            <div class="service-block__drag pull-left grand-child-drag-handle">
                                                                                                {{ ++ $key2 }}
                                                                                            </div>
                                                                                        </td>
                                                                                        <td><strong class="service-block__category-title"><a href="{{ route('admin.inventories.category', $grandChildCat->id) }}?location=gs2">{{ $grandChildCat->category_name }}</a></strong>
                                                                                        </td>
                                                                                        <td class="service-block__action">{{ $grandChildCat->inventories->where('location', 'gs2')->sum('qty') }}</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                                </tbody>
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
                                @if($categories->total())
                                    <div class="row">
                                        <div class="col-sm-5">

                                        </div>
                                        <div class="col-sm-7">
                                            <div class="dataTables_paginate paging_simple_numbers"
                                                 id="sortable_paginate">
                                                {{ $categories->appends(Request::except('page'))->links() }}
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
                catShowHideGs1: function (catId) {
                    $('.child_cat1_' + catId).toggle();
                    const getText = $('#show_hide_controll1_' + catId).html();

                    if (getText === 'Hide') {
                        $('#show_hide_controll1_' + catId).html('Show');
                    } else {
                        $('#show_hide_controll1_' + catId).html('Hide');
                    }
                },
                catShowHideGs2: function (catId) {
                    $('.child_cat2_' + catId).toggle();
                    const getText = $('#show_hide_controll2_' + catId).html();

                    if (getText === 'Hide') {
                        $('#show_hide_controll2_' + catId).html('Show');
                    } else {
                        $('#show_hide_controll2_' + catId).html('Hide');
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
                }
            }
        });

        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            var l = document.getElementsByTagName('a');
            for (var i = 0; i < l.length; i++) {
                l[i].href = '#';
            }
            window.print();

            document.body.innerHTML = originalContents;

        }
    </script>
@endpush
