<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventCrowdManagement extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable = [
        'event_id',
        'number_of_applicants',
        'current_number_of_applicants',
        'saturated',
        'created_at',
        'updated_at',
    ];
}
