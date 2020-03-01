<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use SoftDeletes;
    protected $table = "colors";
    protected $fillable = ['product_id', 'color_name', 'created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
