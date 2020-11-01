<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function subCategory(){
        return $this->hasMany('App\Models\Subcategory','slug_category','slug');
    }

    public function advert(){
        return $this->hasMany('App\Models\Advert',"slug_category","slug");
    }
}
