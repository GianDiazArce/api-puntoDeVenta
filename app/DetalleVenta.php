<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $fillable = [
        'modelo_id', 'venta_id', 'quantity', 'price'
    ];

    public function venta()
    {
        return $this->belongsTo('App\Venta', 'venta_id');
    }

    public function modelo()
    {
        return $this->belongsTo('App\Modelo', 'modelo_id');
    }

}
