<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    protected $fillable = [
        'tipo_id', 'talla_id' ,'marca_id' ,'name', 'stock'
    ];
    
    public function talla()
    {
        return $this->belongsTo('App\Talla', 'talla_id');
    }

    

    public function marca()
    {
        return $this->belongsTo('App\Marca', 'marca_id');
    }
    public function detalleVentas()
    {
        return $this->hasMany('App\DetalleVenta');
    }
}
