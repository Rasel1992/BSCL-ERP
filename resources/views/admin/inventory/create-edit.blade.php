@extends('layouts.backend')

@section('title')
    @if(isset($inventory)) Edit @else Create @endif | Inventory
@endsection

@section('content')
    <section class="content">
        <form method="POST" action="{{ isset($inventory) ? route('admin.inventories.update', $inventory->id) : route('admin.inventories.store') }}{{ qString() }}" accept-charset="UTF-8" id="create-edit-form" data-toggle="validator" enctype="multipart/form-data" novalidate="true">
            @csrf
            @if (isset($inventory))
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <h3 class="box-title">@if(isset($inventory)) Edit @else Add @endif Inventory
                        <a href="{{ route('admin.inventories.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> List of Inventory</a>
                    </h3>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('asset_code') has-error @enderror">
                                            <label class="col-md-3">Asset Code<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Asset Code" name="asset_code" value="{{old('asset_code')}}" type="text" v-model="inventory.asset_code" required>
                                                @error('asset_code')
                                                <span class="help-block">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row @error('assign_date') has-error @enderror">
                                            <label class="col-md-3">Assign Date<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Assign Date" name="assign_date" value="{{old('assign_date')}}" v-model="inventory.assign_date" type="date" required>
                                                @error('assign_date')
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
                                        <div class="form-group row @error('voucher_no') has-error @enderror">
                                            <label class="col-md-3">Voucher No</label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Voucher No" name="voucher_no" value="{{old('voucher_no')}}" v-model="inventory.voucher_no" type="text">
                                                @error('voucher_no')
                                                <span class="help-block">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row @error('purchase_date') has-error @enderror">
                                            <label class="col-md-3">Purchase Date<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Purchase Date" name="purchase_date" value="{{old('purchase_date')}}" v-model="inventory.purchase_date" type="date" required>
                                                @error('purchase_date')
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
                                            <label class="col-md-3">Qty</label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Qty" name="qty" value="{{old('qty')}}" v-model="inventory.qty" type="number">
                                                @error('qty')
                                                <span class="help-block">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row @error('cost') has-error @enderror">
                                            <label for="cost" class="col-md-3">Cost</label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Cost" name="cost" value="{{old('cost')}}" v-model="inventory.cost" type="number" id="cost">
                                                @error('cost')
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
                                        <div class="form-group row @error('category_id') has-error @enderror">
                                            <label for="category_id" class="col-md-3">Asset Category<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <select class="form-control select2" id="category_id" name="category_id" v-model="inventory.category_id" v-select2 required>
                                                    <option value="">Select Category</option>
                                                    @foreach($categoryData as $cat)
                                                        <option value="{{ $cat->id }}" disabled>{{ $cat->category_name }}</option>
                                                        @if(!empty($cat->nested))
                                                            @foreach($cat->nested as $nc)
                                                                <option value="{{ $nc->id }}" {{ old('category_id') == $nc->id ? 'selected' : '' }}>-- {{ $nc->category_name }}</option>
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
                                        <div class="form-group row @error('location') has-error @enderror">
                                            <label for="location" class="col-md-3">location<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <select class="form-control select2" id="location" name="location" v-model="inventory.location" v-select2 required>
                                                    <option value="">Select Location</option>
                                                    <option value="hq" {{(isset($inventory->location)?$inventory->location:old('location') == 'hq') ? 'Selected' : ''}}>Head Quarter
                                                    </option>
                                                    <option value="gs1" {{(isset($inventory->location)?$inventory->location:old('location') == 'gs1') ? 'Selected' : ''}}>GS Gazipur
                                                    </option>
                                                    <option value="gs2" {{(isset($inventory->location)?$inventory->location:old('location') == 'gs2') ? 'Selected' : ''}}>GS Bethbunia
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
                                </div>

                                <div class="col-md-12">
                                    <div class="col-sm-6">
                                        <div class="form-group @error('assign_to') has-error @enderror">
                                            <div class="row">
                                                <label class="col-md-3" for="input-type">Assign To<span class="text-danger">*</span></label>
                                                @error('assign_to')
                                                <span class="help-block">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                                <div class="col-md-8">
                                                    <div id="input-type" class="row">
                                                        <div class="col-sm-4">
                                                            <label class="radio-inline">
                                                                <input type="radio" value="user" v-model="inventory.assign_to" name="assign_to" {{ old('assign_to') == 'user' ? 'checked' : '' }}>User
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label class="radio-inline">
                                                                <input type="radio" value="department" v-model="inventory.assign_to" name="assign_to" {{ old('assign_to') == 'department' ? 'checked' : '' }}>Department
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-md-12">
                                        <div class="col-md-6" v-show="inventory.assign_to == 'user'">
                                            <div class="form-group row @error('user_id') has-error @enderror">
                                                <label for="user_id" class="col-md-3">User</label>
                                                <div class="col-md-8">
                                                    <select class="form-control select2" id="user_id" name="user_id" v-model="inventory.user_id" v-select2>
                                                        <option value="">Select User</option>
                                                        @foreach($users as $user)
                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('user_id')
                                                    <span class="help-block">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" v-show="inventory.assign_to == 'department'">
                                            <div class="form-group row @error('dept_id') has-error @enderror">
                                                <label for="dept_id" class="col-md-3">Department</label>
                                                <div class="col-md-8">
                                                    <select class="form-control select2" id="dept_id" name="dept_id" v-model="inventory.dept_id" v-select2>
                                                        <option value="">Select Department</option>
                                                        @foreach($departments as $department)
                                                            <option value="{{$department->id}}">{{$department->department}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('dept_id')
                                                    <span class="help-block">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row @error('description') has-error @enderror">
                                            <label class="col-md-3">Description</label>
                                            <div class="col-md-8">
                                                <textarea class="form-control" placeholder="Description" name="description" value="{{old('description')}}" cols="5" rows="10" v-model="inventory.description" type="text"></textarea>
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
                inventory: {
                    assign_to: '{{ old('assign_to', $inventory->assign_to ?? '') }}',
                    asset_code: '{{ old('asset_code', $inventory->asset_code ?? '') }}',
                    description: '{{ old('description', $inventory->description ?? '') }}',
                    category_id: '{{ old('category_id', $inventory->category_id  ?? '') }}',
                    user_id: '{{ old('user_id', $inventory->user_id  ?? '') }}',
                    dept_id: '{{ old('dept_id', $inventory->dept_id  ?? '') }}',
                    voucher_no: '{{ old('voucher_no', $inventory->voucher_no ?? '') }}',
                    qty: '{{ old('qty', $inventory->qty ?? '') }}',
                    cost: '{{ old('cost', $inventory->cost ?? '') }}',
                    location: '{{ old('location', $inventory->location ?? '') }}',
                    purchase_date: '{{ old('purchase_date', $inventory->purchase_date ?? '') }}',
                    assign_date: '{{ old('assign_date', $inventory->assign_date ?? '') }}',
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
