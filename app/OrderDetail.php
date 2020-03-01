<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use SoftDeletes;
    protected $table = "order_details";
    protected $fillable = ['order_id','product_id','sale_quantity','price',];
    protected $dates = ['created_at','updated_at','deleted_at'];
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function order()
    {
        return $this->hasOne('App\Order');
    }
}
