<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $fillable = [
        'name'
    ];

    public function marcas()
    {
        return $this->hasMany('App\Marca');
    }
}
