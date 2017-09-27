@extends('lara::common.app')
@section('content')
    <div class="row">

        <h2>{{$titlePage}}</h2>
        {!! Form::open(array('class' => 'form-horizontal', 'role' => 'form', 'url' => url()->current(), 'method' => $formMetod, 'files' => true)) !!}
            {{ Form::hidden('id', $id) }}

            @foreach($objField as $item)
                {!! $item !!}
            @endforeach

            <button type="submit" class="btn btn-default">submit</button>
        {!! Form::close() !!}

    </div>
@endsection