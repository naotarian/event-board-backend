<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $casts = [
        'event_tags' => 'json',
    ];
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
