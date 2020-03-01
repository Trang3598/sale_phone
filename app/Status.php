<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;
    protected $table = "status";
    protected $fillable = ['status_name', 'created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function order()
    {
        return $this->hasOne('App\Order', 'id', 'id');
    }
}
