<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Data Tables</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{asset('vendor/lara-crud/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/lara-crud/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/lara-crud/bower_components/Ionicons/css/ionicons.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('vendor/lara-crud/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/lara-crud/css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/lara-crud/bower_components/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/lara-crud/plugins/timepicker/bootstrap-timepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/lara-crud/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">

    <link rel="stylesheet" href="{{asset('vendor/lara-crud/css/all.css')}}">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- jQuery 3 -->
    <script src="{{asset('vendor/lara-crud/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{asset('vendor/lara-crud/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- DataTables -->
    <script src="{{asset('vendor/lara-crud/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/lara-crud/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

    <script src="{{asset('vendor/lara-crud/bower_components/fastclick/lib/fastclick.js')}}"></script>
    <script src="{{asset('vendor/lara-crud/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{asset('vendor/lara-crud/bower_components/ckeditor/ckeditor.js')}}"></script>

    <script src="{{asset('vendor/lara-crud/bower_components/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.5/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>

    <script src="{{asset('vendor/lara-crud/js/adminlte.min.js')}}"></script>
    <script src="{{asset('vendor/lara-crud/js/app.js')}}"></script>

</head>


@include('lara::common.header')

@yield('content')


@include('lara::common.footer')


