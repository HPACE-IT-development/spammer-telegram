<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionType extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'action_types';
    protected $guarded = [];
    public $timestamps = false;
}
