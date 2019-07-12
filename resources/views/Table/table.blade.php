@extends('lara::common.app')
@section('content')
    <script type="text/javascript">
        $(document).ready(function () {
            var data_json = JSON.parse('{!! $data_json !!}');

            $('#example thead tr:eq(1) th').each( function (i) {

                $('.input-individual-search', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table.column(i).search(this.value).draw();
                    }

                });
            });

            var ajaxData = '';
            if (data_json.serverSide) {
                ajaxData = {
                    "url": "{{ url()->current()}}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d) {

                        d.numPage = (d.start / d.length) + 1;
                        d._token = "{{csrf_token()}}"
                    }
                }
            }

            var table = $('#example').DataTable({
                "orderCellsTop": true,
                //"fixedHeader": true,
                "serverSide": data_json.serverSide,
                "searching": data_json.searching,
                "bPaginate": data_json.disablePaginate,
                "stateSave": data_json.stateSave,
                'autoWidth': false,
                //'scrollX': true,
                "orderFixed": data_json.orderFixed,
                "sPaginationType": "full_numbers",
                "ajax": ajaxData,
                rowReorder: {
                    dataSrc: data_json.rowReorder,
                    enable: (data_json.rowReorder !== false) ? true : false,
                    update: false
                },
                "columns": JSON.parse('{!! json_encode($json_field, true) !!}'),
                "order": [
                    data_json.order
                ],
                "pageLength": data_json.pageLength,
                "oLanguage": {
                    "sProcessing": '<img src="{{asset("vendor/lara-crud/img/loader.gif")}}">'
                },
                "processing": data_json.serverSide,
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

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

                },

                "oLanguage": JSON.parse('{!! json_encode(__('lara-crud::datatable')) !!}')

            });




            if (data_json.rowReorder !== false) {
                $.extend(
                    $.fn.dataTable.RowReorder.defaults,
                    {selector: 'td:not(td:last-child)'}
                );

                $.fn.dataTable.defaults.rowReorder = true;
            }

            table.on('row-reorder', function ( e, diff, edit ) {

                var result = [];
                for ( var i=0, ien=diff.length ; i<ien ; i++ ) {

                    result[i] = {oldData: diff[i].oldData, newData: diff[i].newData}
                }

                $.ajax({
                    url: "{{ url()->current()}}",
                    type: 'post',
                    data:  {
                        _token: "{{csrf_token()}}",
                        rowReorder: result,
                        // order: [{column: 2, dir: 'desc'}]
                    }
                })

                return false;
            });



            // Add event listener for opening and closing details
            $('#example tbody').on('click', 'td .details-control-div', function () {
                var botton = $(this).find('span.glyphicon');
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    botton.removeClass('glyphicon-minus-sign');
                    botton.addClass('glyphicon-plus-sign');
                } else {
                    $.ajax({
                        type: "POST",
                        data: {_token: "{{csrf_token()}}", child_rows: true, id: $(this).data('id')},
                        success: function (msg) {
                            row.child(msg).show();
                            botton.addClass('glyphicon-minus-sign');
                        }
                    });
                }
                return false;
            });


        });
    </script>

    <div class="box">
        <div class="box-header">

            <h2>{{$titlePage}}</h2>

            <div class="row">
                <div class="col-md-12">{!! $addViewCustom !!}</div>
            </div>
        </div>
        <div class="box-body">
            {!! Form::open(array('class' => 'form-horizontal', 'id' => 'form-table-display', 'role' => 'form', 'files' => false, 'onsubmit' => 'return false;')) !!}
            <div class="mailbox-controls text-right">
                @if($buttonAdd)
                    <a href="{{ url()->current()}}/create" class="btn btn-success"><span
                                class="glyphicon glyphicon-plus"></span> {{__('lara-crud::datatable.lAdd')}}</a>
                @endif
                @if($buttonCopy)
                    <button type="submit" name="copy_{{csrf_token()}}" class="btn btn-default"><span
                                class="glyphicon glyphicon-copy"></span> {{__('lara-crud::datatable.lCopy')}}</button>
                @endif
                @if($buttonGroupDelete)
                    <button type="submit" name="delete_group_{{csrf_token()}}" class="btn btn-danger"><span
                                class="glyphicon glyphicon-remove"></span> {{__('lara-crud::datatable.lDelete')}}
                    </button>
                @endif
            </div>


            <table id="example" class="table table-bordered table-hover">
                <thead>
                <tr>
                    @if($childRowsColumnBool)
                        <th></th>
                    @endif
                    @if($buttonGroupDelete or $buttonCopy)
                        <th><input type="checkbox"
                                   onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"></th>
                    @endif
                    @foreach ($name_field as $field)
                        <th>{{$field}}</th>
                    @endforeach
                    @if($buttonAction)
                        <th>{{__('lara-crud::datatable.lAction')}}</th>
                    @endif

                </tr>

                @if(!empty($columnSearch))
                    <tr role="row">
                        @if($childRowsColumnBool)
                            <th rowspan="1" colspan="1"></th>
                        @endif
                        @if($buttonGroupDelete or $buttonCopy)
                            <th rowspan="1" colspan="1"></th>
                        @endif

                        {!! $columnSearch->render() !!}

                        @if($buttonAction)
                            <th rowspan="1" colspan="1"></th>
                        @endif
                    </tr>
                @endif
                </thead>
                @if (!empty($tableDataBody))
                    <tbody>
                        @foreach($tableDataBody as $body)
                            <tr>
                                @foreach($json_field as $item)
                                    <td>{!! $body[$item['data']] !!}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                @endif
                <tfoot>
                <tr>
                    @if($childRowsColumnBool)
                        <th></th>
                    @endif
                    @if($buttonGroupDelete or $buttonCopy)
                        <th>#</th>
                    @endif
                    @foreach ($name_field as $field)
                        <th>{{$field}}</th>
                    @endforeach
                    @if($buttonAction)
                        <th>{{__('lara-crud::datatable.lAction')}}</th>
                    @endif

                </tr>
                </tfoot>
            </table>
            {!! Form::close() !!}
        </div>
    </div>
@endsection