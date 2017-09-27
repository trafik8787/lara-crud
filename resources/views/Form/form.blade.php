@extends('lara::common.app')
@section('content')
    <div class="row">

        <h2>{{$titlePage}}</h2>
        {!! Form::open(array('class' => 'form-horizontal', 'role' => 'form', 'url' => url()->current(), 'method' => $formMetod, 'files' => true)) !!}
            @if (!empty($id))
                {{ Form::hidden('id', $id) }}
            @endif

            @foreach($objField as $item)
                {!! $item !!}
            @endforeach


            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a type="submit" class="btn">Apply</a></li>
                    <li><a href="#" class="btn">New Add</a></li>
                </ul>
            </div>
        {!! Form::close() !!}

    </div>
@endsection