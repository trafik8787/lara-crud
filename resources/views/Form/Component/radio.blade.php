<div class="form-group">
    <label class="col-md-1 control-label">{{$obj->label}}</label>
    <div class="col-md-9">
        @foreach($obj->value['selectValue'] as $value => $title)
        <label class="radio-inline">
            <input type="radio" {{($obj->value['curentValue'] == $value) ? 'checked="checked"' : ''}} name="{{$obj->name}}" value="{{$value}}">
            {{$title}}
        </label>
        @endforeach

    </div>
</div>
