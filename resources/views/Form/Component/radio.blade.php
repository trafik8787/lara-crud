<div class="form-group">
    <label class="col-md-1 control-label">{{$obj->label}} @if(($obj->tooltip))<i class="fa fa-fw fa-info-circle"
                                                                                 data-toggle="tooltip"
                                                                                 data-placement="{{$obj->tooltip}}"
                                                                                 data-title="{{$obj->title}}"></i>@endif
    </label>
    <div class="col-md-9">
        @foreach($obj->value['selectValue'] as $value => $title)
            <label class="radio-inline">
                <input type="radio" class="{{$obj->classStyle}}"
                       {{($obj->value['curentValue'] == $value) ? 'checked="checked"' : ''}} name="{{$obj->name}}"
                       value="{{$value}}">
                {{$title}}
            </label>
        @endforeach
    </div>
</div>
