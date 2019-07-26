<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    public function venta()
    {
        return $this->belongsTo('App\Venta', 'venta_id');
    }
}
