@extends('layouts.backend')

@section('title')
    Requisition | Form
@endsection

@section('styles')
   <style>
       .file-up {

           width: 100%;
           height: 100%;
           display: flex;
           align-items: center;
           justify-content: center;
       }

       .content-text {
           justify-content: center;
       }

       .file-upload {
           height: 30px;
           width: 30px;
           border-radius: 50px;
           position: relative;
           display: flex;
           justify-content: center;
           align-items: center;
           border: 4px solid #FFFFFF;
           overflow: hidden;
           background-image: linear-gradient(to bottom, #2590EB 50%, #FFFFFF 50%);
           background-size: 100% 200%;
           transition: all 1s;
           color: #FFFFFF;
           font-size: 20px;
       }

       input[type='file'] {
           height: 200px;
           width: 200px;
           position: absolute;
           top: 0;
           left: 0;
           opacity: 0;
           cursor: pointer;

       }

   </style>
@endsection

@section('content')

    <section class="content">

        <div class="box box-info">
            <div class="box-header">
                <i class="fa fa-envelope"></i>

                <h3 class="box-title">Requisition Form</h3>
                <!-- tools box -->
                <div class="pull-right box-tools">
                    <a href="{{ route('admin.request.requisition.index') }}" class="btn btn-info pull-right">Back to list</a>
                </div>
                <!-- /. tools -->
            </div>
            <div class="box-body">
                <form action="{{route('admin.request.requisition.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            Requisition SL No. :
                                        </div>
                                        @php $randomNum=substr(str_shuffle("0123456789"), 0, 2); @endphp

                                        <input type="text" class="form-control" name="requisition_by" value="{{$randomNum}}" readonly>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            Requisition By :
                                        </div>
                                        <input type="text" class="form-control" name="requisition_by" value="{{Auth::user()->name}}" readonly>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            Requisition To :
                                        </div>
                                        <select class="form-control" id="requisition_to" name="requisition_to">
                                            <option value="">Select</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            Actual User :
                                        </div>
                                        <input type="text" class="form-control" name="actual_user" value="{{old('actual_user')}}">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            Designation :
                                        </div>
                                        <input type="text" class="form-control" name="designation" value="{{Auth::user()->designation}}" readonly>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            Department :
                                        </div>
                                        <input type="text" class="form-control" name="dept" value="{{Auth::user()->departments->department}}" readonly>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            Date :
                                        </div>
                                        <input type="date" class="form-control" name="requisition_date" value="{{date('Y-m-d')}}" readonly>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="box-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Sl. No</th>
                                    <th>Item Code</th>
                                    <th>Particulars</th>
                                    <th>Quantity</th>
                                    <th>Disbursement</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(field, index) in requisition.fields">
                                    <td><input type="number" step="any" min="1" class="form-control" name="s_no[]" v-model="field.s_no" id="s_no" value="" required></td>
                                    <td><input type="text" step="any" min="1" class="form-control" name="item_code[]" v-model="field.item_code" id="item_code" value="" required></td>
                                    <td><input type="text" step="any" min="1" class="form-control" name="particulars[]" v-model="field.particulars" id="particulars" value="" required></td>
                                    <td><input type="number" step="any" min="1" class="form-control" name="qty[]" v-model="field.qty" id="qty" value="" required></td>
                                    <td><input type="text" step="any" min="1" class="form-control" name="disbursement[]" v-model="field.disbursement" id="disbursement" value="" required></td>
                                    <td><a v-if="requisition.fields.length > 1" class="pull-right" href="javascript:void(0)" @click="requisition.fields.splice(index, 1)"><i class="fa fa-times"></i></a> <span v-else>&nbsp;</span></td>
                                </tr>
                                <tr>
                                    <td><button class="btn btn-success" type="button" @click="addFields"><i class="fa fa-plus"></i></button></td>
                                    <td colspan="5"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-1"></div>&nbsp;
                            <div class="col-md-2">
                                @if(isset(Auth::user()->signature))
                                    {!! viewImg('user/signature', Auth::user()->signature, ['class' => 'thumbnail', 'style' => 'width:100px; height:30px;']) !!}
                                @else
                                <div class="file-up">
                                    <div class="file-upload">
                                        <input type="file" />
                                        <i class="fa fa-arrow-up"></i>
                                    </div>
                                </div>
                                @endif

                                <hr>
                                <label>Requisitioned By</label>
                            </div> &nbsp;
                            <div class="col-md-2">
                                <div class="file-up">
                                    <div class="file-upload">
                                        <input disabled type="file" />
                                        <i class="fa fa-arrow-up"></i>
                                    </div>
                                </div>
                                <hr>
                                <label>Verified By Wing</label>
                            </div>&nbsp;
                            <div class="col-md-2">
                                <div class="file-up">
                                    <div class="file-upload">
                                        <input disabled type="file" />
                                        <i class="fa fa-arrow-up"></i>
                                    </div>
                                </div>
                                <hr>
                                <label>Approved By</label>
                            </div>&nbsp;
                            <div class="col-md-2">
                                <div class="file-up">
                                    <div class="file-upload">
                                        <input disabled type="file" />
                                        <i class="fa fa-arrow-up"></i>
                                    </div>
                                </div>
                                <hr>
                                <label>Received By</label>
                            </div>&nbsp;
                            <div class="col-md-2">
                                <div class="file-up">
                                    <div class="file-upload">
                                        <input disabled type="file" />
                                        <i class="fa fa-arrow-up"></i>
                                    </div>
                                </div>
                                <hr>
                                <label class="">Disbursed By</label>
                            </div>&nbsp;
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                    <div class="box-footer clearfix">
                        <button type="submit" class="pull-right btn btn-success">Send
                            <i class="fa fa-arrow-circle-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script>
        new Vue({
            el: '#app',
            data: {
                isEdit: false,
                requisition: {
                    fields: [{
                        s_no: '',
                        item_code: '',
                        particulars: '',
                        qty: '',
                        disbursement: '',
                    }]
                }
            },
            methods: {
                addFields: function () {
                    this.requisition.fields.push({
                        s_no: '',
                        item_code: '',
                        particulars: '',
                        qty: '',
                        disbursement: '',
                    });
                }
            }
        })
    </script>
@endpush
