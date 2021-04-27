@extends('layouts.backend')

@section('title')
    @if(isset($shift)) Edit @else Create  @endif | Shift
@endsection

@section('content')
    <section class="content">
        <form method="POST" action="{{ isset($shift) ? route('admin.shifts.update', $shift->id) : route('admin.shifts.store') }}" accept-charset="UTF-8" id="create-edit-form" data-toggle="validator" enctype="multipart/form-data" novalidate="true">
            @csrf
            @if (isset($shift))
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <h3 class="box-title">@if(isset($shift)) Edit @else Add @endif Shift <a href="{{ route('admin.shifts.index') }}" class="btn btn-info pull-right">List of Shift</a></h3>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('name') has-error @enderror">
                                            <label class="col-md-2">Name<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Shift Name" name="name" value="{{ old('name', isset($shift) ? $shift->name : '') }}" type="text" required>
                                                @error('name')
                                                <span class="help-block">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="bootstrap-timepicker">
                                            <div class="form-group row @error('from') has-error @enderror">
                                                <label class="col-md-2">From<span class="text-danger">*</span></label>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control timepicker" name="from" id="from" value="{{ old('from', isset($shift) ? $shift->from : '') }}" required>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-clock-o"></i>
                                                        </div>
                                                        @error('from')
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
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group row @error('total_hours') has-error @enderror">
                                            <label class="col-md-2">Hours<span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" placeholder="Hours" name="total_hours" id="total_hours" value="{{ old('total_hours', isset($shift) ? $shift->total_hours : '') }}" type="text" required>
                                                @error('total_hours')
                                                <span class="help-block">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="bootstrap-timepicker">
                                            <div class="form-group row @error('to') has-error @enderror">
                                                <label class="col-md-2">To<span class="text-danger">*</span></label>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control timepicker" name="to" id="to" value="{{ old('to', isset($shift) ? $shift->to : '') }}" required>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-clock-o"></i>
                                                        </div>
                                                        @error('to')
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
    <script type="text/javascript">

        $(document).ready(function () {
            function calculateHours() {
                var startTime = $('#from').val();
                var endTime = $('#to').val();

                var todayDate = moment(new Date()).format("MM-DD-YYYY");

                var startDate = new Date(`${todayDate} ${startTime}`);
                var endDate = new Date(`${todayDate} ${endTime}`);
                var timeDiff = Math.abs(startDate.getTime() - endDate.getTime());

                var hh = Math.floor(timeDiff / 1000 / 60 / 60);
                hh = ('0' + hh).slice(-2)

                timeDiff -= hh * 1000 * 60 * 60;
                var mm = Math.floor(timeDiff / 1000 / 60);
                mm = ('0' + mm).slice(-2)

                timeDiff -= mm * 1000 * 60;
                var ss = Math.floor(timeDiff / 1000);
                ss = ('0' + ss).slice(-2)

                document.getElementById('total_hours').value = +hh + ":" + mm + ":" + ss;
            }

            $("#from").change(calculateHours).keypress(calculateHours);
            $("#to").change(calculateHours).keypress(calculateHours);
        });
    </script>
@endpush
