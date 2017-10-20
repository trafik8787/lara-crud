
<div class="form-group">
    <label for="{{$obj->name}}" class="col-md-1 control-label">{{$obj->label}}</label>
    <div class="col-md-9">
        <select name="{{$obj->name}}" class="form-control select2-{{$obj->name}}" {{$obj->multiple ? 'multiple="multiple"' : ''}}>
            @if(isset($obj->value['selectValue']))
                @foreach($obj->value['selectValue'] as $value => $title)
                    <option {{$obj->value['curentValue'] == $value ? 'selected="selected"' : ''}}  value="{{$value}}">{{$title}}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>


<script>
    $(function () {


        $('.select2-{{$obj->name}}').select2({
            placeholder: "Search for a movie",
            width: 'resolve',
            @if (empty($obj->value['selectValue']))
                ajax: {
                    type: "GET",
                    dataType: 'json',
                    url: '{{url()->current()}}',
                    data: function (term) {
                        term._token = "{{csrf_token()}}";
                        term.field = "{{$obj->name}}";
                        return term;
                    }
                },
                initSelection: function (element, callback) {

//                    callback({ id: 1, text: 'Text' });
                }
            @endif
        });
    });
</script>