<?php

namespace Code\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog_Categoria extends Model
{
    use HasFactory;

    protected $table = 'blog_categoria';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'padre_id',
        'estado'
    ];

    protected $guarded = [];

    public function entradas()
    {
        return $this->belongsToMany(Blog_Entradas::class, 'blog_entradas_categorias', 'blog_categoria_id', 'blog_entradas_id');
    }

    public function hijos()
    {
        return $this->hasMany(Blog_Categoria::class, 'padre_id', 'id');
    }
}
