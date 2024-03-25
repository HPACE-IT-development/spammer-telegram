<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $table = 'actions';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function getStatusBackgroundAttribute()
    {
        return match ($this->action_status_id) {
            1 => 'primary',
            2 => 'warning',
            3 => 'success',
            4 => 'danger',
            default => 'light'
        };
    }

    public function getRecipientsAttribute($value): array
    {
        return json_decode($value);
    }

    public function status()
    {
        return $this->belongsTo(ActionStatus::class, 'action_status_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(ActionType::class, 'action_type_id', 'id');
    }

}
