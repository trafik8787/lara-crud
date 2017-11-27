<div class="form-group">
    <label for="{{$obj->name}}" class="col-md-1 control-label">{{$obj->label}} @if(($obj->tooltip))<i class="fa fa-fw fa-info-circle" data-toggle="tooltip" data-placement="{{$obj->tooltip}}" data-title="{{$obj->title}}"></i>@endif</label>
    <div class="col-md-9">
        <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="date" name="{{$obj->name}}"  value="{{$obj->value}}" class="form-control pull-right datepicker {{$obj->classStyle}}" id="{{$obj->name}}" placeholder="{{$obj->placeholder}}">
        </div>
    </div>
</div>