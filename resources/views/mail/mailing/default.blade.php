<!DOCTYPE html>
<html lang="de">
    <head></head>
    <body>
        <table style="width:100%;border-collapse:collapse;">
            <tbody>
                <tr>
                    <td style="width:80%;border:1px solid #800000;padding:10px;">
                        {!! $body !!}
                    </td>
                    <td style="width:20%;border:1px solid #800000;background-color:#800000;">
                        <img src="{{ isset($message) ? $message->embed(public_path('images/zirkel.png')) : asset('images/zirkel.png') }}">
                    </td>
                </tr>
            </tbody>
        </table>
        <p style="color:grey;margin-top:15px;">
            Du erhältst dieses E-Mail, weil du Abonnent der Mailingliste
            <i>{{ $mailing->mailinglist->name }}</i> bist.
            @if ($mailing->mailinglist->subscribable && $receiver instanceof Korona\Member)
                Du kannst dein Abonnement dieser Liste selbst in deinen
                E-Mail-Einstellungen verwalten.
            @else
                Wende dich an einen Administrator, wenn du E-Mails von dieser
                Liste nicht mehr empfangen willst.
            @endif
        </p>
    </body>
</html>
