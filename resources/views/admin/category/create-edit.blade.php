@extends('layouts.backend')

@section('title')
    @if(isset($category)) Edit @else Create @endif
@endsection

@section('content')
    <section class="content">
        <form method="POST" action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            {!! (isset($category))?'<input name="_method" type="hidden" value="PUT">':'' !!}
            <div class="row">
                <div class="col-md-3 col-lg-3"></div>
                <div class="col-md-6 col-lg-6">
                    <h3 class="box-title">@if(isset($category))Edit @else Add @endif Category<a href="{{ route('admin.categories.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> Back to List</a>
                    </h3>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="form-group @error('type') has-error @enderror">
                                    <label for="sex">Type</label>
                                    <select class="form-control select2" id="type" name="type">
                                            @php ($typ = old('type', isset($category) ? $category->type : ''))
                                            @foreach(['Fixed', 'Current', 'Stock'] as $type)
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
                            <div class="col-md-12">
                                <div class="form-group @error('parent_id') has-error @enderror">
                                    <label class="required">Select Category*</label>
                                    <div class="">
                                        <?php $parent_id = (isset($category->parent_id)) ? $category->parent_id : old('parent_id'); ?>
                                        <select name="parent_id" class="form-control select2" v-select2 required>
                                            <option value="0">No Category</option>
                                            @foreach($categoryData as $cat)
                                                <option value="{{ $cat->id }}" {{ ($parent_id==$cat->id)?'selected':'' }}>{{ $cat->category_name }}</option>

                                                @if(!empty($cat->nested))
                                                    @foreach($cat->nested as $nc)
                                                        <option value="{{ $nc->id }}" {{ ($parent_id==$nc->id)?'selected':'' }}>&nbsp;&nbsp;-- {{ $nc->category_name }}</option>
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
                            <div class="col-md-12">
                                <div class="form-group @error('category_name') has-error @enderror">
                                    <label class="required">Category Name*</label>
                                    <div class="">
                                        <input type="text" class="form-control" name="category_name" placeholder="Category Name" value="{{ isset($category->category_name)?$category->category_name:old('category_name') }}" required>
                                        @error('category_name')
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
                <div class="col-md-3 col-lg-3"></div>
            </div>
        </form>
    </section>
@endsection
@push('scripts')
    <script>
        new Vue({
            el: '#app',
            data: {
                isEdit: false,
                category: {
                    parent_id: ''
                }
            }
        })
    </script>
@endpush
