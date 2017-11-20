@extends('lara::common.app')
@section('content')

    <h2>{{$titlePage}}</h2>

    {!! Form::open(array('class' => 'form-horizontal', 'id' => 'form-repleace', 'role' => 'form', 'url' => $formActionUrl, 'method' => $formMetod, 'files' => true)) !!}

        @if (!empty($id))
            {{ Form::hidden($keyName, $id) }}
        @endif

        {!! $objField !!}
        <div class="form-group">
            <div class="col-md-1">

            </div>
            <div class="col-md-6">
                <button type="submit" name="save_button" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> Save</button>
                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-open"></span> Apply</button>
            </div>
        </div>
    {!! Form::close() !!}

    <script type="text/javascript">
        $(document).ready(function () {
            $('.fa-info-circle').tooltip();
        })
    </script>

@endsection
