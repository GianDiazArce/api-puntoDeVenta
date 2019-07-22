<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Talla extends Model
{
    protected $fillable = [
        'name'
    ];

    public function modelos()
    {
        return $this->hasMany('App\Modelo', 'talla_id');
    }
}
