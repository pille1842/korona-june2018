@extends('layouts.backend')

@section('title')
    {{ trans('backend.about_korona') }}
@endsection

@section('content')
    <h1 class="text-center">
        <img src="{{ asset('images/korona.png') }}" alt="Korona" style="width:150px;margin-bottom:15px;"><br/>
        Korona Version 0.1beta
    </h1>

    <h4 class="text-center" style="margin-bottom:30px;">Copyright &copy; 2017 Eric Haberstroh</h4>

    <p class="lead">
        Korona ist ein Community Management System für Schüler- und Studentenverbindungen.
        Korona ist <strong>freie Software</strong> und kann <strong>unbegrenzt und kostenlos</strong>
        benutzt werden.
    </p>

    <p class="text-center">
        <a href="http://www.erixpage.de/korona/" class="btn btn-primary btn-lg" target="_blank">Mehr erfahren</a>
    </p>

    <p>
        Korona steht unter der GNU General Public License (GPL) Version 3 oder höher, die Sie hier
        im englischen Original lesen können. Eine deutschsprachige Kurzanleitung zur GPL finden Sie
        unter <a href="https://www.gnu.org/licenses/quick-guide-gplv3.html.de" target="_blank">gnu.org</a>.
    </p>

    <textarea class="form-control" style="font-family:monospace;" rows="25" readonly>
{{ $license }}
    </textarea>

    <h2>Verwendete Bibliotheken</h2>

    <p>Korona verwendet folgende Software-Bibliotheken:</p>

    <ul>
        @foreach ($packages['packages'] as $package)
            <li>
                <a href="{{ $package['source']['url'] }}" target="_blank">{{ $package['name'] }}</a>
                @if (isset($package['description']))
                    &ndash;
                    {{ $package['description'] }},
                @endif
                @if (isset($package['authors']))
                    von
                    @foreach ($package['authors'] as $author)
                        {{ $author['name'] }}
                        @if (isset($author['email']))
                            &lt;<a href="mailto:{{ $author['email'] }}">{{ $author['email'] }}</a>&gt;
                        @endif
                        ,
                    @endforeach
                @endif
                &ndash; Lizenz:
                @foreach ($package['license'] as $license)
                    {{ $license }},
                @endforeach
            </li>
        @endforeach
    </ul>

    <p>
        Sie können die Lizenzen der einzelnen Pakete in den Unterverzeichnissen
        von <tt>vendor/</tt> einsehen.
    </p>

    <p>
        Wir bedanken uns bei allen Autoren für die Bereitstellung ihrer Bibliotheken
        als freie Software.
    </p>
@endsection
