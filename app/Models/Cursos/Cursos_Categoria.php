<?php

namespace Code\Models\Cursos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cursos_Categoria extends Model
{
    use HasFactory;

    protected $table = 'cursos_categoria';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado'
    ];

    protected $guarded = [];
}
