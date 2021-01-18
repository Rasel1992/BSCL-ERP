@extends('layouts.backend')

@section('title')
    @if(isset($stock)) Edit @else Create @endif
@endsection

@section('content')
    <section class="content">
        <form method="POST" action="{{ isset($billRegister) ? route('admin.bills.update', $billRegister->id) : route('admin.bills.store') }}" accept-charset="UTF-8" id="create-edit-form" data-toggle="validator" enctype="multipart/form-data" novalidate="true">
            @csrf
            {!! (isset($stock))?'<input name="_method" type="hidden" value="PUT">':'' !!}
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <h3 class="box-title">@if(isset($billRegister)) Edit @else Add @endif Bill</h3>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @error('category_id') has-error @enderror">
                                        <label for="category_id" class="with-help">Stock Category*</label>
                                        <select class="form-control select2" id="category_id" name="category_id" v-model="product.category_id" required>
                                            @foreach($categoryData as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>

                                                @if(!empty($cat->nested))
                                                    @foreach($cat->nested as $nc)
                                                        <option value="{{ $nc->id }}">&nbsp;&nbsp;-- {{ $nc->category_name }}</option>
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
                                <div class="col-md-6">
                                    <div class="form-group @error('bill_date') has-error @enderror">
                                        <label class="with-help">Billing Date</label>
                                        <input class="form-control" placeholder="Item Name" name="bill_date" value="{{old('bill_date')}}" type="date" required>
                                        @error('bill_date')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @error('shop_info') has-error @enderror">
                                        <label class="with-help">Shop Info</label>
                                        <input class="form-control" placeholder="Name" name="shop_info" value="{{old('shop_info')}}" type="text" required>
                                        @error('shop_info')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group @error('invoice_number') has-error @enderror">
                                        <label class="with-help">Invoice No*</label>
                                        <input class="form-control" placeholder="Name" name="invoice_number" value="{{old('invoice_number')}}" type="text" required>
                                        @error('invoice_number')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @error('invoice_date') has-error @enderror">
                                        <label class="with-help">Invoice Date</label>
                                        <input class="form-control" placeholder="Name" name="name" value="{{old('invoice_date')}}" type="text" required>
                                        @error('invoice_date')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group @error('item_name') has-error @enderror">
                                        <label class="with-help">Item Name*</label>
                                        <input class="form-control" placeholder="Name" name="item_name" value="{{old('item_name')}}" type="text" required>
                                        @error('item_name')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @error('subject') has-error @enderror">
                                        <label class="with-help">Subject</label>
                                        <input class="form-control" placeholder="Name" name="subject" value="{{old('subject')}}" type="text" required>
                                        @error('subject')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group @error('quantity') has-error @enderror">
                                        <label class="with-help">Qty</label>
                                        <input class="form-control" placeholder="Name" name="quantity" value="{{old('quantity')}}" type="text" required>
                                        @error('quantity')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @error('name') has-error @enderror">
                                        <label for="title" class="with-help">Cost</label>
                                        <input class="form-control" placeholder="Name" name="name" value="{{old('name')}}" type="number" id="name" required>
                                        @error('name')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group @error('name') has-error @enderror">
                                        <label for="title" class="with-help">Location</label>
                                        <input class="form-control" placeholder="Name" name="name" value="{{old('name')}}" type="text" id="name" required>
                                        @error('name')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @error('name') has-error @enderror">
                                        <label for="title" class="with-help">Assign To</label>
                                        <select class="form-control" id="category_id" name="category_id" required>
                                            <option value="">Borna</option>
                                            <option value="">Rasel</option>
                                        </select>
                                        @error('name')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group @error('name') has-error @enderror">
                                        <label for="title" class="with-help">QR Code</label>
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
                    </div>
                    <p class="help-block">* Required Fields.</p>
                    <div class="text-right form-footer">
                        <button class="button delete" type="reset">Clear</button>
                        <button class="button save" type="submit">Save</button>
                    </div>
                </div>
        </form>
    </section>
@endsection
