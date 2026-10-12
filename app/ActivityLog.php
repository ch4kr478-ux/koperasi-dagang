<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ActivityLog extends Model
{
    //
    use LogsActivity;

    protected $table = 'activity_log';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}
