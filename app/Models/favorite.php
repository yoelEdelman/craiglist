<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class favorite extends Model
{
    use HasFactory;

    public function advert(){
        return $this->belongsTo('App\Models\Advert','advert_slug', 'slug');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id_connected', 'id');
    }
}
