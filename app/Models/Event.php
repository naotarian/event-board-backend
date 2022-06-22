<?php

namespace App\Models;
use App\Models\User;
use App\Models\EventCrowdManagement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Database\Factories\EventFactory;

class Event extends Model
{
    use HasFactory;
    use softDeletes;
    protected $casts = [
        'event_tags' => 'json',
    ];
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    public function event_crowd_management() {
        return $this->hasOne('App\Models\EventCrowdManagement');
    }
    protected static function newFactory() {
        return EventFactory::new();
    }
}
