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
                <div class="col-md-12 col-lg-12">
                    <h3 class="box-title">@if(isset($stock)) Edit @else Add @endif Stock</h3>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group @error('category_id') has-error @enderror">
                                        <label for="category_id" class="with-help">Category*</label>
                                        <select class="form-control select2" id="category_id" name="category_id" v-model="product.category_id" required>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group @error('item_name') has-error @enderror">
                                        <label for="item_name" class="with-help">Item Name*</label>
                                        <input class="form-control" placeholder="Item Name" name="item_name" value="{{old('item_name')}}" type="text" id="item_name" required>
                                        @error('item_name')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group @error('item_serial') has-error @enderror">
                                        <label for="item_serial" class="with-help">Item Serial*</label>
                                        <input class="form-control" placeholder="Name" name="item_serial" value="{{old('item_serial')}}" type="text" id="item_serial" required>
                                        @error('item_serial')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group @error('name') has-error @enderror">
                                        <label for="title" class="with-help">Name*</label>
                                        <input class="form-control" placeholder="Name" name="name" value="{{old('name')}}" type="text" id="name" required>
                                        @error('name')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group @error('name') has-error @enderror">
                                        <label for="title" class="with-help">Name*</label>
                                        <input class="form-control" placeholder="Name" name="name" value="{{old('name')}}" type="text" id="name" required>
                                        @error('name')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group @error('name') has-error @enderror">
                                        <label for="title" class="with-help">Name*</label>
                                        <input class="form-control" placeholder="Name" name="name" value="{{old('name')}}" type="text" id="name" required>
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
                    <p class="help-block">* Required Fields.</p>
                    <div class="text-right form-footer">
                        <button class="button delete" type="reset">Clear</button>
                        <button class="button save" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
