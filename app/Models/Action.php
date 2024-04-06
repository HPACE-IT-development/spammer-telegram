<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public function getFirstImageAttribute(): ?string
    {
        return ($this->images->first())? Storage::url($this->images->first()->path): null;
    }

    public function status()
    {
        return $this->belongsTo(ActionStatus::class, 'action_status_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(ActionType::class, 'action_type_id', 'id');
    }

    public function performers()
    {
        return $this->belongsToMany(Bot::class, 'performers', 'action_id', 'bot_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'action_id', 'id');
    }
}
