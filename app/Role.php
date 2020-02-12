<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    
    // Relationship with users
    public function users(){
        return $this->belongsToMany('App\User', 'role_user', 'role_id', 'user_id');
    }
}
