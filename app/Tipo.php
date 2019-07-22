<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $fillable = [
        'name'
    ];

    public function modelos()
    {
        return $this->hasMany('App\Modelo');
    }
}
