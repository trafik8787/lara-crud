@empty(!$data_tabs)
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            {{--{!! dd($data_tabs) !!}--}}
            @foreach($data_tabs as $name_tab => $tab)
                <li @if ($loop->first) class="active" @endif><a href="#{{$name_tab}}" data-toggle="tab">{{$name_tab}}</a></li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($data_tabs as $name_tab => $tab)

                <div class="tab-pane @if ($loop->first) active @endif" id="{{$name_tab}}">

                    @foreach($tab as $field)
                        {!! $field !!}
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endempty
@empty(!$no_tab)
    @foreach($no_tab as $row)

        @if (is_object($row))
            {!! $row->run() !!}
        @else
            {!! $row !!}
        @endif


    @endforeach
@endempty
