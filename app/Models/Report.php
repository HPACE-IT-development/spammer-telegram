<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function getSessionsErrorsAttribute($value)
    {
        return json_decode($value);
    }

    public function getInfoAboutRecipientsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getCompletionPercentageAttribute(): int
    {
        return (!$this->completed_recipients_amount)? 0: (100*$this->completed_recipients_amount) / $this->total_recipients_amount;
    }

    public function status()
    {
        return $this->belongsTo(ReportStatus::class, 'report_status_id', 'id');
    }
}
