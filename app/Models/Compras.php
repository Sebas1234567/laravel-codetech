<?php

namespace Code\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compras extends Model
{
    use HasFactory;

    protected $table = 'compras';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'n_pedido',
        'fecha_compra',
        'metodo_pago',
        'total',
        'usuario',
        'estado'
    ];

    protected $guarded = [];
}
