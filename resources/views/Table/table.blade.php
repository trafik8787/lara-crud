@extends('lara::common.app')
@section('content')
    <script type="text/javascript">
        $(document).ready(function () {
            var data_json = JSON.parse('{!! $data_json !!}');
            var table = $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "bPaginate": true,
                'autoWidth': false,
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

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{$titlePage}}</h3>
        </div>
        <div class="box-body">
            <div class="mailbox-controls text-right">
                <a href="{{ url()->current()}}/create" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add New</a>
                <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-copy"></span> Copy</button>
                <button type="button" name="delete_group" class="btn btn-danger" onclick="$('#form-table-display').submit()"><span class="glyphicon glyphicon-remove"></span> Delete</button>
            </div>

            {!! Form::open(array('class' => 'form-horizontal', 'id' => 'form-table-display', 'role' => 'form', 'files' => false)) !!}
                <table id="example" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"></th>
                        @foreach ($name_field as $field)
                            <th>{{$field}}</th>
                        @endforeach
                        <th>Action</th>

                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        @foreach ($name_field as $field)
                            <th>{{$field}}</th>
                        @endforeach
                        <th>Action</th>

                    </tr>
                    </tfoot>
                </table>
            {!! Form::close() !!}
        </div>
    </div>
@endsection