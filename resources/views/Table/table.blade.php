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

    <script type="text/javascript">
        $(document).ready(function() {
            var pageNum;
            var table = $('#example').DataTable( {
                "processing": true,
                "serverSide": true,
                "bPaginate":true,
                "ajax": {
                    "url": "{{ url()->current()}}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d){

                        d.numPage = (d.start/d.length) + 1;
                        d._token = "{{csrf_token()}}"
                    }
                },
                "drawCallback" : function() {
                  //  pageNum = this.api().page.info().page;
                },

                "columns": JSON.parse('<?php echo $json_field?>'),

                "oLanguage": {
                    "sProcessing": '<div class="preloader row"><div class="wrap-loading"><div class="loading loading-4"></div></div></div>'
                }
            } );
//            table.row( $(this).parents('tr') ).html('<button>sdf</button>');
        } );
    </script>
</head>
<body>


<table id="example" class="display" cellspacing="0" width="100%">
    <thead>
    <tr>
        @foreach ($name_field as $field)
            <th>{{$field}}</th>
        @endforeach

            <th>Action</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        @foreach ($name_field as $field)
            <th>{{$field}}</th>
        @endforeach
            <th>Action</th>
    </tr>
    </tfoot>
</table>
</body>
</html>