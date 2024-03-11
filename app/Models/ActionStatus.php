<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionStatus extends Model
{
    use HasFactory;

    protected $table = 'action_statuses';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
}
