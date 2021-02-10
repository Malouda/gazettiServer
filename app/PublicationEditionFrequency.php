<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PublicationEditionFrequency extends Model
{

    protected $table='publicationeditionfrequency';
    protected $dates = ['edition_dates'];
    protected $fillable=['publication_id','edition_dates'];
}
