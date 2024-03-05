<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotStatus extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'bot_statuses';
    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $connection = 'mysql';
}
