<?php

namespace Code\Models\Tienda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tienda_Producto_Valoracion extends Model
{
    use HasFactory;

    protected $table = 'tienda_producto_valoracion';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'usuario',
        'fecha_publicacion',
        'puntuacion',
        'comentario',
        'estado',
        'producto',
    ];

    protected $guarded = [];
}
