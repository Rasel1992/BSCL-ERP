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
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Category</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('admin.categories.create') }}"
                       class="button add">Add Category</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('admin.categories.index') }}" class="form-inline float-right">
                            <div class="form-group mb-2">
                                <select class="form-control" id="type" name="type">
                                    <option value="">Select Type</option>
                                    @foreach(['Fixed', 'Current', 'Stock'] as $type)
                                        <option value="{{ $type }}" {{ $type==Request::get('type')?'selected':''}}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label class="sr-only">&nbsp;</label>
                                <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Input your search text...">
                            </div>

                            <button type="submit" class="btn btn-info mb-2"><i class="fa fa-search"></i> Search</button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-warning mb-2"><i class="fa fa-times"></i></a>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="service-box-wrapper" id="service-box">
                                <div class="box-body table-responsive no-padding">
                                    <table class="table" id="child">
                                        <thead>
                                        <tr class="parent_cat">
                                            <td class="service-block__checker">

                                            <td class="service-block__service">Category Name</td>
                                            <td class="service-block__action"><span
                                                    id="all_show_hide" @click="allCatChildShowHide"
                                                    class="btn btn-info">Hide All</span></td>
                                        </tr>
                                        </thead>
                                        <tbody id="grand-child">
                                        @foreach($categoryData as $category)
                                            <tr class="parent_cat parent-sort-row" data-id="{{ $category->id }}">
                                                <td class="service-block__checker">
                                                    <div class="parent_selector">
                                                        <div class="service-block__drag pull-left parent-drag-handle">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                <title>Drag</title>
                                                                <path
                                                                    d="M7 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm6-8c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="3">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <td colspan="2" class="service-block__service">
                                                                <strong
                                                                    class="service-block__category-title">{{ $category->category_name }}</strong>
                                                                @if($category->nested->count())
                                                                    <small><span
                                                                            class="service-block__collapse-button-counter"
                                                                            @click="catShowHide({{ $category->id }})"><span id="show_hide_controll_{{ $category->id }}">Hide</span> Category ({{ $category->nested->count() }})</span></small>
                                                                @endif
                                                            </td>
                                                            <td class="service-block__action">
                                                                <div class="input-group-btn">
                                                                    <button type="button" class="btn btn-default dropdown-toggle"
                                                                            data-toggle="dropdown" aria-expanded="false">Actions
                                                                        <span
                                                                            class="fa fa-caret-down"></span>
                                                                    </button>

                                                                    <ul class="dropdown-menu dropleft">
                                                                        <li>
                                                                            <a href="{{ route('admin.categories.show', $category->id).qString() }}"
                                                                               class="ajax-modal-btn">Show</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{route('admin.categories.edit', $category->id).qString() }}"
                                                                               class="ajax-modal-btn">Edit</a>
                                                                        </li>
                                                                        <li>
                                                                            <form method="POST"
                                                                                  action="{{ route('admin.categories.destroy', $category->id).qString() }}"
                                                                                  accept-charset="UTF-8" class="data-form">
                                                                                @csrf
                                                                                @method('delete')
                                                                                <a href="javascript:void(0)" @click="destroy"
                                                                                   class="dropdown-menu-link confirm ajax-silent"
                                                                                   title="Delete"
                                                                                   data-toggle="tooltip"
                                                                                   data-placement="top">Delete</a>
                                                                            </form>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($category->nested()->orderBy('sorting', 'ASC')->get() as $childCat)
                                                            <tr class="child child_cat_{{ $category->id }} child-sort-row" data-id="{{ $childCat->id }}">
                                                                <td class="service-block__checker">
                                                                    <div class="service-block__drag pull-left child-drag-handle">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>
                                                                                Drag</title>
                                                                            <path
                                                                                d="M7 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm6-8c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                                                        </svg>
                                                                    </div>
                                                                </td>
                                                                <td colspan="3" class="service-block__type parent-pad-0">
                                                                    <!-- Start child sub -->
                                                                    <table class="table">
                                                                        <thead>
                                                                        <tr>
                                                                            <td class="service-block__service">
                                                                                <strong
                                                                                    class="service-block__category-title">{{ $childCat->category_name }}</strong>
                                                                                @if($childCat->nested->count())
                                                                                    <small><span
                                                                                            class="service-block__collapse-button-counter"
                                                                                            @click="catShowHide({{ $childCat->id }})"><span id="show_hide_controll_{{ $childCat->id }}">Hide</span> Category ({{ $childCat->nested->count() }})</span></small>
                                                                                @endif
                                                                            </td>
                                                                            <td class="service-block__action">
                                                                                <div class="input-group-btn">
                                                                                    <button type="button" class="btn btn-default dropdown-toggle"
                                                                                            data-toggle="dropdown" aria-expanded="false">Actions
                                                                                        <span
                                                                                            class="fa fa-caret-down"></span>
                                                                                    </button>

                                                                                    <ul class="dropdown-menu dropleft">
                                                                                        <li>
                                                                                            <a href="{{ route('admin.categories.show', $childCat->id).qString() }}"
                                                                                               class="ajax-modal-btn">Show</a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="{{route('admin.categories.edit', $childCat->id).qString() }}"
                                                                                               class="ajax-modal-btn">Edit</a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <form method="POST"
                                                                                                  action="{{ route('admin.categories.destroy', $childCat->id).qString() }}"
                                                                                                  accept-charset="UTF-8" class="data-form">
                                                                                                @csrf
                                                                                                @method('delete')
                                                                                                <a href="javascript:void(0)" @click="destroy"
                                                                                                   class="dropdown-menu-link confirm ajax-silent"
                                                                                                   title="Delete"
                                                                                                   data-toggle="tooltip"
                                                                                                   data-placement="top">Delete</a>
                                                                                            </form>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @foreach($childCat->nested()->orderBy('sorting', 'ASC')->get() as $grandChildCat)
                                                                            <tr class="child child_cat_{{ $childCat->id }} grand-child-sort-row" data-id="{{ $grandChildCat->id }}">
                                                                                <td colspan="1" class="service-block__checker">
                                                                                    <div class="service-block__drag pull-left grand-child-drag-handle">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                                             viewBox="0 0 20 20"><title>Drag</title>
                                                                                            <path
                                                                                                d="M7 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm6-8c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                                                                        </svg>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="service-block__service"><strong
                                                                                        class="service-block__category-title">{{ $grandChildCat->category_name }}</strong></td>3.
                                                                                <td class="service-block__action">
                                                                                    <div class="input-group-btn">
                                                                                        <button type="button" class="btn btn-default dropdown-toggle"
                                                                                                data-toggle="dropdown" aria-expanded="false">Actions
                                                                                            <span
                                                                                                class="fa fa-caret-down"></span>
                                                                                        </button>

                                                                                        <ul class="dropdown-menu dropleft">
                                                                                            <li>
                                                                                                <a href="{{ route('admin.categories.show', $grandChildCat->id).qString() }}"
                                                                                                   class="ajax-modal-btn">Show</a>
                                                                                            </li>
                                                                                            <li>
                                                                                                <a href="{{route('admin.categories.edit', $grandChildCat->id).qString() }}"
                                                                                                   class="ajax-modal-btn">Edit</a>
                                                                                            </li>
                                                                                            <li>
                                                                                                <form method="POST"
                                                                                                      action="{{ route('admin.categories.destroy', $grandChildCat->id).qString() }}"
                                                                                                      accept-charset="UTF-8" class="data-form">
                                                                                                    @csrf
                                                                                                    @method('delete')
                                                                                                    <a href="javascript:void(0)" @click="destroy"
                                                                                                       class="dropdown-menu-link confirm ajax-silent"
                                                                                                       title="Delete"
                                                                                                       data-toggle="tooltip"
                                                                                                       data-placement="top">Delete</a>
                                                                                                </form>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </td>
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
                                    @if($categoryData->total())
                                        <div class="row">
                                            <div class="col-sm-5">

                                            </div>
                                            <div class="col-sm-7">
                                                <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">
                                                    {{ $categoryData->appends(Request::except('page'))->links() }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </div> <!-- /.box-body -->
        </div> <!-- /.box -->
    </section>
@endsection

@push('scripts')
    <script>
        new Vue({
            el: '#app',
            methods: {
                statusUpdate: function (action) {
                    const $this = $(event.target);

                    Swal.fire({
                        title: 'Are you sure?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: `Yes, ${action} it!`
                    }).then((result) => {
                        if (result.value) {
                            $this.closest('form').submit();
                        }
                    });
                },
                destroy: function () {
                    const $this = $(event.target);

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            $this.closest('form').submit();
                        }
                    });
                },
                destroyPermanentlyOrRestore: function (type) {
                    const $this = $(event.target);
                    const confirmButtonText = type === 'permanently' ? 'delete' : 'restore';

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: `Yes, ${confirmButtonText} it!`
                    }).then((result) => {
                        if (result.value) {
                            $this.closest('form').find('input[name=type]').val(type);
                            $this.closest('form').submit();
                        }
                    });
                },
                bulkDestroy: function () {
                    const $this = $(event.target);

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            $this.closest('form').submit();
                        }
                    });
                },
                checkAll: function () {
                    $('input[name=select_all]').click();

                    if ($('input[name=select_all]').is(':checked')) {
                        $('#check-all-icon').addClass('fa-check-square-o').removeClass('fa-square-o');
                        $('.massCheck').prop('checked', true);
                    } else {
                        $('#check-all-icon').removeClass('fa-check-square-o').addClass('fa-square-o');
                        $('.massCheck').prop('checked', false);
                    }
                },
                trashOrDestroyPermanently: function (type) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: `Yes, ${type} it!`
                    }).then((result) => {
                        if (result.value) {
                            const form = $('#bulk-trash-or-destroy');
                            form.append($('.massCheck'));
                            form.find('input[name=type]').val(type);
                            form.submit();
                        }
                    });
                },
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

        $(function () {
            $("#service-box").sortable({
                placeholder: 'sort-highlight',
                forcePlaceholderSize: true,
                axis: 'y',
                items: "tr.parent_cat",
                cursor: 'move',
                handle: '.parent-drag-handle',
                opacity: 0.6,
                update: function () {
                    const ids = [];

                    $('tr.parent-sort-row').each(function (index, element) {
                        ids.push($(this).attr('data-id'));
                    });

                    sort(ids);
                }
            });

            $("#child").sortable({
                placeholder: 'sort-highlight',
                forcePlaceholderSize: true,
                axis: 'y',
                items: "tr.child-sort-row",
                cursor: 'move',
                handle: '.child-drag-handle',
                opacity: 0.6,
                update: function () {
                    const ids = [];

                    $('tr.child-sort-row').each(function (index, element) {
                        ids.push($(this).attr('data-id'));
                    });

                    sort(ids);
                }
            });

            $("#grand-child").sortable({
                placeholder: 'sort-highlight',
                forcePlaceholderSize: true,
                axis: 'y',
                items: "tr.grand-child-sort-row",
                cursor: 'move',
                handle: '.grand-child-drag-handle',
                opacity: 0.6,
                update: function () {
                    const ids = [];

                    $('tr.grand-child-sort-row').each(function (index, element) {
                        ids.push($(this).attr('data-id'));
                    });

                    sort(ids);
                }
            });

            function sort(ids) {
                $.ajax({
                    type: 'post',
                    dataType: "json",
                    data: {ids: ids},
                    url: '{{ route('admin.categories.update.order') }}',
                    success: function (response) {
                        console.log(response.msg);
                    },
                    error: function (response) {
                        Swal.fire({
                            type: 'error',
                            title: '500 Internal Server Error!',
                            html: 'Something went wrong! <br> <span class="error-message text-danger hidden">' + response.responseJSON.message + '</span>',
                            footer: '<a href="javascript:void(0)" onclick="document.querySelector(\'.error-message\').classList.remove(\'hidden\');">Why do I have this issue?</a>'
                        });
                    }
                });
            }
        });
    </script>
@endpush
