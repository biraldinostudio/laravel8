<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $table="articles";
    protected $fillable=[
        //'category_id',
        'title',
        'content',
        'file',
    ];

    public function articlecategory(){
        return $this->hasMany(ArticleCategory::class);
    }

    public function category(){
        //return $this->belongsTo(Category::class);
        return $this->belongsToMany(Article::class,'article_categories','article_id','category_id');
    }
}
