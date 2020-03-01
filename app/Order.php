<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $table = "orders";
    protected $fillable = ['customer_name', 'customer_phone', 'customer_email', 'status_id', 'deliverer_id', 'create_date', 'total_price', 'delivery_address', 'note'];
    protected $dates = ['created_at', 'updated_at','deleted_at'];

    public function orderDetail()
    {
        return $this->hasOne('App\OrderDetail');
    }

    public function deliverer()
    {
        return $this->belongsTo('App\Deliverer');
    }

    public function status()
    {
        return $this->hasOne('App\Status', 'id', 'status_id');
    }
}
