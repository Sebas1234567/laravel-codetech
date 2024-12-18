<?php

namespace Code\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificaciones extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'descripcion',
        'icono',
        'color',
        'url',
        'visto',
        'toast',
    ];

    protected $guarded = [];
}
