<div class="form-group">
    <label for="{{$obj->name}}" class="col-md-1 control-label">{{$obj->label}} @if(($obj->tooltip))<i
                class="fa fa-fw fa-info-circle" data-toggle="tooltip" data-placement="{{$obj->tooltip}}"
                data-title="{{$obj->title}}"></i>@endif</label>
    <div class="col-md-9">
        <button id="addRow">Add</button>
        <input type="hidden" class="form-control" name="{{$obj->name}}" value="">
        <table class="table table-bordered table-hover dataTable one-to-many-table" role="grid">
            <thead>
            <tr>
                @foreach($obj->one_to_many['list_fields'] as $item)
                    <th>{{$item}}</th>
                @endforeach
                <th>#</th>
            </tr>
            </thead>
            @if(!empty($obj->value))
                <tbody>
                @foreach($obj->value['selectValue'] as $item)
                    <tr>
                        @if(!empty($item[$obj->value['primary_key_relation']]))
                            <input type="hidden"
                                   name="{{$obj->name}}[{{$obj->value['primary_key_relation']}}][{{$loop->iteration}}]"
                                   value="{{$item[$obj->value['primary_key_relation']]}}">
                        @endif

                        @foreach($item as $nameField => $item2)
                            @if($nameField !== $obj->value['primary_key_relation'])
                                <td><input type="text" class="form-control"
                                           name="{{$obj->name}}[{{$nameField}}][{{$loop->parent->iteration}}]" value="{{$item2}}">
                                </td>
                            @endif
                        @endforeach
                        <td>
                            <button type="button" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove-sign"></i>
                            </button>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            @endif
        </table>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function () {

        var t = $('.one-to-many-table').DataTable({
            "bInfo": false,
            "bFilter": false,
            "bLengthChange": false,
            "bPaginate": false,
            "scrollY": 200,
            "scrollCollapse": true,
            "ordering": false,
            "bAutoWidth": true
        });

        var counter = '{{count($obj->value['selectValue']) + 1}}';

        $('#addRow').on('click', function () {
            t.row.add([
                @foreach($obj->one_to_many['list_fields'] as $nameField => $item)
                    '<input type="text" class="form-control" name="{{$obj->name}}[{{$nameField}}][' + counter + ']" value="">',
                @endforeach
                    '<button type="button" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove-sign"></i></button>'
            ]).draw(false);

            counter++;

            $('.one-to-many-table').parent().scrollTop(9999);

            return false;
        });

        $(document).on('click', '.remove', function () {
            var rows = t
                .rows($(this).parents('tr'))
                .remove()
                .draw();
            return false;
        });

    });
</script>