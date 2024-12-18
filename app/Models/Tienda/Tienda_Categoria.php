<?php

namespace Code\Models\Tienda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tienda_Categoria extends Model
{
    use HasFactory;

    protected $table = 'tienda_categoria';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'padre_id',
        'estado'
    ];

    protected $guarded = [];

    public function productos()
    {
        return $this->belongsToMany(Tienda_Producto::class, 'tienda_producto_categoria', 'tienda_categoria_id', 'tienda_producto_id');
    }
}
