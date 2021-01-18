@extends('layouts.backend')

@section('title')
    @if(isset($stock)) Edit @else Create @endif
@endsection

@section('content')
    <section class="content">
        <form method="POST"
              action="{{ isset($stock) ? route('admin.stocks.update', $stock->id) : route('admin.stocks.store') }}"
              accept-charset="UTF-8" id="create-edit-form" data-toggle="validator" enctype="multipart/form-data"
              novalidate="true">
            @csrf
            {!! (isset($stock))?'<input name="_method" type="hidden" value="PUT">':'' !!}
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h3 class="box-title">@if(isset($stock)) Edit @else Add @endif Stock</h3>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="form-group @error('description') has-error @enderror">
                                <label class="with-help">Details</label>
                                <input class="form-control" placeholder="Details" name="description"
                                       value="{{old('description')}}" type="text" required>
                                @error('description')
                                <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                            <div class="form-group @error('category_id') has-error @enderror">
                                <label for="category_id" class="with-help">Stock Category*</label>
                                <select class="form-control select2" id="category_id" name="category_id"
                                        v-model="product.category_id" required>
                                    @foreach($categoryData as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>

                                        @if(!empty($cat->nested))
                                            @foreach($cat->nested as $nc)
                                                <option value="{{ $nc->id }}">
                                                    &nbsp;&nbsp;-- {{ $nc->category_name }}</option>
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
                            <div class="form-group @error('qty') has-error @enderror">
                                <label for="title" class="with-help">Qty</label>
                                <input class="form-control" placeholder="Qty" name="qty" value="{{old('qty')}}"
                                       type="number" id="qty" required>
                                @error('qty')
                                <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                            <div class="form-group @error('location') has-error @enderror">
                                <label for="location" class="with-help">location*</label>
                                <select class="form-control select2" id="location" name="location"
                                        v-model="inventory.location" v-select2>
                                    <option
                                        value="hq" {{(isset($inventory->location)?$inventory->location:old('location') == 'hq') ? 'Selected' : ''}}>
                                        Head Quarter
                                    </option>
                                    <option
                                        value="gs1" {{(isset($inventory->location)?$inventory->location:old('location') == 'gs1') ? 'Selected' : ''}}>
                                        GS Gazipur
                                    </option>
                                    <option
                                        value="gs2" {{(isset($inventory->location)?$inventory->location:old('location') == 'gs2') ? 'Selected' : ''}}>
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
                    <div class="text-right form-footer">
                        <button class="button delete" type="reset">Clear</button>
                        <button class="button save" type="submit">Save</button>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </form>
    </section>
@endsection
