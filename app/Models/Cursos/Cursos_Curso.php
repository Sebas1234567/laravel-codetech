<?php

namespace Code\Models\Cursos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cursos_Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos_curso';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'slug',
        'titulo',
        'descripcion',
        'contenido',
        'duracion',
        'cantidad_clases',
        'cantidad_recursos',
        'certificado',
        'precio',
        'idcategoria',
        'imagen',
        'fecha_publicacion',
        'estado'
    ];

    protected $guarded = [];
}
