<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotGroup extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'bot_groups';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $connection = 'mysql';

    public function bots()
    {
        return $this->hasMany(Bot::class, 'group_id', 'id');
    }
}
