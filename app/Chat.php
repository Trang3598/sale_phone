<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = "chats";
    protected $fillable = ['name','content','ip','type'];
    protected $dates = ['created_at', 'updated_at'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
