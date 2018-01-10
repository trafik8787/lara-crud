@if($configNode->getButtonEdit())
    <a href="{{ url()->current()}}/{{$id}}/edit" class="btn btn-warning btn-flat "><i class="fa fa-fw fa-edit"></i> {{__('lara-crud::datatable.lEdit')}}</a>
@endif

@if($configNode->getButtonDelete())
    {!! Form::open(array('style' => 'display: inline-block;', 'class' => '', 'url' => url()->current().'/'.$id.'/delete', 'method' => 'DELETE', 'files' => false)) !!}
        {{ Form::hidden('id', $id) }}
        <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-fw fa-remove"></i> {{__('lara-crud::datatable.lDelete')}}</button>
    {!! Form::close() !!}

@endif


@if ($configNode->getNewAction())
    @foreach($configNode->getNewAction() as $url => $item)
        {!! Form::open(array('style' => 'display: inline-block;', 'class' => '', 'url' => url()->current().'/'.$id.'/'.$url.'/action', 'method' => 'PATCH', 'files' => false)) !!}
            {{ Form::hidden('id', $id) }}
            <button type="submit" class="btn btn-default btn-flat">{{$item['nameButton']}}</button>
        {!! Form::close() !!}
    @endforeach
@endif