<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Headline extends Model
{
    protected $table='headlines';
    protected $fillable=['publication_id','section_id',
        'heading','subheading','briefnote',
        'image_url','headline_blocked',
        'headline_removed','perspective_id',
        'release_date','release_time','user_id','next_release','next_releasetime'];
}
