<?php

namespace Korona;

use Illuminate\Database\Eloquent\Model;

class Mailing extends Model
{
    protected $dates = ['created_at', 'updated_at', 'sent_at'];

    public function mailinglist()
    {
        return $this->belongsTo('Korona\Mailinglist');
    }

    public function sender()
    {
        return $this->belongsTo('Korona\Member', 'sender_id');
    }

    public static function layouts()
    {
        return [
            '' => '',
            'default' => 'Standard',
            'bereavement' => 'Trauerfall',
        ];
    }
}
