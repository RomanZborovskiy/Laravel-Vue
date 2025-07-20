<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntakeMeat extends Model
{
    protected $fillable = [
        'user_id',
        'name',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function intakeMeat(){
        return $this->hasMany(MeatIntakeItem::class);
    }
}
