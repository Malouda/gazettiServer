<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $table='publication';
    protected $fillable=['publisher_id','type_id','language_id','perspective_id','description','daily','weekly','maximum_headlines','minimum_headlines','logo_url','publication_email','publication_delete','publication_name','release_date'];
}
