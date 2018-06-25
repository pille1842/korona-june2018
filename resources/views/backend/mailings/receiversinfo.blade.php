<h4>
    <span class="glyphicon glyphicon-info-sign"></span>
    {{ trans('backend.receiversinfo') }}
</h4>

<table class="table">
    <tbody>
        <tr>
            <td>{{ trans('backend.total_members') }}</td>
            <td>{{ $membersCount }}</td>
        </tr>
        <tr>
            <td>{{ trans('backend.total_people') }}</td>
            <td>{{ $peopleCount }}</td>
        </tr>
        <tr>
            <td><strong>{{ trans('backend.total_receivers') }}</strong></td>
            <td><strong>{{ $receiversCount }}</strong></td>
        </tr>
        @if (count($noaddress) > 0)
            <tr>
                <td>{{ trans('backend.no_address') }}</td>
                <td>
                    @foreach ($noaddress as $person)
                        {{ $person }}<br>
                    @endforeach
                </td>
            </tr>
        @endif
    </tbody>
</table>

<p>
    <span class="glyphicon glyphicon-eye-open"></span>
    {{ $receiversType }}
</p>
