<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Performer extends Pivot
{
    public $timestamps = false;
    public $incrementing = true;
    protected $table = 'performers';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function bot()
    {
        return $this->belongsTo(Bot::class, 'bot_id', 'id');
    }
}
