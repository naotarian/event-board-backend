<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventContact extends Model
{
    use HasFactory;
    use softDeletes;
    use Traits\Encryptable;
    protected $fillable = [
        'user_id',
        'user_name',
        'email',
        'event_id',
        'contents',
        'contact_number',
        'contact_date',
        'created_at',
        'updated_at',
    ];
    protected $encryptable = [
        "user_name",
        "email",
        "contents",
    ];
    Public function getEmailAttribute($value){
        $aes_key = config('app.aes_key');
        $aes_type = config('app.aes_type');
        return empty($value) ? null : openssl_decrypt($value, $aes_type, $aes_key);
    }
    Public function getUserNameAttribute($value){
        $aes_key = config('app.aes_key');
        $aes_type = config('app.aes_type');
        return empty($value) ? null : openssl_decrypt($value, $aes_type, $aes_key);
    }
    Public function getContentsAttribute($value){
        $aes_key = config('app.aes_key');
        $aes_type = config('app.aes_type');
        return empty($value) ? null : openssl_decrypt($value, $aes_type, $aes_key);
    }
}
