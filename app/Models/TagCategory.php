<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tag;
class TagCategory extends Model
{
    use HasFactory;
    use softDeletes;
    public function tags()
    {
        return $this->hasMany(Tag::class, 'category_id');
    }
}
