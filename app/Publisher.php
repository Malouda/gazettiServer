<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{

    protected $table='publisher';
    protected $dates = ['account_expiry'];
    protected $fillable=['publisher_name','location_id','email','publisher_phone','maximum_employees','account_expiry','status','logo_url','publisher_delete'];
}
