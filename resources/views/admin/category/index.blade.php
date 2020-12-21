@extends('layouts.backend')

@section('title')
    {{ __('brand.brand') }}
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Categories</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('admin.stocks.create') }}" class="button add"> Add Category</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <table class="table table-hover table-2nd-no-sort" id="file_export">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
{{--                    @foreach($brands as $brand)--}}
{{--                        <tr>--}}
{{--                            <td>--}}
{{--                                <input name="brand_ids[]" type="checkbox" class="massCheck" value="{{ $brand->id }}">--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                {{ $brand->name }}</strong>--}}
{{--                            </td>--}}
{{--                            <td> {!! viewImg(auth()->user()->store_id . '/brand', $brand->logo, ['thumb' => 1, 'class' => 'img-circle', 'style' => 'width:40px; height:40px;']) !!}</td>--}}
{{--                            <td>--}}
{{--                                {{ $brand->created_at->format('M d, Y') }}--}}
{{--                            </td>--}}
{{--                            <td class="row-options text-muted small">--}}
{{--                                <a href="{{route('admin.catalog.brands.edit', $brand->id) }}" class="ajax-modal-btn"><i data-toggle="tooltip" data-placement="top" title="{{ __('brand.edit') }}" class="fa fa-edit"></i></a>&nbsp;--}}
{{--                                <form method="POST" action="{{ route('admin.catalog.brands.destroy', $brand->id) }}" accept-charset="UTF-8" class="data-form">--}}
{{--                                    @csrf--}}
{{--                                    @method('delete')--}}
{{--                                    <a href="javascript:void(0)" @click="destroy" class="confirm ajax-silent" title="{{ __('trash.trash') }}" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash-o"></i></a>--}}
{{--                                </form>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
                    </tbody>
                </table>
{{--                @if($brands->total())--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-sm-5">--}}
{{--                            <div class="dataTables_info" id="sortable_info" role="status" aria-live="polite">--}}
{{--                                {{ __('pagination.showing') }} {{ $brands->firstItem() }} {{ __('pagination.to') }} {{ $brands->lastItem() }} {{ __('pagination.of') }} {{ $brands->total() }} {{ __('pagination.entries') }}--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-7">--}}
{{--                            <div class="dataTables_paginate paging_simple_numbers" id="sortable_paginate">--}}
{{--                                {{ $brands->links() }}--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}
            </div> <!-- /.box-body -->
        </div> <!-- /.box -->
{{--        <form method="POST" id="bulk-trash-or-destroy" action="{{ route('admin.catalog.brands.bulk.trash.or.destroy') }}" accept-charset="UTF-8" class="data-form">--}}
{{--            @csrf--}}
{{--            @method('delete')--}}
{{--            <input type="hidden" name="type">--}}
{{--        </form>--}}
{{--        <x-catalog.brand.trashed :trashed="$trashed"/>--}}
    </section>
@endsection

{{--@push('scripts')--}}
{{--    <script>--}}
{{--        new Vue({--}}
{{--            el: '#app',--}}
{{--            methods: {--}}
{{--                destroy: function () {--}}
{{--                    const $this = $(event.target);--}}

{{--                    Swal.fire({--}}
{{--                        title: 'Are you sure?',--}}
{{--                        text: "You won't be able to revert this!",--}}
{{--                        type: 'warning',--}}
{{--                        showCancelButton: true,--}}
{{--                        confirmButtonColor: '#3085d6',--}}
{{--                        cancelButtonColor: '#d33',--}}
{{--                        confirmButtonText: 'Yes, delete it!'--}}
{{--                    }).then((result) => {--}}
{{--                        if (result.value) {--}}
{{--                            $this.closest('form').submit();--}}
{{--                        }--}}
{{--                    });--}}
{{--                },--}}
{{--                destroyPermanentlyOrRestore: function (type) {--}}
{{--                    const $this = $(event.target);--}}
{{--                    const confirmButtonText = type === 'permanently' ? 'delete' : 'restore';--}}

{{--                    Swal.fire({--}}
{{--                        title: 'Are you sure?',--}}
{{--                        text: "You won't be able to revert this!",--}}
{{--                        type: 'warning',--}}
{{--                        showCancelButton: true,--}}
{{--                        confirmButtonColor: '#3085d6',--}}
{{--                        cancelButtonColor: '#d33',--}}
{{--                        confirmButtonText: `Yes, ${confirmButtonText} it!`--}}
{{--                    }).then((result) => {--}}
{{--                        if (result.value) {--}}
{{--                            $this.closest('form').find('input[name=type]').val(type);--}}
{{--                            $this.closest('form').submit();--}}
{{--                        }--}}
{{--                    });--}}
{{--                },--}}
{{--                bulkDestroy: function () {--}}
{{--                    const $this = $(event.target);--}}

{{--                    Swal.fire({--}}
{{--                        title: 'Are you sure?',--}}
{{--                        text: "You won't be able to revert this!",--}}
{{--                        type: 'warning',--}}
{{--                        showCancelButton: true,--}}
{{--                        confirmButtonColor: '#3085d6',--}}
{{--                        cancelButtonColor: '#d33',--}}
{{--                        confirmButtonText: 'Yes, delete it!'--}}
{{--                    }).then((result) => {--}}
{{--                        if (result.value) {--}}
{{--                            $this.closest('form').submit();--}}
{{--                        }--}}
{{--                    });--}}
{{--                },--}}
{{--                checkAll: function () {--}}
{{--                    $('input[name=select_all]').click();--}}

{{--                    if ($('input[name=select_all]').is(':checked')) {--}}
{{--                        $('#check-all-icon').addClass('fa-check-square-o').removeClass('fa-square-o');--}}
{{--                        $('.massCheck').prop('checked', true);--}}
{{--                    } else {--}}
{{--                        $('#check-all-icon').removeClass('fa-check-square-o').addClass('fa-square-o');--}}
{{--                        $('.massCheck').prop('checked', false);--}}
{{--                    }--}}
{{--                },--}}
{{--                trashOrDestroyPermanently: function (type) {--}}
{{--                    Swal.fire({--}}
{{--                        title: 'Are you sure?',--}}
{{--                        text: "You won't be able to revert this!",--}}
{{--                        type: 'warning',--}}
{{--                        showCancelButton: true,--}}
{{--                        confirmButtonColor: '#3085d6',--}}
{{--                        cancelButtonColor: '#d33',--}}
{{--                        confirmButtonText: `Yes, ${type} it!`--}}
{{--                    }).then((result) => {--}}
{{--                        if (result.value) {--}}
{{--                            const form = $('#bulk-trash-or-destroy');--}}
{{--                            form.append($('.massCheck'));--}}
{{--                            form.find('input[name=type]').val(type);--}}
{{--                            form.submit();--}}
{{--                        }--}}
{{--                    });--}}
{{--                }--}}
{{--            }--}}
{{--        })--}}
{{--    </script>--}}
{{--@endpush--}}

