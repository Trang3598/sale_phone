<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalePhone extends Model
{
    use SoftDeletes;
    protected $table = "sale_phones";
    protected $fillable = ['phone_id', 'quantity','updated_at'];
    protected $dates = ['created_at', 'updated_at','deleted_at'];

    public function product()
    {
        return $this->hasOne('App\Product','id','phone_id');
    }

}
