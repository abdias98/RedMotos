<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecursosMedia extends Model
{
    use HasFactory;

    protected $table = 'recursos_media';
    protected $fillable = ['ruta','id_comentario','id_persona'];
}
