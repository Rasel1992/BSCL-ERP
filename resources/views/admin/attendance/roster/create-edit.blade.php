@extends('layouts.backend')

@section('title')
    @if(isset($roster)) Edit @else Create  @endif | Rosters
@endsection

@section('content')
    <section class="content">
        <form method="POST" action="{{ isset($roster) ? route('admin.rosters.update', $roster->id) : route('admin.rosters.store') }}" accept-charset="UTF-8" id="create-edit-form" data-toggle="validator" enctype="multipart/form-data" novalidate="true">
            @csrf
            @if (isset($roster))
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <h3 class="box-title">@if(isset($roster)) Edit @else Add @endif Rosters <a href="{{ route('admin.rosters.index') }}" class="btn btn-info pull-right">List of Rosters</a></h3>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('user_id') has-error @enderror">
                                            <label class="col-md-2">User<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <?php $user_id = (isset($roster->user_id)) ? $roster->user_id : old('user_id'); ?>
                                                <select name="user_id[]" class="form-control select2" multiple required>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}" {{ ($user_id==$user->id)?'selected':'' }}>{{ $user->name }}</option>
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
                                    <div class="col-md-6">
                                        <div class="form-group row @error('day') has-error @enderror">
                                            <label class="col-md-2" for="type">Day<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <select class="form-control select2" id="day" name="day[]" multiple required>
                                                    @php ($typ = old('day', isset($roster) ? $roster->day : ''))
                                                    @foreach(['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $type)
                                                        <option value="{{ $type }}" {{ ($type==$typ)?'selected':''}}>{{ $type }}</option>
                                                    @endforeach
                                                </select>
                                                @error('day')
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
                                        <div class="form-group row @error('roster_date') has-error @enderror">
                                            <label class="col-md-2">Date<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Roster Date" name="roster_date" value="{{ old('roster_date', isset($roster) ? $roster->roster_date : '') }}" type="date" required>
                                                @error('roster_date')
                                                <span class="help-block">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h4 class="text-center with-border">Shifts<span class="text-danger">*</span></h4>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group @error('shift_id') has-error @enderror">
                                        <div class="row">
                                            @foreach($shifts as $key => $value)
                                                <div class="col-md-4">
                                                    <label for="shift_id" class="with-help">{{ $value->name }}({{ $value->total_hours }} Hours)</label><br>
                                                    @php ($shift = old('shift_id', isset($roster) ? $roster->shift_id : ''))
                                                    <label> <input type="checkbox" name="shift_id[]" value="{{ $value->id }}" @if(isset($roster)){{ ($shift==$value->id)?'checked':''}} @endif>&nbsp {{ $value->from }}- {{ $value->to }}</label>
                                                </div>
                                            @endforeach
                                            @error('shift_id')
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

@endpush
