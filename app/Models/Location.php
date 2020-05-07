<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'user_id','viewer', 'name', 'category', 'sub_category', 'location_coord', 'thumbnail', 'website', 'tel', 'email', 'can_do', 'about'
    ];
    public function gallery()
    {
        return $this->hasMany(Gallery::class)->select();
    }
}
