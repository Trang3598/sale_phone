<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Role extends Model
{
    use Notifiable;
    use HasRoles;
    protected $table = "roles";
    protected $fillable = ['name','guard_name','created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at'];
}
