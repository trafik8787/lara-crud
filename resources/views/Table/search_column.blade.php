@foreach ($name_field as $originalNameField => $field)

    @if(isset($columns[$originalNameField]))

        @if(is_array($columns[$originalNameField]))
            <th rowspan="1" colspan="1">
            <select class="input-individual-search" style="width: 100%;">
                @foreach ($columns[$originalNameField] as $index => $text)
                    <option value="{{$index}}">{{$text}}</option>
                @endforeach
            </select></th>
        @else
            <th rowspan="1" colspan="1"><input class="input-individual-search" style="width: 100%;" type="text"></th>
        @endif
    @else
        <th rowspan="1" colspan="1"></th>
    @endif

@endforeach
