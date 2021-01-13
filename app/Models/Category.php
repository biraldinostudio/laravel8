<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table="categories";

    public function article(){
        //return $this->hasMany(Article::class);
        return $this->belongsToMany(Article::class,'article_categories');
    }

    public function articlecategory(){
        return $this->hasMany(Article::class);
    }
}
