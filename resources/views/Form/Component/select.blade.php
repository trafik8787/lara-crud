<div class="form-group">
    <label for="{{$obj->name}}" class="col-md-1 control-label">{{$obj->label}}</label>
    <div class="col-md-9">
        <select name="{{$obj->name}}" class="form-control select2" {{$obj->multiple ? 'multiple="multiple"' : ''}}>
            {{--@foreach($obj->value['selectValue'] as $value => $title)--}}
                {{--<option {{$obj->value['curentValue'] == $value ? 'selected="selected"' : ''}}  value="{{$value}}">{{$title}}</option>--}}
            {{--@endforeach--}}
        </select>
    </div>
</div>


<script>
    $(function () {


        $('.select2').select2({
            placeholder: "Search for a movie",
            width: 'resolve',
            ajax: {
                type: "GET",
                dataType: 'json',
                url: '{{url()->current()}}',
                data: function (term) {
                    term._token = "{{csrf_token()}}";
                    term.field = "{{$obj->name}}";
                    return term;
                }
            }
        });
    });
</script>