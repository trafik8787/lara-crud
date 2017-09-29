<div class="form-group">
    <label for="{{$obj->name}}" class="col-md-1 control-label">{{$obj->label}}</label>
    <div class="col-md-9">
        <select name="{{$obj->name}}" class="form-control select2">
            @foreach($obj->value['selectValue'] as $value => $title)
                <option {{$obj->value['curentValue'] == $value ? 'selected="selected"' : ''}}  value="{{$value}}">{{$title}}</option>
            @endforeach
        </select>
    </div>
</div>