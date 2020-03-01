<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use Notifiable;
    use SoftDeletes;
    protected $table = "categories";
    protected $fillable = ['category_name', 'created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public function product()
    {
        return $this->hasMany('App\Product', 'id_cate', 'id');
    }
}
