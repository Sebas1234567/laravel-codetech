<?php

namespace Code\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog_Autor extends Model
{
    use HasFactory;

    protected $table = 'blog_autor';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado'
    ];

    protected $guarded = [];
}
