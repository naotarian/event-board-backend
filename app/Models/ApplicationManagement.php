<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationManagement extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable = [
        'event_id',
        'application_number',
        'application_date',
        'cancel_date',
        'created_at',
        'updated_at',
    ];
}
