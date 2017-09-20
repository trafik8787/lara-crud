<a href="{{ url()->current()}}/{{$id}}/edit" class="btn btn-default">Edit</a>
@if($configNode->getButtonDelete())
    <a href="{{ url()->current()}}/{{$id}}/delete" class="btn btn-default">Delete</a>
@endif

