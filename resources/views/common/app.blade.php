<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('vendor/lara-crud/js/jquery.js')}}"></script>
    <script src="{{asset('vendor/lara-crud/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('vendor/lara-crud/js/jquery.dataTables.min.js') }}"></script>
    <link href="{{ asset('vendor/lara-crud/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/lara-crud/css/jquery.dataTables.min.css') }}" rel="stylesheet">

    <link href="{{ asset('vendor/lara-crud/css/all.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body>

<div class="container-fluid">
    @include('lara::common.header')
    <div class="row">

        <div class="col-md-1">
            <ul>
                <li><a href="/admin/article_model/">Article</a></li>
                <li> <a href="/admin/contact_model">Contact</a></li>
            </ul>
        </div>

        <div class="col-md-11">

            @yield('content')
        </div>

    </div>
    @include('lara::common.footer')
</div>

</body>
</html>