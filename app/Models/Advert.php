<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    use HasFactory;

    public function subCategory(){
        return $this->belongsTo('App\Models\Subcategory','slug_subcategory','slug');
    }

    public function city(){
        return $this->belongsTo('App\Models\City','slug_city',"slug");
    }

    public function category(){
        return $this->belongsTo('App\Models\Category','slug_category',"slug");
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id_advert');
    }

    public function favorite(){
        return $this->belongsTo('App\Models\favorite','advert_slug','slug');
    }

}
