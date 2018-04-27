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

    public function isEmpty(): bool
    {
        if ($this->content == [[]]) {
            return true;
        }

        foreach ($this->content as $row) {
            foreach ($row as $cell) {
                if (!is_null($cell)) {
                    return false;
                }
            }
        }

        return true;
    }
}
