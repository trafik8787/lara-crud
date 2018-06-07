<table class="table" cellpadding="5" cellspacing="0" border="0">
    @foreach($model as $rows)
        <tr>
            <td><b>{{ $rows['name'] }}:</b></td>
            <td>{!! $rows['value'] !!}</td>
        </tr>
    @endforeach
</table>