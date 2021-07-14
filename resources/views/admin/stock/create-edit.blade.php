@extends('layouts.backend')

@section('title')
    @if(isset($stock)) Edit @else Create @endif
@endsection

@section('content')
    <section class="content">
        <form method="POST" action="{{ isset($stock) ? route('admin.stocks.update', $stock->id) : route('admin.stocks.store') }}{{ qString() }}" accept-charset="UTF-8" id="create-edit-form" data-toggle="validator" enctype="multipart/form-data" novalidate="true">
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
                                        <div class="form-group row @error('category_id') has-error @enderror">
                                            <label class="col-md-3">Stock Category<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <select class="form-control select2" id="category_id" name="category_id" onchange="categoryCode();" required>
                                                    <?php $CatId = (isset($stock->category_id)) ? $stock->category_id : old('category_id'); ?>
                                                    <option value="">Select Category</option>
                                                    @foreach($categoryData as $cat)
                                                        <option  value="{{ $cat->id }}" {{ ($CatId==$cat->id)?'selected':'' }} disabled>{{ $cat->category_name }}</option>
                                                        @if(!empty($cat->nested))
                                                            @foreach($cat->nested as $nc)
                                                                <option data-code="{{ $nc->category_code }}" value="{{ $nc->id }}" {{ ($CatId==$nc->id)?'selected':'' }}>
                                                                    &nbsp;&nbsp;{{ $nc->category_name }} [ {{ $nc->category_code }}] </option>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row @error('stock_code') has-error @enderror">
                                            <label class="col-md-3">Stock Code<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" placeholder="Enter Stock Code" name="stock_code" type="text" id="stock_code" value="{{ old('stock_code', $stock->stock_code ?? '')}}" readonly required>
                                                @error('stock_code')
                                                <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('qty') has-error @enderror">
                                            <label for="title" class="col-md-3">Qty<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" placeholder="Qty" name="qty" value="{{ old('qty', $stock->qty ?? '')}}" type="number" id="qty" required>
                                                @error('qty')
                                                <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                    @if(Auth::user()->type == 'super-admin')
                                        <div class="col-md-6">
                                        <div class="form-group row @error('location') has-error @enderror">
                                            <label for="location" class="col-md-3">location<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                            <select class="form-control select2" id="location" name="location">
                                                @php ($loc = old('location', isset($stock) ? $stock->location : ''))
                                                <option value="">Select Location</option>
                                                <option value="hq" {{ $loc  == 'hq' ? 'Selected' : ''}}>
                                                    Head Quarter
                                                </option>
                                                <option value="gs1" {{ $loc == 'gs1' ? 'Selected' : ''}}>
                                                    GS Gazipur
                                                </option>
                                                <option value="gs2" {{ $loc  == 'gs2' ? 'Selected' : ''}}>
                                                    GS Bethbunia
                                                </option>
                                            </select>
                                                @error('location')
                                                <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                        <input type="hidden" name="location" value="{{Auth::user()->location}}" required>
                                    @endif

                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('stock_date') has-error @enderror">
                                            <label class="col-md-3">Stock Date<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Stock Date" name="stock_date" value="{{ old('stock_date', $stock->stock_date ?? '')}}" type="date" required>
                                                @error('stock_date')
                                                <span class="help-block">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row @error('description') has-error @enderror">
                                            <label class="col-md-3">Details</label>
                                            <div class="col-md-8">
                                                <textarea class="form-control" placeholder="Details" name="description" cols="5" rows="10" type="text" required>{{ old('description', $stock->description ?? '')}}</textarea>
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
        function categoryCode() {
            var code= $('#category_id').find(':selected').data('code');
            $('#stock_code').val(code);
        }
    </script>
@endpush
