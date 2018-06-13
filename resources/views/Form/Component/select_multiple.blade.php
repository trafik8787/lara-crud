<div class="form-group @if (!empty($errors->get($obj->name))) has-error @endif">
    <label for="{{$obj->name}}" class="col-md-1 control-label">{{$obj->label}} @if ($obj->required !== false) <span
                class="text-red">*</span> @endif @if(($obj->tooltip))<i class="fa fa-fw fa-info-circle"
                                                                        data-toggle="tooltip"
                                                                        data-placement="{{$obj->tooltip}}"
                                                                        data-title="{{$obj->title}}"></i>@endif</label>
    <div class="col-md-9">
        <input type="hidden" name="{{$obj->name}}" value="">
        <select name="{{$obj->name}}[]" class="form-control select2-{{$obj->name}} {{$obj->classStyle}}"
                multiple="multiple">
            @if(isset($obj->value['ajaxCurentValueMultiple']))
                @foreach($obj->value['ajaxCurentValueMultiple'] as $value)
                    <option selected="selected" value="{{$value['id']}}">{{strip_tags($value['text'])}}</option>
                @endforeach
            @endif

            {{--Нижний кусок работает для статического списка select в режиме multiple--}}
            @if(isset($obj->value['selectValue']))
                @foreach($obj->value['selectValue'] as $value => $title)
                    <option {{( (!empty(old($obj->name)) and in_array($value, old($obj->name))) or isset($obj->value['curentValue'][$value]) ) ? 'selected=selected' : ''}}  value="{{$value}}">{{strip_tags($title)}}</option>
                @endforeach
            @endif
        </select>
        @include('lara::Form.Component.include.validate-errors')
    </div>
</div>
<script>
    $(document).ready(function () {

        $('.select2-{{$obj->name}}').select2({
            placeholder: "Search for a movie",
            width: 'resolve',
            allowClear: false,
            multiple: true,
            @if (empty($obj->value['selectValue']))
            ajax: {
                type: "GET",
                dataType: 'json',
                url: '{{url()->current()}}',
                data: function (term) {
                    term._token = "{{csrf_token()}}";
                    term.field = "{{$obj->name}}";
                    term.get_param = "{{json_encode(request()->input())}}";
                    return term;
                }
            }
            @endif
        });

    });
</script>