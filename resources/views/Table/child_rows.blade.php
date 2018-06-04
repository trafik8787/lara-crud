<table class="table" cellpadding="5" cellspacing="0" border="0">
    @foreach($model->toArray() as $name => $rows)
        <tr>
            <td>{{ $name }}</td>
            <td>{!! $rows !!}</td>
        </tr>
    @endforeach
</table>