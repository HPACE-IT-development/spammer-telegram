<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
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
            2 => 'info',
            3 => 'warning',
            4 => 'success',
            default => 'light'
        };
    }

    public function getRecipientsAttribute($value): array
    {
        return json_decode($value);
    }

    public function getRecipientsCollectionAttribute(): Collection
    {
        return collect($this->recipients);
    }

    public function getFirstImageUrlAttribute(): ?string
    {
        return ($this->images->first())? asset('storage/'.$this->images->first()->path): null;
    }

    public function getFirstImageFullPathAttribute(): ?string
    {
        return ($this->images->first())? Storage::path($this->images()->first()->path): null;
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

    public function report()
    {
        return $this->hasOne(Report::class, 'action_id', 'id');
    }
}
