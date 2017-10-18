@if (!empty($obj->value))
    <div class="form-group">
        <div class="col-md-1">

        </div>
        <div class="col-md-9">

                    <ul class="mailbox-attachments clearfix">

                        @if($obj->isJSON())

                            @foreach(json_decode($obj->value) as $value)

                                @include('lara::Form.Component.include.image', ['value' => $value, 'name' => $obj->name])

                            @endforeach

                        @else

                            @include('lara::Form.Component.include.image', ['value' => $obj->value, 'name' => $obj->name])

                        @endif
                    </ul>

        </div>


    </div>
@endif

<div class="form-group">
    <label for="{{$obj->name}}" class="col-md-1 control-label">{{$obj->label}}</label>
    <div class="col-md-9">
        <input type="file" {{$obj->multiple ? 'multiple' : ''}}  name="{{$obj->multiple ? $obj->name.'[]' : $obj->name}}"
               title="{{$obj->title}}"
               class="form-control {{$obj->classStyle}}" id="{{$obj->name}}" placeholder="{{$obj->placeholder}}">
    </div>
</div>