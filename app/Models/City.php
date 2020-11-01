<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'zipcode'
    ];
    public function city(){
        return $this->hasMany('App\Models\Advert','slug_city','slug');
    }
}
