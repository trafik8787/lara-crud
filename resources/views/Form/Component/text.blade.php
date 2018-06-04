
<div class="form-group @if (!empty($errors->get($obj->name))) has-error @endif">
    <label for="{{$obj->name}}" class="col-md-1 control-label">{{$obj->label}} @if ($obj->required !== false) <span class="text-red">*</span> @endif @if(($obj->tooltip))<i class="fa fa-fw fa-info-circle" data-toggle="tooltip" data-placement="{{$obj->tooltip}}" data-title="{{$obj->title}}"></i>@endif</label>
    <div class="col-md-9">
        {{Form::{$obj->type}($obj->name, $obj->value, ['class' => 'form-control '.$obj->classStyle, 'id' => $obj->name, 'placeholder' => $obj->placeholder]) }}
        {{--<input type="{{$obj->type}}" name="{{$obj->name}}"  value="{{$obj->value ?? old($obj->name)}}" class="form-control {{$obj->classStyle}}" id="{{$obj->name}}" placeholder="{{$obj->placeholder}}">--}}
        @include('lara::Form.Component.include.validate-errors')
    </div>

</div>

