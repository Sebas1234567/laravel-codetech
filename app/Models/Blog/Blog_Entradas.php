<?php

namespace Code\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog_Entradas extends Model
{
    use HasFactory;

    protected $table = 'blog_entradas';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'slug',
        'titulo',
        'imagen',
        'descripcion',
        'contenido',
        'fecha_publicacion',
        'idvideo',
        'idautor',
        'publicado',
        'estado'
    ];

    protected $guarded = [];

    public function categorias()
    {
        return $this->belongsToMany(Blog_Categoria::class, 'blog_entradas_categorias', 'blog_entradas_id', 'blog_categoria_id');
    }
}
