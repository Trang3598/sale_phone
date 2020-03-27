<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageFeedback extends Model
{
    protected $table = "image_feedbacks";
    protected $fillable = ['image', 'comment_id', 'created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at'];

    public function comment()
    {
        return $this->belongsTo('App\Comment');
    }
}
