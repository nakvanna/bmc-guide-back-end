<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['title', 'post_by', 'description'];

    public function blog_gallery(){
        return $this->hasMany(BlogGallery::class)->select();
    }
}
