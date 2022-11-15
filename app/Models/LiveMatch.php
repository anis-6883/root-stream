<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveMatch extends Model
{
    use HasFactory;

    public function getMatchTime2Attribute()
    {
        $date = \Carbon\Carbon::createFromTimestamp($this->match_time)->format('Y-m-d H:i');
        return $date;
    }

    public function getMatchTime3Attribute()
    {
        $date = \Carbon\Carbon::createFromTimestamp($this->match_time)->format('d-M-Y / h:i A');
        return $date;
    }
}
