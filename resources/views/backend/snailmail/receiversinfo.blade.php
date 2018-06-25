<h4>
    <span class="glyphicon glyphicon-info-sign"></span>
    {{ trans('backend.receiversinfo') }}
</h4>

<table class="table">
    <thead>
        <tr>
            <th>{{ trans('backend.country') }}</th>
            <th>{{ trans('backend.count') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($countries as $country => $number)
            <tr>
                <td>
                    <img src="{{ asset('images/flags/' . strtolower(Korona\Country::find($country)->short) . '.png') }}" alt="" aria-hidden="true">
                    {{ Korona\Country::find($country)->name }}
                </td>
                <td>{{ $number }}</td>
            </tr>
        @endforeach
        <tr>
            <td><strong>{{ trans('backend.total_domestic') }}</strong></td>
            <td><strong>{{ $receivers_domestic }}</strong></td>
        </tr>
        <tr>
            <td><strong>{{ trans('backend.total_foreign') }}</strong></td>
            <td><strong>{{ $receivers_foreign }}</strong></td>
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
