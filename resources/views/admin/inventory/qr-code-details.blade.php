<!DOCTYPE html>
<html>

<!-- Mirrored from adminlte.io/themes/AdminLTE/index2.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Aug 2020 05:07:29 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | Inventory Details</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <style>
        body,.wrapper>section{background-color:#e8e8e8}.wrapper>.aside{background-color:#fff}.topnavbar{background-color:#fff}.topnavbar .navbar-header{background-color:transparent;background-image:-webkit-linear-gradient(left, #f05050 0%,#f47f7f 100%);background-image:-o-linear-gradient(left,#f05050 0%,#f47f7f 100%);background-image:linear-gradient(to right,#f05050 0%,#f47f7f 100%);background-repeat:repeat-x;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fff05050', endColorstr='#fff47f7f', GradientType=1)}@media only screen and (min-width:768px){.topnavbar .navbar-header{background-image:none}}  .topnavbar .navbar-nav>li>a,.topnavbar .navbar-nav>.open>a{color:#f05050}  .topnavbar .navbar-nav>li>a:hover,.topnavbar .navbar-nav>.open>a:hover,.topnavbar .navbar-nav>li>a:focus,.topnavbar .navbar-nav>.open>a:focus{color:#c91111}  .topnavbar .navbar-nav>.active>a,.topnavbar .navbar-nav>.open>a,.topnavbar .navbar-nav>.active>a:hover,.topnavbar .navbar-nav>.open>a:hover,.topnavbar .navbar-nav>.active>a:focus,.topnavbar .navbar-nav>.open>a:focus{background-color:transparent}  .topnavbar .navbar-nav>li>[data-toggle="navbar-search"]{color:#fff}  .topnavbar .nav-wrapper{background-color:#f05050;background-image:-webkit-linear-gradient(left,#f05050 0%,#f47f7f 100%);background-image:-o-linear-gradient(left,#f05050 0%,#f47f7f 100%);background-image:linear-gradient(to right,#f05050 0%,#f47f7f 100%);background-repeat:repeat-x;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fff05050', endColorstr='#fff47f7f', GradientType=1)}  .nav.nav-pills .active>a,li.user-header{background-color:#f05050}  .panel-custom .panel-heading{border-bottom:2px solid #f05050}  .nav-tabs>li.active>a{border-top:2px solid #f05050}@media only screen and (min-width:768px){.topnavbar{background-color:#f05050;background-image:-webkit-linear-gradient(left,#f05050 0%,#f47f7f 100%);background-image:-o-linear-gradient(left,#f05050 0%,#f47f7f 100%);background-image:linear-gradient(to right,#f05050 0%,#f47f7f 100%);background-repeat:repeat-x;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fff05050', endColorstr='#fff47f7f', GradientType=1)}  .topnavbar .navbar-nav>.open>a,.topnavbar .navbar-nav>.open>a:hover,.topnavbar .navbar-nav>.open>a:focus{box-shadow:0 -3px 0 rgba(255,255,255,.5) inset}  .topnavbar .navbar-nav>li>a,.topnavbar .navbar-nav>.open>a{color:#fff}  .topnavbar .navbar-nav>li>a:hover,.topnavbar .navbar-nav>.open>a:hover,.topnavbar .navbar-nav>li>a:focus,.topnavbar .navbar-nav>.open>a:focus{color:#c91111}}  .sidebar{background-color:#fff}  .sidebar .nav-heading{color:#919da8}  .sidebar .nav>li>a,.sidebar .nav>li>.nav-item{color:#515253}  .sidebar .nav>li>a:focus,.sidebar .nav>li>.nav-item:focus,.sidebar .nav>li>a:hover,.sidebar .nav>li>.nav-item:hover{color:#f05050}  .sidebar .nav>li>a>em,.sidebar .nav>li>.nav-item>em{color:inherits}  .sidebar .nav>li.active,.sidebar .nav>li.open,.sidebar .nav>li.active>a,.sidebar .nav>li.open>a,.sidebar .nav>li.active .nav,.sidebar .nav>li.open .nav{background-color:#fcfcfc;color:#f05050}  .sidebar .nav>li.active>a>em,.sidebar .nav>li.open>a>em{color:#f05050}  .sidebar .nav>li.active{border-left-color:#f05050}  .sidebar-subnav{background-color:#fff}  .sidebar-subnav>.sidebar-subnav-header{color:#515253}  .sidebar-subnav>li>a,.sidebar-subnav>li>.nav-item{color:#515253}  .sidebar-subnav>li>a:focus,.sidebar-subnav>li>.nav-item:focus,.sidebar-subnav>li>a:hover,.sidebar-subnav>li>.nav-item:hover{color:#f05050}  .sidebar-subnav>li.active>a,.sidebar-subnav>li.active>.nav-item{color:#f05050}  .sidebar-subnav>li.active>a:after,.sidebar-subnav>li.active>.nav-item:after{border-color:#f05050}  .offsidebar{border-left:1px solid #ccc;background-color:#fff;color:#515253}
    </style>
    <style>.topnavbar .navbar-header{background-image:none;background-color:transparent;background-repeat:no-repeat;filter:none}</style>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/backend1.css') }}">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body>
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>{{ config('app.name') }}</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->

                </ul>
            </div>

        </nav>
    </header>
    <section>
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <div class="panel">
                        <div class="box-header with-border">
                            <h3 class="box-title">Inventory Details</h3>
                        </div> <!-- /.box-header -->
                        <div class="panel-body">
                            <div class="col-sm-9">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <th class="float-center">Asset Code</th>
                                        <td> {{ $inventory->asset_code  }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td> {{ $inventory->description  }}</td>
                                    </tr>
                                    <tr>
                                        <th>Category</th>
                                        <td> {{ $inventory->category->category_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Allocate To</th>
                                        <td> @if($inventory->assign_to == 'user') <strong>Person:</strong>
                                            <br> {{$inventory->user->name }}
                                            @else
                                                <strong>Department:</strong><br> {{ $inventory->department->department}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Voucher No</th>
                                        <td> {{ $inventory->voucher_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Qty</th>
                                        <td> {{ $inventory->qty }}</td>
                                    </tr>
                                    <tr>
                                        <th>Cost</th>
                                        <td> {{ $inventory->cost }}</td>
                                    </tr>
                                    <tr>
                                        <th>Location</th>
                                        <td> @if($inventory->location == 'hq') Head
                                            Quarter @elseif($inventory->location == 'gs1') GS Gazipur @else GS
                                            Bethbunia @endif</td>
                                    </tr>
                                    <tr>
                                        <th>Purchase Date</th>
                                        <td>{{ $inventory->purchase_date}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-3">
                                {!! QrCode::size(150)->generate(url('inventories',$inventory->id)); !!}
                            </div>
                        </div> <!-- /.box-body -->
                    </div>
                </div>
                <div class="col-sm-2"></div>
            </div>
                   <!-- /.box -->
            <!-- /.content -->
        </div>
    </section>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            Developed by <strong>Sohana Kabir Barna</strong>
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
</body>
</html>



