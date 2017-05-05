<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute muss akzeptiert werden.',
    'active_url'           => ':attribute ist keine gültige URL.',
    'after'                => ':attribute muss ein Datum nach dem :date sein.',
    'alpha'                => ':attribute darf ausschließlich Buchstaben enthalten.',
    'alpha_dash'           => ':attribute darf nur Buchstaben, Ziffern und Bindestriche enthalten.',
    'alpha_num'            => ':attribute darf nur Buchstaben und Ziffern enthalten.',
    'array'                => ':attribute muss ein Array sein.',
    'before'               => ':attribute muss ein Datum vor dem :date sein.',
    'between'              => [
        'numeric' => ':attribute muss zwischen :min und :max liegen.',
        'file'    => ':attribute muss zwischen :min und :max Kilobytes groß sein.',
        'string'  => ':attribute muss zwischen :min und :max Zeichen lang sein.',
        'array'   => ':attribute muss zwischen :min und :max Elemente haben.',
    ],
    'boolean'              => ':attribute muss WAHR oder FALSCH sein.',
    'confirmed'            => 'Das Bestätigungsfeld zu :attribute stimmt nicht überein.',
    'date'                 => ':attribute ist kein gültiges Datum.',
    'date_format'          => ':attribute entspricht nicht dem Format :format.',
    'different'            => ':attribute und :other müssen sich unterscheiden.',
    'digits'               => ':attribute muss :digits Ziffern haben.',
    'digits_between'       => ':attribute muss zwischen :min und :max Ziffern haben.',
    'distinct'             => ':attribute enthält einen doppelten Wert.',
    'email'                => ':attribute muss eine gültige E-Mail-Adresse sein.',
    'exists'               => 'Der ausgewählte Wert für :attribute ist ungültig.',
    'filled'               => ':attribute muss ausgefüllt sein.',
    'image'                => ':attribute muss ein Bild sein.',
    'in'                   => 'Der ausgewählte Wert für :attribute ist ungültig.',
    'in_array'             => ':attribute ist nicht in :other enthalten.',
    'integer'              => ':attribute muss eine Ganzzahl sein.',
    'ip'                   => ':attribute muss eine gültige IP-Adresse sein.',
    'json'                 => ':attribute muss eine JSON-Zeichenkette sein.',
    'max'                  => [
        'numeric' => ':attribute darf nicht größer als :max sein.',
        'file'    => ':attribute darf nicht größer als :max Kilobytes sein.',
        'string'  => ':attribute darf nicht länger als :max Zeichen sein.',
        'array'   => ':attribute darf nicht mehr als :max Elemente enthalten.',
    ],
    'mimes'                => ':attribute muss einen der folgenden Dateitypen haben: :values.',
    'min'                  => [
        'numeric' => ':attribute muss mindestens :min sein.',
        'file'    => ':attribute muss mindestens :min Kilobytes groß sein.',
        'string'  => ':attribute muss mindestens :min Zeichen haben.',
        'array'   => ':attribute muss mindestens :min Elemente enthalten.',
    ],
    'not_in'               => 'Der ausgewählte Wert für :attribute ist ungültig.',
    'numeric'              => ':attribute muss eine Zahl sein.',
    'present'              => ':attribute muss vorhanden sein.',
    'regex'                => ':attribute hat ein ungültiges Format.',
    'required'             => ':attribute muss ausgefüllt werden.',
    'required_if'          => ':attribute muss ausgefüllt werden, wenn :other den Wert :value hat.',
    'required_unless'      => ':attribute muss ausgefüllt werden, esseidenn :other ist eines von :values.',
    'required_with'        => ':attribute muss ausgefüllt werden, wenn :values vorhanden ist.',
    'required_with_all'    => ':attribute muss ausgefüllt werden, wenn :values vorhanden ist.',
    'required_without'     => ':attribute muss ausgefüllt werden, wenn :values nicht vorhanden ist.',
    'required_without_all' => ':attribute muss ausgefüllt werden, wenn nichts von :values vorhanden ist.',
    'same'                 => ':attribute und :other müssen übereinstimmen.',
    'size'                 => [
        'numeric' => ':attribute muss den Wert :size haben.',
        'file'    => ':attribute muss :size Kilobytes groß sein.',
        'string'  => ':attribute muss :size Zeichen lang sein.',
        'array'   => ':attribute muss :size Elemente enthalten.',
    ],
    'string'               => ':attribute muss eine Zeichenkette sein.',
    'timezone'             => ':attribute muss eine gültige Zeitzone sein.',
    'unique'               => ':attribute ist bereits vorhanden.',
    'url'                  => ':attribute hat ein ungültiges Format.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'login' => 'Benutzername',
        'email' => 'E-Mail-Adresse',
        'active' => 'aktiv',
        'password' => 'Passwort',
        'password_confirmation' => 'Passwort bestätigen',
        'force_password_change' => 'Passwortänderung nach Anmeldung erzwingen',
        'send_password_email' => 'Passwort per E-Mail zusenden',
        'slug' => 'SEO-URL'
    ],

];
