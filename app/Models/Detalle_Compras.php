<?php

namespace Code\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle_Compras extends Model
{
    use HasFactory;

    protected $table = 'detalle_compra';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'compra',
        'producto',
        'curso',
        'cantidad',
        'precio_unitario',
        'descuento',
        'subtotal'
    ];

    protected $guarded = [];
}
