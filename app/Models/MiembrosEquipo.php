<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiembrosEquipo extends Model
{
    use HasFactory;

    protected $table = 'miembros_equipos';
    protected $fillable = ['id_persona','id_equipo'];
}
