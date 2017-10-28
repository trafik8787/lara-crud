<div class="form-group">
    <label for="{{$obj->name}}" class="col-md-1 control-label">{{$obj->label}}</label>
    <div class="col-md-9">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="{{$obj->name}}" {{ ($obj->value['selectValue'] === $obj->value['curentValue']) ? 'checked' : '' }} title="{{$obj->title}}" value="{!! $obj->value['selectValue'] !!}" class="{{$obj->classStyle}}" id="{{$obj->name}}">
            </label>
        </div>
    </div>
</div>
