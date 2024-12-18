<?php

namespace Code\Models\Tienda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tienda_Producto extends Model
{
    use HasFactory;

    protected $table = 'tienda_producto';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'sku',
        'titulo',
        'descripcion',
        'contenido',
        'fecha_publicacion',
        'precio',
        'imagen',
        'galeria_imagenes',
        'descripcion_imagenes',
        'demo',
        'archivo',
        'publicado',
        'estado',
    ];

    protected $guarded = [];

    public function categorias()
    {
        return $this->belongsToMany(Tienda_Categoria::class, 'tienda_producto_categoria', 'tienda_producto_id', 'tienda_categoria_id');
    }

    public function descuentos()
    {
        return $this->belongsToMany(Tienda_Descuento::class, 'tienda_descuento_producto', 'tienda_producto_id', 'tienda_descuento_id');
    }
}
