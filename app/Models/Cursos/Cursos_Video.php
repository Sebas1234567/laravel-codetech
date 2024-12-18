<?php

namespace Code\Models\Cursos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class Cursos_Video extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'cursos_video';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'calidad',
        'extension',
        'videos',
        'subtitulos',
        'poster',
        'estado'
    ];

    protected $guarded = [];

    public function newUniqueId(): string
    {
        return (string) Uuid::uuid4();
    }

    public function uniqueIds(): array
    {
        return ['id'];
    }
}
