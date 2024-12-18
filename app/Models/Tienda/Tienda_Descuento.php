<?php

namespace Code\Models\Tienda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tienda_Descuento extends Model
{
    use HasFactory;

    protected $table = 'tienda_descuento';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'cantidad',
        'tipo_cant',
        'tipo',
        'fechaInicio',
        'fechaFin',
        'activo',
        'estado'
    ];

    protected $guarded = [];

    public function productos()
    {
        return $this->belongsToMany(Tienda_Producto::class, 'tienda_descuento_producto', 'tienda_descuento_id', 'tienda_producto_id');
    }
}
