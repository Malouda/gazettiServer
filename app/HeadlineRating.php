<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeadlineRating extends Model
{


    protected $table='headlinesrating';
    protected  $fillable=['user_id','headline_id','like','mixedThoughts','dontLike'];
}
