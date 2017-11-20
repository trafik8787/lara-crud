
@if (!empty($obj->value))
    <div class="form-group">
        <div class="col-md-1">

        </div>
        <div class="col-md-9">
                {{--{{dd(json_decode($obj->value) )}}--}}

                    <ul class="mailbox-attachments clearfix">

                        @if($obj->isJSON())

                            @foreach(json_decode($obj->value) as $value)

                                @include('lara::Form.Component.include.image', ['value' => $value,
                                                                                'name' => $obj->name,
                                                                                'multiple' => $obj->multiple])

                            @endforeach

                        @else
                            @empty(!File::exists($obj->value))
                                @include('lara::Form.Component.include.image', ['value' => $obj->value,
                                                                                'name' => $obj->name,
                                                                                'multiple' => $obj->multiple])
                            @endempty
                        @endif
                    </ul>

        </div>


    </div>
@endif

<div class="form-group">
    <label for="{{$obj->name}}" class="col-md-1 control-label">{{$obj->label}} @if(($obj->tooltip))<i class="fa fa-fw fa-info-circle" data-toggle="tooltip" data-placement="{{$obj->tooltip}}" data-title="{{$obj->title}}"></i>@endif</label>
    <div class="col-md-9">
        <input type="file" {{$obj->multiple ? 'multiple' : ''}}  name="{{$obj->multiple ? $obj->name.'[]' : $obj->name}}"
               title="{{$obj->title}}"
               class="form-control {{$obj->classStyle}}" id="{{$obj->name}}" placeholder="{{$obj->placeholder}}">
    </div>
</div>