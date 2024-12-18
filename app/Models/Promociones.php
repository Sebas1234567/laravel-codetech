<?php

namespace Code\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promociones extends Model
{
    use HasFactory;

    protected $table = 'promocion';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'porcentaje',
        'imagen',
        'estado'
    ];

    protected $guarded = [];
}
