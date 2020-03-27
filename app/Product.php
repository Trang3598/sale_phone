<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = "products";
    protected $fillable = ['id_cate', 'name_phone', 'title', 'description', 'quantity', 'detail', 'price', 'size', 'memory', 'weight', 'cpu_speed', 'ram', 'os', 'camera_primary', 'battery', 'bluetooth', 'wlan', 'warranty','promotion_price', 'start_promotion', 'end_promotion', 'sale_phone', 'created_at', 'updated_at','thumbnail'];
    protected $dates = ['created_at', 'updated_at', 'start_promotion', 'end_promotion', 'deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\Category', 'id_cate', 'id');
    }

    public function salePhone()
    {
        return $this->hasOne('App\SalePhone','id','id');
    }

    public function orderDetail()
    {
        return $this->belongsTo('App\Order');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }

    public function image()
    {
        return $this->hasMany('App\Image');
    }

    public function color()
    {
        return $this->hasMany('App\Color');
    }
}
