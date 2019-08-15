<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $fillable=[
        'name'
    ];

    //Relation to Post
    public function posts(){
       return $this->belongsToMany(Post::class);
    }
}
