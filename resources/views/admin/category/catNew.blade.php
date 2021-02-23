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
        }

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
                <h3 class="box-title">Categories</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('admin.categories.create') }}" class="button add"> Add Category</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <input class="form-control" placeholder="Keyword" name="keyword" v-model="params.keyword" type="search" @change="getCategories">
                        </div>
                    </div>
                    <div class="col-md-10">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="service-box-wrapper" id="service-box">
                                <div class="box-body table-responsive no-padding">
                                    <table class="table" id="child">
                                        <thead>
                                        <tr class="parent_cat">
                                            <th class="service-block__service">Category Name</th>
                                            <th class="service-block__action"><span id="all_show_hide" @click="allCatChildShowHide" class="btn btn-info">Hide All</span></th>
                                        </tr>
                                        </thead>
                                        <tbody id="grand-child">
                                        <tr :class="{'parent_cat parent-sort-row': true, 'grey': ''}"
                                            :data-id="category.id" v-for="(category, index) in categories">
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
                                            <td colspan="5" :class="{'parent-pad-0': category.nested.length}">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <td colspan="2" class="service-block__service">
                                                            @{{ category.category_name }}
                                                            <small v-if="category.nested.length">
                                                                    <span
                                                                        class="service-block__collapse-button-counter"
                                                                        @click="catShowHide(category.id)">
                                                                        <span
                                                                            :id="`show_hide_controll_${category.id}`">Hide</span>
                                                                       Category (@{{ category.nested.length }})
                                                                    </span>
                                                            </small>
                                                        </td>
                                                        <td class="service-block__action">
                                                            <div class="input-group-btn">
                                                                <button type="button"
                                                                        class="btn btn-default dropdown-toggle"
                                                                        data-toggle="dropdown" aria-expanded="false">
                                                                    Actions
                                                                    <span
                                                                        class="fa fa-caret-down"></span>
                                                                </button>

                                                                <ul class="dropdown-menu dropleft">
                                                                    <li>
                                                                        <a href="javascript:void(0)"
                                                                           @click="showOrEdit(category.id, 'show')"
                                                                           class="ajax-modal-btn">Details</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0)"
                                                                           @click="showOrEdit(category.id, 'edit')"
                                                                           class="ajax-modal-btn">{{ __('vendor.edit') }}</a>
                                                                    </li>
                                                                    <li>
                                                                        <form method="POST"
                                                                              :action="`${window.location.origin}/admin/categories/${category.id}`"
                                                                              accept-charset="UTF-8" class="data-form">
                                                                            @csrf
                                                                            @method('delete')
                                                                            <a href="javascript:void(0)"
                                                                               @click="destroy"
                                                                               class="dropdown-menu-link confirm ajax-silent">
                                                                                Trash
                                                                            </a>
                                                                        </form>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr :class="[`child child_cat_${ category.id } child-sort-row`, { 'grey': '' }]"
                                                        :data-id="childCat.id"
                                                        v-for="(childCat, index) in category.nested">
                                                        <td class="service-block__checker">
                                                            <div
                                                                class="service-block__drag pull-left child-drag-handle">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                     viewBox="0 0 20 20"><title>
                                                                        Drag</title>
                                                                    <path
                                                                        d="M7 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm6-8c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                                                </svg>
                                                            </div>
                                                        </td>
                                                        <td colspan="5" class="service-block__type parent-pad-0">
                                                            <!-- Start child sub -->
                                                            <table class="table">
                                                                <thead>
                                                                <tr>
                                                                    <td class="service-block__service">
                                                                        @{{ childCat.category_name }}
                                                                        <small v-if="childCat.nested.length">
                                                                                <span class="service-block__collapse-button-counter" @click="catShowHide(childCat.id)">
                                                                                    <span :id="`show_hide_controll_${ childCat.id }`">Hide</span>
                                                                                    Category (@{{ childCat.nested.length }})
                                                                                </span>
                                                                        </small>
                                                                    </td>
                                                                    <td class="service-block__action">
                                                                        <div class="input-group-btn">
                                                                            <button type="button"
                                                                                    class="btn btn-default dropdown-toggle"
                                                                                    data-toggle="dropdown"
                                                                                    aria-expanded="false">Actions
                                                                                <span
                                                                                    class="fa fa-caret-down"></span>
                                                                            </button>

                                                                            <ul class="dropdown-menu dropleft">
                                                                                <li>
                                                                                    <a href="javascript:void(0)"
                                                                                       @click="showOrEdit(childCat.id, 'show')"
                                                                                       class="ajax-modal-btn">{{ __('create.details') }}</a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="javascript:void(0)"
                                                                                       @click="showOrEdit(childCat.id, 'edit')"
                                                                                       class="ajax-modal-btn">{{ __('vendor.edit') }}</a>
                                                                                </li>
                                                                                <li>
                                                                                    <form method="POST"
                                                                                          :action="`${window.location.origin}/admin/categories/${childCat.id}`"
                                                                                          accept-charset="UTF-8"
                                                                                          class="data-form">
                                                                                        @csrf
                                                                                        @method('delete')
                                                                                        <a href="javascript:void(0)"
                                                                                           @click="destroy"
                                                                                           class="dropdown-menu-link confirm ajax-silent">
                                                                                            {{ __('trash.trash') }}
                                                                                        </a>
                                                                                    </form>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr :class="[`child child_cat_${ childCat.id } grand-child-sort-row`, { 'grey': grandChildCat.status == 2 }]"
                                                                    :data-id="grandChildCat.id"
                                                                    v-for="(grandChildCat, index) in childCat.nested">
                                                                    <td colspan="2" class="service-block__checker">
                                                                        <div
                                                                            class="service-block__drag pull-left grand-child-drag-handle">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                 viewBox="0 0 20 20"><title>Drag</title>
                                                                                <path
                                                                                    d="M7 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm6-8c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                                                            </svg>
                                                                        </div>
                                                                        <div class="pull-left cat_check">
                                                                            @{{ grandChildCat.category_name }}
                                                                        </div>
                                                                    </td>
                                                                    <td class="service-block__action">
                                                                        <div class="input-group-btn">
                                                                            <button type="button"
                                                                                    class="btn btn-default dropdown-toggle"
                                                                                    data-toggle="dropdown"
                                                                                    aria-expanded="false">Actions
                                                                                <span
                                                                                    class="fa fa-caret-down"></span>
                                                                            </button>

                                                                            <ul class="dropdown-menu dropleft">
                                                                                <li>
                                                                                    <a href="javascript:void(0)"
                                                                                       @click="showOrEdit(grandChildCat.id, 'show')"
                                                                                       class="ajax-modal-btn">{{ __('create.details') }}</a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="javascript:void(0)"
                                                                                       @click="showOrEdit(grandChildCat.id, 'edit')"
                                                                                       class="ajax-modal-btn">{{ __('vendor.edit') }}</a>
                                                                                </li>
                                                                                <li>
                                                                                    <form method="POST"
                                                                                          :action="`${window.location.origin}/admin/categories/${grandChildCat.id}`"
                                                                                          accept-charset="UTF-8"
                                                                                          class="data-form">
                                                                                        @csrf
                                                                                        @method('delete')
                                                                                        <a href="javascript:void(0)"
                                                                                           @click="destroy"
                                                                                           class="dropdown-menu-link confirm ajax-silent">
                                                                                            {{ __('trash.trash') }}
                                                                                        </a>
                                                                                    </form>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                            <!-- End Child sub -->
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
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
            data: {
                isEdit: true,
                params: {
                    keyword: '',
                    status: '',
                    sort_by: 'sorting',
                    order_by: 'desc',
                },
                pagination: {
                    current_page: 1
                },
                trashedPagination: {
                    current_page: 1
                },
                category: {
                    category_name: '',
                    parent_id: '',
                    category_details: '',
                    featured_category: '',
                    route_title: '',
                    route_keyword: '',
                    route_description: '',
                    status: '',
                },
                categories: [],
                trashed: [],
                errors: {}
            },
            mounted() {
                this.getCategories();
                this.getTrashed();
            },
            methods: {
                initLibs: function () {
                    setTimeout(function () {
                        $('.select2').select2({
                            width: '100%',
                            placeholder: 'Select',
                        });
                    }, 10);
                },
                filterParam(key, val) {
                    if (key === 'sort') {
                        if (this.params.order_by === '' || this.params.order_by === 'desc') {
                            this.params.order_by = 'asc';
                        } else {
                            this.params.order_by = 'desc';
                        }
                        this.params.sort_by = val;
                    } else {
                        this.params.status = val;
                    }

                    this.getCategories();
                },
                getCategories: function () {
                    const vm = this;

                    $.ajax({
                        type: 'get',
                        url: '{{ route('admin.categories.all') }}?page=' + vm.pagination.current_page,
                        data: vm.params,
                        success: function (response) {
                            if ($.fn.dataTable.isDataTable('#file_export')) {
                                $('#file_export').DataTable().destroy();
                            }
                            vm.categories = response.data;
                            vm.pagination = response;
                            setTimeout(function () {
                                initDataTable();
                            }, 1);
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
                },

                showOrEdit: function (id) {
                    const vm = this;

                    $.ajax({
                        type: 'get',
                        url: `/admin/categories/${id}/show`,
                    });
                },
                createCategory: function () {
                    const vm = this;
                    let form = document.getElementById('category-create-form');
                    let formData = new FormData(form);

                    $.ajax({
                        type: 'post',
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        url: form.getAttribute('action'),
                        beforeSend: function () {
                            // Show image container
                            $("#loader").show();
                            $("body").css("pointer-events", "none");
                            $("#app").css("opacity", ".3");
                        },
                        success: function (response) {
                            form.reset();
                            toastr["success"](response.msg);
                            const index = vm.categories.findIndex(category => category.id === response.data.id);
                            Vue.set(vm.categories, index, response.data);
                            $('#category-create-modal').modal('hide');
                        },
                        error: function (response) {
                            if (response.status === 422) {
                                vm.errors = response.responseJSON.errors;
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: '500 Internal Server Error!',
                                    html: 'Something went wrong! <br> <span class="error-message text-danger hidden">' + response.responseJSON.message + '</span>',
                                    footer: '<a href="javascript:void(0)" onclick="document.querySelector(\'.error-message\').classList.remove(\'hidden\');">Why do I have this issue?</a>'
                                });
                            }
                        },
                        complete: function () {
                            // Hide image container
                            $("#loader").hide();
                            $("body").css("pointer-events", "all");
                            $("#app").css("opacity", "1");
                        }
                    });
                },
                destroy: function () {
                    const vm = this;
                    const form = $(event.target).closest('form');

                    Swal.fire({
                        title: 'Are you sure?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: 'post',
                                data: form.serialize(),
                                url: form.attr('action'),
                                beforeSend: function () {
                                    // Show image container
                                    $("#loader").show();
                                    $("body").css("pointer-events", "none");
                                    $("#app").css("opacity", ".3");
                                },
                                success: function (response) {
                                    toastr["success"](response.msg);
                                    vm.getCategories();
                                    vm.getTrashed();
                                },
                                error: function (response) {
                                    Swal.fire({
                                        type: 'error',
                                        title: '500 Internal Server Error!',
                                        html: 'Something went wrong! <br> <span class="error-message text-danger hidden">' + response.responseJSON.message + '</span>',
                                        footer: '<a href="javascript:void(0)" onclick="document.querySelector(\'.error-message\').classList.remove(\'hidden\');">Why do I have this issue?</a>'
                                    });
                                },
                                complete: function () {
                                    // Hide image container
                                    $("#loader").hide();
                                    $("body").css("pointer-events", "all");
                                    $("#app").css("opacity", "1");
                                }
                            });
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
                fileChosen: function () {
                    if (event.target.value) {
                        $('#uploadFile').val(event.target.files[0].name);
                    } else {
                        $('#uploadFile').val('');
                    }
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
