<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoverPage extends Model
{
    protected $table='coverpage';
    protected $fillable=['publication_id','cover_page_url',
        'cover_page_removed','release_date','release_time','next_releasetime','next_release',
        'cover_page_blocked','perspective_id','user_id'];
}
