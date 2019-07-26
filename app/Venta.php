<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function detalleVentas()
    {
        return $this->hasMany('App\DetalleVenta');
    }

    protected $fillable = [
        'user_id', 'total' ,'discount' ,'status'
    ];
}
