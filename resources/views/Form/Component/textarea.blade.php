<div class="form-group">
    <label for="{{$obj->name}}" class="col-md-1 control-label">{{$obj->label}}</label>
    <div class="col-md-9">
        <textarea id="editor-textarea" class="form-control {{$obj->classStyle}}" name="{{$obj->name}}" rows="3" placeholder="{{$obj->placeholder}}">{{$obj->value}}</textarea>
    </div>
</div>