<?php

namespace App;
use Storage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    //
    protected $fillable= [
        'title', 'description', 'content', 'image', 'published_at', 'category_id'
    ];

    // Return void
    //Delete Image from storage
    public function deleteImage()
    {
    Storage::delete($this->image);
    }

    //Relationship to the category
    public function category(){
        return $this->belongsTo(Category::class);
    }

    //Relationship to tags
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    // Checks if post hasTags
    public function hasTag($tagId){
        return in_array($tagId, $this->tags->pluck('id')->toArray());
    }
}
