<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    protected $table = "comments";
    protected $fillable = ['user_id', 'product_id', 'full_name', 'comment_time', 'comment_content', 'phone_number'];
    protected $dates = ['created_at', 'updated_at', 'comment_time','deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

}
