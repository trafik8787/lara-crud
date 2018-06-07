<ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN NAVIGATION</li>
    @foreach($nav as $url => $item)
        @if($url !== 'tabs')
            <li @if ('/'.request()->path() === $url) class="active" @endif><a href="{{$url}}"><i
                            class="fa {{$item['icon']}}"></i> <span>{{$item['title']}}</span></a></li>

        @else

            @foreach($item as $nameTab => $item2)

                <li class="treeview @if (!empty($item2['node']['/'.request()->path()])) active @endif">
                    <a href="#">
                        <i class="fa {{$item2['settings']['icon']}}"></i> <span>{{$nameTab}}</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        @foreach($item2['node'] as  $url => $item3)
                            <li @if ('/'.request()->path() === $url) class="active" @endif ><a href="{{$url}}"><i
                                            class="fa {{$item3['icon']}}"></i> <span>{{$item3['title']}}</span></a></li>
                        @endforeach
                    </ul>
                </li>
            @endforeach

        @endif
    @endforeach

</ul>


