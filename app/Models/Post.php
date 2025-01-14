<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'image',
        'body',
        'published_at',
        'featured'
    ];
    protected $casts = [
        'published_at' => 'datetime'
    ];
    public function scopeHasCategories($query, string $category)
    {
        $query->whereHas('categories', function($query) use($category){
            $query->where('slug', $category);
        });
    }
    public function scopePopular($query){
        $query->withCount('likes')->orderBy('likes_count', 'desc');
    }
    public function scopeSearch($query, $search = '')
    {
        $query->where('title', 'like', "%{$search}%");
    }
    public function scopePublished($query)
    {
     $query->where('published_at', '!=', null);   
    }
    public function scopeFeatured($query)
    {
        $query->where('featured', true);
    }
    public function getImage(){
        if(str_starts_with($this->image, 'http')){
            return $this->image;
        }
        return "/storage/$this->image";
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_like')->withTimestamps();
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function excerptText()
    {
        return Str::limit(strip_tags($this->body, 100));
    }
    public function readingTIme()
    {
        $mins = round(str_word_count($this->body) / 250);
        return ($mins < 1) ? 1 : $mins;
    }
}
