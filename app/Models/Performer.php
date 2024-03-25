<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Performer extends Pivot
{
    public $timestamps = false;

    protected $table = 'performers';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
