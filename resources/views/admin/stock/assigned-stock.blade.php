@extends('layouts.backend')

@section('title')
    Assigned Stocks
@endsection

@section('content')
    <section class="content">
        <div class="panel">
            <div class="box-header with-border">
                <h3 class="box-title">Assigned Stocks</h3>
                <a href="{{ route('admin.stocks.index') }}" class="btn btn-info pull-right"><i class="fa fa-angle-double-up"></i> List of Stock</a>
            </div> <!-- /.box-header -->
            <div class="panel-body">
                <table class="table table-hover table-2nd-no-sort" id="file_export">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Stock Category</th>
                        <th>Assign To</th>
                        <th>Qty</th>
                        <th>Remaining Qty In Stock</th>
                        <th>Location</th>
                        <th>Assign Date</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($assignedStocks as  $key => $stock)
                        <tr>
                            <td> {{$key + $assignedStocks->firstItem()}}</td>
                            <td> {{ $stock->stock->category->category_name }}</td>
                            <td> {{ $stock->user->name }}</td>
                            <td> {{ $stock->qty }}</td>
                            <td> {{ $stock->stock->qty }}</td>
                            <td> {{ $stock->stock->location }}</td>
                            <td> {{ $stock->assign_date }} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $assignedStocks->appends(Request::except('page'))->links() }}
            </div> <!-- /.box-body -->
        </div> <!-- /.box -->
    </section>
@endsection

@push('scripts')
    <script>
        new Vue({
            el: '#app',
            methods: {
                destroy: function () {
                    const $this = $(event.target);

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            $this.closest('form').submit();
                        }
                    });
                }
            }
        })
    </script>
@endpush

