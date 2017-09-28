@if($configNode->getButtonEdit())
    <a href="{{ url()->current()}}/{{$id}}/edit" class="btn btn-warning btn-flat btn-xs"><i class="fa fa-fw fa-edit"></i> Edit</a>
@endif

@if($configNode->getButtonDelete())
    {!! Form::open(array('style' => 'display: inline-block;', 'class' => '', 'url' => url()->current().'/'.$id.'/delete', 'method' => 'DELETE', 'files' => false)) !!}
        {{ Form::hidden('id', $id) }}
        <button type="submit" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-fw fa-remove"></i> Delete</button>
    {!! Form::close() !!}

@endif


@if ($configNode->getNewAction())
    @foreach($configNode->getNewAction() as $url => $item)
        {!! Form::open(array('style' => 'display: inline-block;', 'class' => '', 'url' => url()->current().'/'.$id.'/'.$url.'/action', 'method' => 'PATCH', 'files' => false)) !!}
            {{ Form::hidden('id', $id) }}
            <button type="submit" class="btn btn-default btn-flat btn-xs">{{$item['nameButton']}}</button>
        {!! Form::close() !!}
    @endforeach
@endif