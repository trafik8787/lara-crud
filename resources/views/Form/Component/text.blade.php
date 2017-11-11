
<div class="form-group">
    <label for="{{$obj->name}}" class="col-md-1 control-label">{{$obj->label}}</label>
    <div class="col-md-9">
        <input type="{{$obj->type}}" name="{{$obj->name}}" title="{{$obj->title}}" value="{{$obj->value}}" class="form-control {{$obj->classStyle}}" id="{{$obj->name}}" placeholder="{{$obj->placeholder}}">
    </div>
</div>