<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table='user_groups';
    protected $fillable=['user_group_name'];
}
