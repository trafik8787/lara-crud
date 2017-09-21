
@if($configNode->getButtonEdit())
    <a href="{{ url()->current()}}/{{$id}}/edit" class="btn btn-default">Edit</a>
@endif

@if($configNode->getButtonDelete())
    {!! Form::open(array('style' => 'display: inline-block;', 'class' => '', 'url' => url()->current().'/'.$id.'/delete', 'method' => 'DELETE', 'files' => false)) !!}
            {{ Form::hidden('id', $id) }}
            <button type="submit" class="btn btn-default">Delete</button>
    {!! Form::close() !!}

@endif

