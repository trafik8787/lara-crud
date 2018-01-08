<div class="form-group">
    <label for="{{$obj->name}}" class="col-md-1 control-label">{{$obj->label}} @if(($obj->tooltip))<i class="fa fa-fw fa-info-circle" data-toggle="tooltip" data-placement="{{$obj->tooltip}}" data-title="{{$obj->title}}"></i>@endif</label>
    <div class="col-md-9">
        <select name="{{$obj->name}}" class="form-control select2-{{$obj->name}}">
            @if(isset($obj->value['selectValue']))
                @foreach($obj->value['selectValue'] as $value => $title)
                    <option {{$obj->value['curentValue'] == $value ? 'selected="selected"' : ''}}  value="{{$value}}">{{strip_tags($title)}}</option>
                @endforeach
            @endif

        </select>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.select2-{{$obj->name}}').select2({
            placeholder: "Search for a movie",
            width: 'resolve',
            allowClear: false,
            @if (empty($obj->value['selectValue']))
                ajax: {
                    type: "GET",
                    dataType: 'json',
                    url: '{{url()->current()}}',
                    data: function (term) {
                        term._token = "{{csrf_token()}}";
                        term.field = "{{$obj->name}}";
                        return term;
                    }
                },
                @if(!empty($obj->value['ajaxCurentValue']))
                    initSelection: function (element, callback) {
                        callback({ id: '{{$obj->value['ajaxCurentValue']}}', text: '{{$obj->value['ajaxCurrentText']}}' });
                    }
                @endif
            @endif
        });

    });
</script>
