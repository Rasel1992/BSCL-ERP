
@extends('layouts.backend')

@section('title')
   Assign | Stock
@endsection

@section('content')
    <section class="content">
        <form method="POST" action="{{ route('admin.assign-stock', $data->id) }}" accept-charset="UTF-8" id="create-edit-form" data-toggle="validator" enctype="multipart/form-data" novalidate="true">
            @csrf
            <input type="hidden" name="stock_id" value="{{$data->id}}">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h3 class="box-title">Assign Stock
                    <a href="{{ route('admin.stocks.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> List of Stock</a>
                    </h3>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="with-help">Assign To</label>
                                </div>
                                <label class="radio-inline">
                                    <input type="radio" value="user" v-model="assignStock.assign_to" name="assign_to" {{ old('assign_to') == 'user' ? 'checked' : '' }}>User
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" value="department" v-model="assignStock.assign_to" name="assign_to" {{ old('assign_to') == 'department' ? 'checked' : '' }}>Department
                                </label>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-sm-6" v-show="assignStock.assign_to == 'user'">
                                        <div class="form-group @error('user_id') has-error @enderror">
                                            <label for="user_id" class="with-help">User</label>
                                            <select class="form-control" id="user_id" name="user_id"
                                                    v-model="assignStock.user_id">
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
                                    <div class="col-sm-6" v-show="assignStock.assign_to == 'department'">
                                        <div class="form-group @error('dept_id') has-error @enderror">
                                            <label for="dept_id" class="with-help">Department</label>
                                            <select class="form-control" id="dept_id" name="dept_id"
                                                    v-model="assignStock.dept_id">
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
                            <br>
                            <div class="col-sm-12">
                                <div class="form-group @error('qty') has-error @enderror">
                                    <label for="title" class="with-help">Qty In Stock<span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Qty" name="stock_qty" value="{{$data->qty}}" type="number" id="stock_qty" readonly>
                                    @error('qty')
                                    <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group @error('qty') has-error @enderror">
                                    <label for="title" class="with-help">Assign Qty<span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Qty" name="qty" value="{{old('qty')}}" type="number" id="qty" onchange="assignStock();" onkeyup="assignStock();" required>
                                    @error('qty')
                                    <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group @error('assign_date') has-error @enderror">
                                    <label class="with-help">Assign Date <span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Assign Date" name="assign_date" value="{{old('assign_date')}}" type="date" required>
                                    @error('assign_date')
                                    <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                    @enderror
                                </div>
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
@push('scripts')
    <script>
        new Vue({
            el: '#app',
            data: {
                assignStock: {
                    stock_id: '{{ old('stock_id  ', $inventory->stock_id ?? '') }}',
                    assign_to: '{{ old('assign_to  ', $inventory->assign_to ?? '') }}',
                    user_id: '{{ old('user_id ', $inventory->user_id  ?? '') }}',
                    dept_id: '{{ old('dept_id ', $inventory->dept_id  ?? '') }}',
                    qty: '{{ old('qty', $inventory->qty ?? '') }}',
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

        function assignStock() {
            var stockQty = Number($('#stock_qty').val());
            var qty = Number($('#qty').val());
            if (isNaN(qty)) {
                $('#stock_qty').val('');
                $('#qty').val('');
                alert('Provide a valid qty to assign!');
                return false;
            }

            if (stockQty < qty) {
                $('#qty').val('');
                alert('Qty not in stock!!');
            }
        }
    </script>
@endpush
