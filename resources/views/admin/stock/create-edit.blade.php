@extends('layouts.backend')

@section('title')
    @if(isset($stock)) Edit @else Create @endif
@endsection

@section('content')
    <section class="content">
        <form method="POST" action="{{ isset($stock) ? route('admin.stocks.update', $stock->id) : route('admin.stocks.store') }}" accept-charset="UTF-8" id="create-edit-form" data-toggle="validator" enctype="multipart/form-data" novalidate="true">
            @csrf
            {!! (isset($stock))?'<input name="_method" type="hidden" value="PUT">':'' !!}
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <h3 class="box-title">@if(isset($stock)) Edit @else Add @endif Stock
                    <a href="{{ route('admin.stocks.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> List of Stock</a>
                    </h3>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('stock_code') has-error @enderror">
                                            <label for="name" class="col-md-3">Stock Code<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" placeholder="Enter Stock Code" required name="stock_code"
                                                   value="{{old('stock_code')}}" type="text" id="stock_code" v-model="stock.stock_code">
                                            </div>
                                            @error('stock_code')
                                            <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row @error('category_id') has-error @enderror">
                                            <label for="category_id" class="col-md-3">Stock Category<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                            <select class="form-control select2" id="category_id" name="category_id" v-model="stock.category_id" required v-select2>
                                                <option value="">Select Category</option>
                                                @foreach($categoryData as $cat)
                                                    <option value="{{ $cat->id }}" disabled>{{ $cat->category_name }}</option>
                                                    @if(!empty($cat->nested))
                                                        @foreach($cat->nested as $nc)
                                                            <option value="{{ $nc->id }}">
                                                                &nbsp;&nbsp;-- {{ $nc->category_name }}</option>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </select>
                                            </div>
                                            @error('category_id')
                                            <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('qty') has-error @enderror">
                                            <label for="title" class="col-md-3">Qty<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" placeholder="Qty" name="qty" v-model="stock.qty" type="number" id="qty" required>
                                            </div>
                                                @error('qty')
                                            <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row @error('location') has-error @enderror">
                                            <label for="location" class="col-md-3">location<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                            <select class="form-control select2" id="location" name="location"
                                                    v-model="stock.location" v-select2>
                                                <option value="">Select Location</option>
                                                <option
                                                    value="hq" {{(isset($stock->location)?$stock->location:old('location') == 'hq') ? 'Selected' : ''}}>
                                                    Head Quarter
                                                </option>
                                                <option
                                                    value="gs1" {{(isset($stock->location)?$stock->location:old('location') == 'gs1') ? 'Selected' : ''}}>
                                                    GS Gazipur
                                                </option>
                                                <option
                                                    value="gs2" {{(isset($stock->location)?$stock->location:old('location') == 'gs2') ? 'Selected' : ''}}>
                                                    GS Bethbunia
                                                </option>
                                            </select>
                                            </div>
                                            @error('location')
                                            <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('description') has-error @enderror">
                                            <label class="col-md-3">Details</label>
                                            <div class="col-md-8">
                                            <input class="form-control" placeholder="Details" name="description" v-model="stock.description" type="text" required>
                                            </div>
                                            @error('description')
                                            <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right form-footer">
                        <button class="button delete" type="reset">Clear</button>
                        <button class="button save" type="submit">Save</button>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </form>
    </section>
@endsection
@push('scripts')
    <script>
        new Vue({
            el: '#app',
            data: {
                stock: {
                    stock_code: '{{ old('stock_code', $stock->stock_code ?? '') }}',
                    description: '{{ old('description', $stock->description ?? '') }}',
                    category_id: '{{ old('category_id ', $stock->category_id  ?? '') }}',
                    qty: '{{ old('qty', $stock->qty ?? '') }}',
                    location: '{{ old('location', $stock->location ?? '') }}',
                },
                mounted() {
                    this.initLibs();
                },
                methods: {
                    initLibs: function () {
                        setTimeout(function () {
                            $('.select2').select2({
                                width: '100%',
                                placeholder: 'Select',
                            });
                        }, 10);
                    }
                }
            }
        })
    </script>
@endpush
