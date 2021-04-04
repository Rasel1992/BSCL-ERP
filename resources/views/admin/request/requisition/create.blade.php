@extends('layouts.backend')

@section('title')
    Application Form
@endsection

@section('content')

    <section class="content">

        <div class="box box-info">
            <div class="box-header">
                <i class="fa fa-envelope"></i>

                <h3 class="box-title">Quick Email</h3>
                <!-- tools box -->
                <div class="pull-right box-tools">
                    <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
                <!-- /. tools -->
            </div>
            <div class="box-body">
                <form action="#" method="post">
                    <div class="form-group">
                        <select class="form-control select2" id="to" name="to">
                            <option value="">To</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date:</label>

                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control datepicker pull-right" id="datepicker">
                        </div>
                        <!-- /.input group -->
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="subject" placeholder="Subject">
                    </div>
                    <div>
                        <textarea class="form-control summernote" name="content" cols="50" rows="10" id="content"></textarea>
                    </div>
                </form>
            </div>
            <div class="box-footer clearfix">
                <button type="button" class="pull-right btn btn-default" id="sendEmail">Send
                    <i class="fa fa-arrow-circle-right"></i></button>
            </div>
        </div>
    </section>

@endsection
