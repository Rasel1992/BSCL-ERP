
@extends('layouts.backend')

@section('title')
   Assign | Stock
@endsection

@section('content')
    <section class="content">
        <form method="POST" action="{{ route('admin.assign-stock', $stock_id) }}" accept-charset="UTF-8" id="create-edit-form" data-toggle="validator" enctype="multipart/form-data" novalidate="true">
            @csrf
            <input type="hidden" name="stock_id" value="{{$stock_id}}">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h3 class="box-title">Assign Stock</h3>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="col-sm-12">
                                <div class="form-group @error('qty') has-error @enderror">
                                    <label for="title" class="with-help">Qty<span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Qty" name="qty" value="{{old('qty')}}" type="number" id="qty" required>
                                    @error('qty')
                                    <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                                    @enderror
                                </div>
                            </div>
                                <div class="col-sm-12">
                                    <div class="form-group @error('user_id') has-error @enderror">
                                        <label for="user_id" class="with-help">User<span class="text-danger">*</span></label>
                                        <select class="form-control" id="user_id" name="user_id">
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
