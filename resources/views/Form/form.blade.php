@extends('lara::common.app')
@section('content')
    <div class="row">

        <h2>Form</h2>
        {!! Form::open(array('style' => 'display: inline-block;', 'class' => '', 'url' => url()->current(), 'method' => 'PATCH', 'files' => true)) !!}
            {{ Form::hidden('id', $id) }}

            {!! $objField !!}

            <button type="submit" class="btn btn-default">submit</button>
        {!! Form::close() !!}

    </div>
@endsection