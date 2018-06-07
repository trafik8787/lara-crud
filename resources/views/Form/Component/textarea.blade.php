<div class="form-group @if (!empty($errors->get($obj->name))) has-error @endif">
    <label for="{{$obj->name}}{{$obj->enableEditor ? '-editor-textarea': '' }}"
           class="col-md-1 control-label">{{$obj->label}} @if ($obj->required !== false) <span
                class="text-red">*</span> @endif @if(($obj->tooltip))<i class="fa fa-fw fa-info-circle"
                                                                        data-toggle="tooltip"
                                                                        data-placement="{{$obj->tooltip}}"
                                                                        data-title="{{$obj->title}}"></i>@endif</label>
    <div class="col-md-9">
        <textarea id="{{$obj->name}}{{$obj->enableEditor ? '-editor-textarea': '' }}"
                  class="form-control {{$obj->classStyle}}"
                  name="{{$obj->name}}" rows="3"
                  placeholder="{{$obj->placeholder}}">{{$obj->value ?? old($obj->name)}}</textarea>
        @include('lara::Form.Component.include.validate-errors')
    </div>
    <script>
        $(function () {

            CKEDITOR.replace('{{$obj->name}}-editor-textarea', {
                filebrowserWindowWidth: 800,
                filebrowserWindowHeight: 500

            });
        });
    </script>
</div>