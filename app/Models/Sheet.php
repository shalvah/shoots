<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Sheet extends Model
{
    protected $guarded = [];

    public function getChannelNameAttribute()
    {
        return "presence-sheet-$this->_id";
    }
}
