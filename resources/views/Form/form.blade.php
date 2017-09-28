@extends('lara::common.app')
@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{$titlePage}}</h3>
        </div>
        <div class="box-body">

            {!! Form::open(array('class' => 'form-horizontal', 'role' => 'form', 'url' => url()->current(), 'method' => $formMetod, 'files' => true)) !!}
                @if (!empty($id))
                    {{ Form::hidden('id', $id) }}
                @endif

                @foreach($objField as $item)
                    {!! $item !!}
                @endforeach


                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection