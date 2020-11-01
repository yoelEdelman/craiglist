<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Subcategory extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo('App\Models\Category','slug_category',"slug");
    }
    public function advert(){
        return $this->hasMany('App\Models\Advert','slug_subcategory',"slug");
    }
}
