<!DOCTYPE html>
<html>

<!-- Mirrored from adminlte.io/themes/AdminLTE/index2.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Aug 2020 05:07:29 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/backend.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote.min.css') }}">
    <!-- Vue -->
    <script src="{{ asset('assets/plugins/vue/vue.min.js') }}"></script>

    <!-- select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <!-- toastr -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote.min.css') }}">

    <!-- Data table -->
    <link href="{{ asset('assets/plugins/data-tables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <!-- datetimepicker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datetimepicker/jquery.datetimepicker.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @yield('styles')
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

    <header class="main-header">

        <!-- Logo -->
        <a href="#" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>B</b>E</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>{{ config('app.name') }}</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            @if(Auth::user()->image)
                                {!! viewImg('user', Auth::user()->image, ['thumb' => 1, 'class' => 'user-image', 'style' => 'width:40px; height:40px;']) !!}
                            @else
                                <img src="{{asset('assets/dist/img/user2-160x160.jpg') }}" class="user-image" alt="{{ Auth::user()->name }}">
                            @endif
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                @if(Auth::user()->image)
                                    {!! viewImg('user', Auth::user()->image, ['thumb' => 1, 'class' => 'img-circle', 'style' => 'width:40px; height:40px;']) !!}
                                @else
                                    <img src="{{asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="{{ Auth::user()->name }}">
                                @endif

                                <p>
                                    {{ Auth::user()->name }}
                                    <small>{{ Auth::user()->email }}</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('admin.profile') }}" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Sign out
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    @if(Auth::user()->image)
                        {!! viewImg('user', Auth::user()->image, ['thumb' => 1, 'class' => 'img-circle', 'style' => 'width:40px; height:40px;']) !!}
                    @else
                        <img src="{{asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="{{ Auth::user()->name }}">
                    @endif
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li @if(request()->is('admin/dashboard')) class="active" @endif>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-files-o"></i>
                        <span>HRM</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('admin.departments.index')}}"><i class="fa fa-user-secret"></i> Departments</a></li>
                        <li><a href="{{route('admin.users.index')}}"><i class="fa fa-users"></i> User</a></li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-bar-chart"></i>
                                <span>Request</span>
                                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('admin.request.requisition.create') }}"><i class="fa fa-clock-o"></i> Requisition</a></li>
                                <li><a href="pages/charts/morris.html"><i class="fa fa-plane"></i> Leave Application</a></li>
                                <li><a href="pages/charts/flot.html"><i class="fa fa-cc-mastercard"></i> Advance Money</a></li>
                            </ul>
                        </li>
                        <li><a href="pages/layout/fixed.html"><i class="fa fa-plane"></i> Leave Management</a></li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-file-text"></i>
                                <span>Attendance</span>
                                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/charts/chartjs.html"><i class="fa fa-clock-o"></i> Time History</a></li>
                                <li><a href="pages/charts/morris.html"><i class="fa fa-calendar-o"></i> Timechange Request</a></li>
                                <li><a href="pages/charts/flot.html"><i class="fa fa-file-text"></i> Attendance Report</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-indent"></i> Set Roster</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-dribbble"></i>
                                <span>Performance</span>
                                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/charts/chartjs.html"><i class="fa fa-random"></i> Indicator</a></li>
                                <li><a href="pages/charts/morris.html"><i class="fa fa-plus"></i> Give Appraisal</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-calendar-o"></i> Performance Report</a></li>
                            </ul>
                        </li>
                        <li><a href="pages/layout/fixed.html"><i class="fa fa-suitcase"></i>Training</a></li>
                        <li><a href="pages/layout/fixed.html"><i class="fa fa-bullhorn icon"></i>Notice Board</a></li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-usd"></i>
                                <span>Payroll</span>
                                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/charts/chartjs.html"><i class="fa fa-money"></i> Salary Template</a></li>
                                <li><a href="pages/charts/morris.html"><i class="fa fa-clock-o"></i> Hourly Template</a></li>
                                <li><a href="pages/charts/flot.html"><i class="fa fa-usd"></i> Manage Salary</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-user-secret"></i>Employee Salary List</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-tasks"></i>Make Payment</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-list-ul"></i>Generate Payslip</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-camera-retro"></i>Payroll Summary</a></li>
                            </ul>
                        </li>
                        <li><a href="pages/layout/fixed.html"><i class="fa fa-briefcase"></i>Provident Fund</a></li>
                        <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-trophy"></i> Employee Award</a></li>
                        <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-tasks"></i> Tasks</a></li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-ticket"></i>
                                <span>Tickets</span>
                                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> Answered</a></li>
                                <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Open</a></li>
                                <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> In Progress</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Closed</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-ticket"></i> All Tickets</a></li>
                            </ul>
                        </li>
                        <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-envelope-o"></i> Mailbox</a></li>
                        <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-calendar-plus-o"></i> Holiday</a></li>
                        <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-cc-mastercard"></i> Advance Salary</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-pie-chart"></i>
                        <span>Accounts</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-building-o"></i>
                                <span>Transactions</span>
                                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> Expense</a></li>
                                <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Deposit</a></li>
                                <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Transfer</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Transactions Report</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Balance Sheet</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Transfer Report</a></li>

                            </ul>
                        </li>
                        <li><a href="pages/charts/inline.html"><i class="fa fa-money"></i> Bank &amp; Cash</a></li>
                        <li><a href="pages/charts/chartjs.html"><i class="fa fa-users"></i> Client</a></li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Sales</span>
                                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
                                <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Recurring Invoice</a></li>
                                <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Estimates</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Payments Received</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Tax Rates</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Report</a></li>


                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Sales</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Invoice</span>
                                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
                                <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Recurring Invoice</a></li>
                                <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Estimates</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Payments Received</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Tax Rates</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Report</a></li>


                            </ul>
                        </li>
                        <li><a href="pages/charts/inline.html"><i class="fa fa-cube"></i> Item</a></li>


                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-codepen"></i>
                        <span>Stock & Inventory</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('admin.categories.index')}}"><i class="fa fa-sliders"></i> Category</a></li>
                        <li><a href="{{route('admin.inventories.index')}}"><i class="fa fa-sliders"></i> Inventory</a></li>
                        <li><a href="{{route('admin.bills.index')}}"><i class="fa fa-sliders"></i> Bill Register</a></li>
                        <li><a href="{{route('admin.stocks.index')}}"><i class="fa fa-sliders"></i> Stock</a></li>
                        <li><a href="{{route('admin.stocks.assigned-stock')}}"><i class="fa fa-sliders"></i> Assigned Stock</a></li>
                    </ul>
                </li>


            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="app">

    @yield('content')

    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            Developed by <strong><a href="https://2bitsoft.com/" target="_blank">2 Bit Soft</a></strong>
        </div>
        <strong>
            Copyright &copy; {{ date('Y') }} <a href="http://www.bcscl.com.bd/" target="_blank">BSCL</a>.
        </strong> All rights reserved.

    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('assets/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap  -->
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('assets/bower_components/chart.js/Chart.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('assets/dist/js/pages/dashboard2.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assets/dist/js/demo.js') }}"></script>
<!-- swal2 -->
<script src="{{ asset('assets/plugins/swal2/sweetalert2.all.min.js') }}"></script>

<!-- toastr -->
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

<!-- Summernote -->
<script src="{{ asset('assets/plugins/summernote/summernote.min.js') }}"></script>

<!-- Data table -->
<script src="{{ asset('assets/plugins/data-tables/jquery.dataTables.min.js') }}"></script>
<!-- start - This is for export functionality only -->
<script src="{{ asset('assets/plugins/data-tables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/data-tables/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/plugins/data-tables/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/data-tables/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/data-tables/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/data-tables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/data-tables/buttons.print.min.js') }}"></script>

<!-- Date Time Picker -->
<script src="{{ asset('assets/plugins/datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>
</body>

<script>
    $(function () {
        // this will get the full URL at the address bar
        const url = window.location.href;

        // passes on every "a" tag
        $(".treeview-menu a").each(function() {
            // checks if its the same on the address bar
            if(url.includes(this.href)) {
                $(this).closest("li").addClass("active");
                $(this).parents('.treeview').addClass("active");
            }
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //=============================================//
        //    File export                              //
        //=============================================//
        $('#file_export').DataTable({
            dom: 'Bfrtip',
            paging: false,
            info: false,
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ]
        });
        $('.buttons-copy, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');

        @if (session('success'))
            toastr["success"]('{{ session('success') }}');
        @endif

        //Initialize Select2 Elements
        $('.select2').select2({
            width: '100%',
        });

        @error('error')
        Swal.fire({
            type: 'error',
            title: '500 Internal Server Error!',
            html: 'Something went wrong! <br> <span class="error-message text-danger hidden">{{ $message }}</span>',
            footer: '<a href="javascript:void(0)" onclick="document.querySelector(\'.error-message\').classList.remove(\'hidden\');">Why do I have this issue?</a>'
        });
        @enderror

        //Initialize summernote text editor
        $('.summernote').summernote({
            placeholder: "Start from here",
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['color', ['color']],
                ['insert', ['link', 'picture', 'video']],
                ["view", ["codeview"]],
            ],
        });
    });

    $(".datepicker, .datetimepicker, #datepicker-from, #datepicker-to").keydown(function(e){
        e.preventDefault();
    });
    $(".datepicker, .datetimepicker, #datepicker-from, #datepicker-to").attr("autocomplete","off");

    $('.datepicker').datetimepicker({
        lang:'en',
        timepicker:false,
        format:'Y-m-d',
        formatDate:'Y/m/d'
    });

    $('.datetimepicker').datetimepicker({
        lang:'en',
        format:'Y-m-d H:i',
        startDate:	'-1970/01/01',
        step:30
    });

    /*From-to date*/
    $('#datepicker-from').datetimepicker({
        format:'Y-m-d',
        onShow:function( ct ){
            this.setOptions({
                maxDate:jQuery('#datepicker-to').val()?jQuery('#datepicker-to').val():false
            })
        },
        timepicker:false
    });
    $('#datepicker-to').datetimepicker({
        format:'Y-m-d',
        onShow:function( ct ){
            this.setOptions({
                minDate:jQuery('#datepicker-from').val()?jQuery('#datepicker-from').val():false
            })
        },
        timepicker:false
    });
    /*From-to date*/

    $('input.role-module').on('ifChecked', function () {
        var selfId = $(this).attr('id');
        var childClass = '.' + selfId + '-permission';
        $(childClass).iCheck('enable').iCheck('check');
    });

    $('input.role-module').on('ifUnchecked', function () {
        var selfId = $(this).attr('id');
        var childClass = '.' + selfId + '-permission';
        $(childClass).iCheck('uncheck').iCheck('disable');
    });
    Vue.directive('select2', {
        inserted(el) {
            $(el).on('select2:select', () => {
                const event = new Event('change', {bubbles: true, cancelable: true});
                el.dispatchEvent(event);
            });
            $(el).on('select2:unselect', () => {
                const event = new Event('change', {bubbles: true, cancelable: true})
                el.dispatchEvent(event)
            })
        },
    });
</script>

@stack('scripts')

</html>
