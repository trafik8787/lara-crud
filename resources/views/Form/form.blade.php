@extends('lara::common.app')
@section('content')
    {{--<div class="box">--}}
        {{--<div class="box-header">--}}
            {{--<h3 class="box-title">{{$titlePage}}</h3>--}}
        {{--</div>--}}
        {{--<div class="box-body">--}}

            {!! Form::open(array('class' => 'form-horizontal', 'role' => 'form', 'url' => $formActionUrl, 'method' => $formMetod, 'files' => true)) !!}

                @if (!empty($id))
                    {{ Form::hidden($keyName, $id) }}
                @endif


                {{--@foreach($objField as $item)--}}
                    {{--{!! $item !!}--}}
                {{--@endforeach--}}


                {!! $objField !!}

                <div class="box-footer">
                    <button type="submit" name="save_button" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> Save</button>
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-open"></span> Apply</button>
                </div>
            {!! Form::close() !!}
        {{--</div>--}}
    {{--</div>--}}
@endsection