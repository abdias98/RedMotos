<?php

namespace App\Http\Livewire;

use App\Models\Equipo;
use App\Models\Persona;
use App\Models\Proyecto;
use App\Models\ProyectosEquipo;
use App\Models\Tarea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Proyectos extends Component
{
    use WithPagination;

    public $nombre, $descripcion, $fecha_inicio, $fecha_fin, $id_proyecto, $id_equipo, $update = false, $tareas_creadas = false, $nombre_equipo;
    public function render()
    {
        return view('livewire.Proyectos.proyectos')
            ->with('proyectos', $this->lista_proyectos())
            ->with('equipos', $this->lista_equipos())
            ->with('tareas_proyecto', $this->lista_tareas())
            ->extends('welcome')->section('content');
    }

    public function resetear(){
        if ($this->tareas_creadas && $this->update){
            $this->emit('ocultar_collapse_proyecto');
        }elseif ($this->tareas_creadas){
            $this->emit('ocultar_modal_eliminar_proyecto');
        }else{
            $this->emit('ocultar_collapse_proyecto');
        }
        $this->reset();
        $this->resetErrorBag();
    }

    /**
     * @Method para traer la lista de proyectos
     **/
    public function lista_proyectos(){
        return DB::table('proyectos')
            ->leftJoin('equipos','equipos.id','=','proyectos.id_equipo')
            ->select('proyectos.*','equipos.nombre as nombre_equipo')->paginate(12);
    }

    /**
     * @Method para traer la lista de equipos para relacionarlo con los proyectos
     **/
    public function lista_equipos(){
        $query = [];
        if (Auth::user()->hasRole('Administrador')){
            $query = Equipo::all();
        }elseif (Auth::user()->hasRole('Editor')){
            $query = DB::table('equipos')
                ->leftJoin('miembros_equipos','miembros_equipos.id','=','equipos.id_equipo')
                ->leftJoin('personas','personas.id','=','miembros_equipos.id_persona')
                ->select('equipos.*')->where('miembros_equipos.id_persona', Auth::user()->id_persona);
        }
        return $query;
    }

    /**
     * @Method para traer la lista de tareas asignadas a un proyecto
     **/
    public function lista_tareas(){
        return $this->tareas_creadas ?
            Tarea::leftJoin('personas','personas.id','=','tareas.id_responsable')
                ->select('tareas.titulo','tareas.estado', DB::raw("concat(personas.nombres,' ',personas.apellidos) as responsable"))
                ->where('id_proyecto',$this->id_proyecto)
                ->whereNull('personas.deleted_at')
                ->get():[];
    }

    /**
     * @Method acción para crear o actualizar un registro de proyecto
     **/
    public function accion_proyecto(){
        if ($this->update){
            $this->actualizar_proyecto();
        }else{
            $this->crear_proyecto();
        }
    }

    /**
     * @Method para crear un registro de proyecto
     **/
    public function crear_proyecto(){
        $this->validate([
            'nombre' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'id_equipo' => 'required'
        ], $message = [
            'nombre.required' => 'El campo nombre es requerido.',
            'fecha_inicio.required' => 'El campo fecha inicio es requerido.',
            'fecha_fin.required' => 'El campo fecha fin es requerido.',
            'id_equipo.required' => 'El campo equipo es requerido.'
        ]);
        $crear = Proyecto::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'id_equipo' => $this->id_equipo
        ]);
        session()->flash('exito', 'Registro creado con éxito.');
        $this->resetear();
        $this->emit('cerrar_alert');
    }

    /**
     * @Method para traer la información del registro de proyecto a actualizar
     **/
    public function info_proyecto($id){
        if ($id){
            $this->id_proyecto = $id;
            $datos = Proyecto::find($id);
            $this->nombre = $datos->nombre;
            $this->descripcion = $datos->descripcion;
            $this->fecha_inicio = $datos->fecha_inicio;
            $this->fecha_fin = $datos->fecha_fin;
            $this->tareas_creadas = Tarea::where('id_proyecto',$this->id_proyecto)->count() >= 1;
            $this->nombre_equipo = Equipo::find($datos->id_equipo)->pluck('nombre')->first();
            $this->id_equipo = $datos->id_equipo;
            $this->update = true;
            $this->emit('mostrar_collapse_proyecto');
        }
    }

    /**
     * @Method para actualizar el registro de proyecto seleccionado
     **/
    public function actualizar_proyecto(){
        $this->validate([
            'nombre' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'id_equipo' => 'required'
        ], $message = [
            'nombre.required' => 'El campo nombre es requerido.',
            'fecha_inicio.required' => 'El campo fecha inicio es requerido.',
            'fecha_fin.required' => 'El campo fecha fin es requerido.',
            'id_equipo.required' => 'El campo equipo es requerido.'
        ]);
        //validar si ya hay tareas asignadas del proyecto a actualizar, si hay se evitara la actualizacion
        Proyecto::find($this->id_proyecto)->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'id_equipo' => $this->id_equipo
        ]);

        session()->flash('exito','Registro actualizado con éxito.');
        $this->emit('cerrar_alert');
        $this->resetear();
    }

    /**
     * @Method para borrar el registro del proyecto
     **/
    public function borrar_proyecto($id,$confirmacion){
        $this->id_proyecto = $id;
        if (!$confirmacion){
            if (Persona::leftJoin('tareas','tareas.id_responsable','=','personas.id')->where('id_proyecto',$id)->count()>=1){
                $this->tareas_creadas = true;//Poner estado verdadero para evitar que se pueda asignar un equipo si ya hay tareas asignadas y para cerrar el modal
                $this->emit('mostrar_modal_eliminar_proyecto');
            }else{
                Proyecto::find($id)->delete();
                session()->flash('exito','Registro eliminado con éxito.');
            }
        }else{
            Proyecto::find($id)->delete();
            session()->flash('exito','Registro eliminado con éxito.');
            $this->resetear();
        }
        $this->emit('cerrar_alert');
    }
}
