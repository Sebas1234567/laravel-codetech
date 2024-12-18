<?php

namespace Code\Models\Tienda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tienda_Giftcard extends Model
{
    use HasFactory;

    protected $table = 'tienda_giftcard';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'saldo',
        'valor',
        'nota',
        'usado',
        'estado'
    ];

    protected $guarded = [];
}
