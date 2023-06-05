<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tareas';
    protected $fillable = ['titulo','descripcion','prioridad','estado','fecha_inicio','fecha_fin','id_proyecto','id_responsable'];

}
