@extends('lara::common.app')
@section('content')
    <script type="text/javascript">
        $(document).ready(function () {
            var data_json = JSON.parse('{!! $data_json !!}');
            var table = $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "bPaginate": true,
                "ajax": {
                    "url": "{{ url()->current()}}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d) {

                        d.numPage = (d.start / d.length) + 1;
                        d._token = "{{csrf_token()}}"
                    }
                },

                "columns": JSON.parse('{!! $json_field !!}'),
                "order": [
                    data_json.order
                ],
                "pageLength": data_json.pageLength,
                "oLanguage": {
                    "sProcessing": '<div class="preloader row"><div class="wrap-loading"><div class="loading loading-4"></div></div></div>'
                },
                "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {

                    if (data_json.rowsColorWidth != false) {
                        data_json.rowsColorWidth.forEach(function (item, i, arr) {
                            if (item.operand == '==') {
                                if (aData[item.field] == item.value) {
                                    $('td', nRow).css('background-color', item.color);
                                }
                            } else if (item.operand == '>') {
                                if (aData[item.field] == item.value) {
                                    $('td', nRow).css('background-color', item.color);
                                }
                            } else if (item.operand == '<') {
                                if (aData[item.field] == item.value) {
                                    $('td', nRow).css('background-color', item.color);
                                }
                            } else if (item.operand == '!=') {
                                if (aData[item.field] == item.value) {
                                    $('td', nRow).css('background-color', item.color);
                                }
                            }

                        });
                    }

                }
            });
//            table.row( $(this).parents('tr') ).html('<button>sdf</button>');
        });
    </script>


    <h2>{{$titlePage}}</h2>
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

@endsection