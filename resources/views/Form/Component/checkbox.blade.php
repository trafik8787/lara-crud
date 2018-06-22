<div class="form-group @if (!empty($errors->get($obj->name))) has-error @endif">
    <label for="{{$obj->name}}" class="col-md-1 control-label">{{$obj->label}} @if(($obj->tooltip))<i
                class="fa fa-fw fa-info-circle" data-toggle="tooltip" data-placement="{{$obj->tooltip}}"
                data-title="{{$obj->title}}"></i>@endif</label>
    <div class="col-md-9">
        <div class="checkbox">
            <label>
                <input type="hidden" name="{{$obj->name}}" value="0">
                <input type="checkbox" name="{{$obj->name}}"
                       {{ ($obj->value['selectValue'] == $obj->value['curentValue']) ? 'checked' : '' }} title="{{$obj->title}}"
                       value="{!! $obj->value['selectValue'] !!}" class="{{$obj->classStyle}}" id="{{$obj->name}}">
            </label>
        </div>
        @include('lara::Form.Component.include.validate-errors')
    </div>
</div>
