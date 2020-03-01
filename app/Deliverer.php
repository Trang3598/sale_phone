<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deliverer extends Model
{
    use SoftDeletes;
    protected $table = "deliverer";
    protected $fillable = ['deliverer_name', 'deliverer_phone', 'created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at','deleted_at'];

    public function order()
    {
        return $this->hasMany('App\Order');
    }
}
