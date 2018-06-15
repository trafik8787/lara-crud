@extends('lara::common.app')
@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{$titlePage}}</h3>

            <div class="row">
                <div class="col-md-12">{!! $addViewCustom !!}</div>
            </div>

        </div>
        {!! Form::open(array('class' => 'form-horizontal '.$classForm, 'id' => 'form-repleace', 'role' => 'form', 'url' => $formActionUrl, 'method' => $formMetod, 'files' => true)) !!}

        @if (!empty($id))
            {{ Form::hidden($keyName, $id) }}
        @endif

        {!! $objField !!}
        <div class="box-footer">
            <div class="form-group">
                <div class="col-md-1">

                </div>
                <div class="col-md-6 ">
                    <button type="submit" name="save_button" value="1" class="btn btn-primary"><span
                                class="glyphicon glyphicon-floppy-saved"></span> @lang('lara-crud::datatable.SAVE_FORM')
                    </button>
                    @if($buttonApply)
                        <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-floppy-open"></span> @lang('lara-crud::datatable.APPLY_FORM')
                        </button>
                    @endif
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.fa-info-circle').tooltip();
        });

        $(document).on('click', '.btn-add', function (e) {
            e.preventDefault();

            var controlForm = $('.controls .form:first'),
                currentEntry = $(this).parents('.entry:first'),
                newEntry = $(currentEntry.clone()).appendTo(controlForm);

            newEntry.find('input').val('');
            controlForm.find('.entry:not(:last) .btn-add')
                .removeClass('btn-add').addClass('btn-remove')
                .removeClass('btn-success').addClass('btn-danger')
                .html('<span class="glyphicon glyphicon-minus"></span>');
        }).on('click', '.btn-remove', function (e) {
            $(this).parents('.entry:first').remove();

            e.preventDefault();
            return false;
        });
    </script>

    @include('lara::Form.Component.include.validate-js')

@endsection
