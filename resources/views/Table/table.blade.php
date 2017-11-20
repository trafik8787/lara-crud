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
            {{--<h1 class="box-title">{{$titlePage}}</h1>--}}
            <h2>{{$titlePage}}</h2>
        </div>
        <div class="box-body">
            {!! Form::open(array('class' => 'form-horizontal', 'id' => 'form-table-display', 'role' => 'form', 'files' => false)) !!}
                <div class="mailbox-controls text-right">
                    @if($buttonAdd)
                        <a href="{{ url()->current()}}/create" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add New</a>
                    @endif
                    @if($buttonCopy)
                        <button type="submit" name="copy_{{csrf_token()}}" class="btn btn-default"><span class="glyphicon glyphicon-copy"></span> Copy</button>
                    @endif
                    @if($buttonGroupDelete)
                        <button type="submit" name="delete_group_{{csrf_token()}}" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Delete</button>
                    @endif
                </div>


                <table id="example" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        @if($buttonGroupDelete or $buttonCopy)
                        <th><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"></th>
                        @endif
                        @foreach ($name_field as $field)
                            <th>{{$field}}</th>
                        @endforeach
                        <th>Action</th>

                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        @if($buttonGroupDelete or $buttonCopy)
                        <th>#</th>
                        @endif
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