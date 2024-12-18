<?php

namespace Code\Models\Cursos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cursos_Leccion extends Model
{
    use HasFactory;

    protected $table = 'cursos_leccion';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'descripcion',
        'categoria',
        'video',
        'curso',
        'recursos',
        'duracion',
        'estado'
    ];

    protected $guarded = [];
}
