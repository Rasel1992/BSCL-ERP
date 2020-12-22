@extends('layouts.backend')

{{--@section('title')--}}
{{--    @if(isset($brand)) {{ __('brand.brand_edit') }} @else {{ __('brand.brand_create') }} @endif--}}
{{--@endsection--}}

@section('content')
    <section class="content">
        <form method="post">
{{--        <form method="POST" action="{{ isset($brand) ? route('admin.catalog.brands.update', $brand->id) : route('admin.catalog.brands.store') }}" accept-charset="UTF-8" id="create-edit-form" data-toggle="validator" enctype="multipart/form-data" novalidate="true">--}}
{{--            @csrf--}}
{{--            {!! (isset($brand))?'<input name="_method" type="hidden" value="PUT">':'' !!}--}}
            <div class="row">
                <div class="col-md-3 col-lg-3"></div>
                <div class="col-md-6 col-lg-6">
{{--                    <h3 class="box-title">@if(isset($brand)) {{ __('create.edit') }} @else {{ __('create.add') }} @endif {{ __('brand.brand') }}</h3>--}}
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group @error('name') has-error @enderror">
                                        <label for="title" class="with-help">{{ __('brand.name') }}*</label>
                                        <input class="form-control" placeholder="{{ __('brand.p_name') }}" name="name" value="{{old('name')}}" v-model="brand.name" type="text" id="name" required>
                                        @error('name')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="form-group @error('logo') has-error @enderror">
                                <label for="exampleInputFile" class="with-help">{{ __('brand.brand_logo') }}*</label>

                                <div class="row">
                                    <div class="col-md-9 nopadding-right">
                                        <input id="uploadFile" placeholder="{{ __('brand.brand_logo') }}" class="form-control" disabled="disabled" style="height: 28px;">
                                    </div>
                                    <div class="col-md-3 nopadding-left">
                                        <div class="fileUpload btn btn-primary btn-block btn-flat">
                                            <span>{{ __('brand.upload') }}</span>
                                            <input type="file" name="logo" value="{{old('logo')}}" accept="image/*" id="uploadBtn" @change="fileChosen" class="upload" @if(!isset($brand)) required @endif>
                                        </div>
                                    </div>
                                </div>
                                @error('logo')
                                <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <p class="help-block">{{ __('create.required') }}</p>
                    <div class="text-right form-footer">
                        <button class="button delete" type="reset">{{ __('create.clear') }}</button>
                        <button class="button save" type="submit">@if(isset($brand)) {{ __('create.update') }} @else {{ __('create.create') }} @endif</button>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3"></div>
            </div>
        </form>
    </section>
@endsection
