<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $table='invite';
    protected $fillable=['inviter_id','invited_id','used','invited_phone','token','group_id','publication_id'];
}
