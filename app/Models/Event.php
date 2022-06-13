<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
