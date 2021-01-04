@extends('layouts.backend')

@section('title')
    @if(isset($inventory)) Edit @else Create @endif | Inventory
@endsection

@section('content')
    <section class="content">
        <form method="POST" action="{{ isset($inventory) ? route('admin.inventories.update', $inventory->id) : route('admin.inventories.store') }}" accept-charset="UTF-8" id="create-edit-form" data-toggle="validator" enctype="multipart/form-data" novalidate="true">
            @csrf
            {!! (isset($inventory))?'<input name="_method" type="hidden" value="PUT">':'' !!}
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <h3 class="box-title">@if(isset($inventory)) Edit @else Add @endif Inventory
                        <a href="{{ route('admin.inventories.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> Back to List</a>
                    </h3>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @error('asset_code ') has-error @enderror">
                                        <label class="with-help">Asset Code*</label>
                                        <input class="form-control" placeholder="Asset Code" name="asset_code" value="{{old('asset_code ')}}" type="text" v-model="inventory.asset_code" required>
                                        @error('asset_code ')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group @error('description') has-error @enderror">
                                        <label class="with-help">Description</label>
                                        <input class="form-control" placeholder="Description" name="description" value="{{old('description')}}" v-model="inventory.description" type="text">
                                        @error('description')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @error('voucher_no') has-error @enderror">
                                        <label class="with-help">Voucher No</label>
                                        <input class="form-control" placeholder="Voucher No" name="voucher_no" value="{{old('voucher_no')}}" v-model="inventory.voucher_no" type="text">
                                        @error('voucher_no')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group @error('purchase_date') has-error @enderror">
                                        <label class="with-help">Purchase Date*</label>
                                        <input class="form-control" placeholder="Purchase Date" name="purchase_date" value="{{old('purchase_date')}}" v-model="inventory.purchase_date" type="date" required>
                                        @error('purchase_date')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @error('qty') has-error @enderror">
                                        <label class="with-help">Qty</label>
                                        <input class="form-control" placeholder="Qty" name="qty" value="{{old('qty')}}" v-model="inventory.qty" type="number">
                                        @error('qty')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group @error('cost') has-error @enderror">
                                        <label for="cost" class="with-help">Cost</label>
                                        <input class="form-control" placeholder="Cost" name="cost" value="{{old('cost')}}" v-model="inventory.cost" type="number" id="cost">
                                        @error('cost')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @error('category_id') has-error @enderror">
                                        <label for="category_id" class="with-help">Asset Category*</label>
                                        <select class="form-control select2" id="category_id" name="category_id" v-model="inventory.category_id" v-select2 required>
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
                                    <div class="form-group @error('location') has-error @enderror">
                                        <label for="location" class="with-help">location*</label>
                                        <select class="form-control select2" id="location" name="location" v-model="inventory.location" v-select2>
                                            <option value="hq" {{(isset($inventory->location)?$inventory->location:old('location') == 'hq') ? 'Selected' : ''}}>Head Quarter</option>
                                            <option value="gs1" {{(isset($inventory->location)?$inventory->location:old('location') == 'gs1') ? 'Selected' : ''}}>GS Gazipur </option>
                                            <option value="gs2" {{(isset($inventory->location)?$inventory->location:old('location') == 'gs2') ? 'Selected' : ''}}>GS Bethbunia </option>
                                        </select>
                                        @error('name')
                                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="with-help">Assign To</label>
                                </div>
                                <label class="radio-inline">
                                    <input type="radio" value="user" v-model="inventory.assign_to" name="assign_to" {{ old('assign_to') == 'user' ? 'checked' : '' }}>User
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" value="department" v-model="inventory.assign_to" name="assign_to" {{ old('assign_to') == 'department' ? 'checked' : '' }}>Department
                                </label>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6" v-show="inventory.assign_to == 'user'">
                                    <div class="form-group @error('user_id') has-error @enderror">
                                        <label for="user_id" class="with-help">User</label>
                                        <select class="form-control select2" id="user_id" name="user_id" v-model="inventory.user_id" v-select2>
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
                                <div class="col-md-6" v-show="inventory.assign_to == 'department'">
                                    <div class="form-group @error('dept_id') has-error @enderror">
                                        <label for="dept_id" class="with-help">Department</label>
                                        <select class="form-control select2" id="dept_id" name="dept_id" v-model="inventory.dept_id" v-select2>
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

@push('scripts')
    <script>
        new Vue({
            el: '#app',
            data: {
                inventory: {
                    assign_to: '{{ old('assign_to  ', $inventory->assign_to ?? '') }}',
                    asset_code: '{{ old('asset_code  ', $inventory->asset_code ?? '') }}',
                    description: '{{ old('description', $inventory->description ?? '') }}',
                    category_id: '{{ old('category_id ', $inventory->category_id  ?? '') }}',
                    user_id: '{{ old('user_id ', $inventory->user_id  ?? '') }}',
                    dept_id: '{{ old('dept_id ', $inventory->dept_id  ?? '') }}',
                    voucher_no: '{{ old('voucher_no', $inventory->voucher_no ?? '') }}',
                    qty: '{{ old('qty', $inventory->qty ?? '') }}',
                    cost: '{{ old('cost', $inventory->cost ?? '') }}',
                    location: '{{ old('location', $inventory->location ?? '') }}',
                    purchase_date: '{{ old('purchase_date', $inventory->purchase_date ?? '') }}',
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
