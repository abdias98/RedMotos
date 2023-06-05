<?php

namespace App\Http\Livewire;

use App\Models\MiembrosEquipo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Inicio extends Component
{
    public $tareas = [];

    public function mount(){
        $array = [];
        $datos = [];
        if (Auth::user()->hasRole('Administrador')){
            $datos = DB::table('tareas')
                ->leftJoin('proyectos','proyectos.id','=','tareas.id_proyecto')
                ->leftJoin('personas','personas.id','=','tareas.id_responsable')
                ->select('tareas.*','personas.nombres','personas.apellidos')
                ->where('tareas.estado','!=','Creada')
                ->where('tareas.estado','!=','Terminada')
                ->get();
        }elseif (Auth::user()->hasRole('Editor')){
            $id_equipo = MiembrosEquipo::where('id_persona', Auth::user()->id_persona)->pluck('id_equipo')->first();
            $datos = DB::table('tareas')
                ->leftJoin('proyectos','proyectos.id','=','tareas.id_proyecto')
                ->leftJoin('personas','personas.id','=','tareas.id_responsable')
                ->select('tareas.*','personas.nombres','personas.apellidos')
                ->where('proyectos.id_equipo',$id_equipo)
                ->where('tareas.estado','!=','Creada')
                ->where('tareas.estado','!=','Terminada')
                ->get();
        }
        //Foreach para crear un arreglo que almacene la información de las tareas a mostrar y posteriormente usarlos en el plugin de FullCalendar
        foreach ($datos as $item){
            $array[] = [
                'title' => $item->nombres . ' ' . $item->apellidos,
                'start' => "".$item->fecha_inicio,
                'end' => "".Carbon::parse($item->fecha_fin)->addDay(1),
                'color' => '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6),
                'allDay' => true
            ];
        }
        $this->tareas = $array;
    }
    public function render()
    {
        return view('livewire.Inicio.inicio')
            ->with('lista_tareas', $this->tareas)
            ->extends('welcome')->section('content');
    }
}
