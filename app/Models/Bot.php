<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'bots';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function getStatusBackgroundAttribute(): string
    {
        return match ($this->status_id) {
            2 => 'success',
            3 => 'danger',
            4 => 'warning',
            5 => 'dark',
            default => 'light'
        };
    }

    public function status()
    {
        return $this->belongsTo(BotStatus::class, 'status_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo(BotGroup::class, 'group_id', 'id');
    }
}
