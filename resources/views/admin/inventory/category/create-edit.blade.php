@extends('layouts.backend')

@section('title')
    @if(isset($category)) Edit @else Create @endif
@endsection

@section('content')
    <section class="content">
        <form method="POST" action="{{ isset($category) ? route('admin.inventory-category.update', $category->id) : route('admin.inventory-category.store') }}" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            {!! (isset($category))?'<input name="_method" type="hidden" value="PUT">':'' !!}
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <h3 class="box-title">@if(isset($category))Edit @else Add @endif Category<a href="{{ route('admin.inventory-category.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> Back to List</a>
                    </h3>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('parent_id') has-error @enderror">
                                            <label class="col-md-3">Select Category<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <?php $parent_id = (isset($category->parent_id)) ? $category->parent_id : old('parent_id'); ?>
                                                <select name="parent_id" id="parent_id" class="form-control select2" onchange="displayCode();" onkeyup="displayCode();" v-select2 required>
                                                    <option value="0">No Category</option>
                                                    @foreach($categoryData as $cat)
                                                        <option value="{{ $cat->id }}" {{ ($parent_id==$cat->id)?'selected':'' }}>{{ $cat->category_name }}</option>

                                                        @if(!empty($cat->nested))
                                                            @foreach($cat->nested as $nc)
                                                                <option value="{{ $nc->id }}" {{ ($parent_id==$nc->id)?'selected':'' }} disabled>&nbsp;&nbsp;-- {{ $nc->category_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('parent_id')
                                                <span class="help-block">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row @error('category_name') has-error @enderror">
                                            <label class="col-md-3">Category Name<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="category_name" placeholder="Category Name" value="{{ old('category_name', $category->category_name ?? '') }}" required>
                                                @error('category_name')
                                                <span class="help-block">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6" id="myDIV" {{ (isset($category) && $category->parent_id > '0') ? 'style=display:block;' : 'style=display:none;' }}>
                                        <div class="form-group row @error('category_code') has-error @enderror">
                                            <label class="col-md-3">Category Code</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="category_code" placeholder="Category Code" value="{{ old('category_code', $category->category_code ?? '') }}">
                                                @error('category_code')
                                                <span class="help-block">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row @error('type') has-error @enderror">
                                            <label class="col-md-3" for="type">Type<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <select class="form-control select2" id="type" name="type" required>
                                                    <option value="">Select Type</option>
                                                    @php ($typ = old('type', isset($category) ? $category->type : ''))
                                                    @foreach(['Fixed', 'Current'] as $type)
                                                        <option value="{{ $type }}" {{ ($type==$typ)?'selected':''}}>{{ $type }}</option>
                                                    @endforeach
                                                </select>
                                                @error('type')
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
        function displayCode() {
            var parentId = Number($('#parent_id').val());
            if (parentId > 0) {
                document.getElementById("myDIV").style.display = "block";
            } else {
                document.getElementById("myDIV").style.display = "none";
            }
        }
    </script>
@endpush
