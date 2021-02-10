<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentRating extends Model
{
    protected $table='commentrating';
    protected $fillable=['user_id','user_id','comment','rating'];
}
