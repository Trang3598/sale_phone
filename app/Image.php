<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;
    protected $table = "images";
    protected $fillable = ['product_id', 'image', 'created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at','deleted_at'];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
