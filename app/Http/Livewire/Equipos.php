<?php

namespace App\Http\Livewire;

use App\Models\Equipo;
use App\Models\MiembrosEquipo;
use App\Models\Persona;
use App\Models\Proyecto;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Equipos extends Component
{
    use WithPagination;

    public $nombre, $descripcion, $id_equipo, $id_persona, $update = false, $asignar = false, $delete = false, $nombre_proyecto;
    public function render()
    {
        return view('livewire.Equipos.equipos')
            ->with('equipos', $this->lista_equipos())
            ->with('personas', $this->lista_personas())
            ->with('miembros', $this->miembros_equipos())
            ->extends('welcome')->section('content');
    }

    public function resetear(){
        $this->delete ? $this->emit('ocultar_modal_borrar_equipo'):($this->asignar ?
            $this->emit('oculta_modal_asignar_miembro'):$this->emit('ocultar_collapse_equipo'));
        $this->reset();
        $this->resetErrorBag();
    }

    /**
     * @Method Para traer la lista de equipos
     **/
    public function lista_equipos(){
        return Equipo::paginate(12);
    }

    /**
     * @Method Para traer la lista de personas
     **/
    public function lista_personas(){
        return $this->asignar ? Persona::all():[];
    }

    /**
     * @Method Para traer los miembros de un equipo seleccionado
     **/
    public function miembros_equipos(){
        return $this->asignar ? DB::table('miembros_equipos')
            ->leftJoin('equipos','equipos.id','=','miembros_equipos.id_equipo')
            ->leftJoin('personas','personas.id','=','miembros_equipos.id_persona')
            ->select('miembros_equipos.id',DB::raw("concat(personas.nombres,' ',personas.apellidos) as nombre_persona"))
            ->where('miembros_equipos.id_equipo',$this->id_equipo)
            ->where('personas.deleted_at',null)
            ->get():[];
    }

    /**
     * @Method Accion para crear o actualizar un equipo dependiendo el estado de la variable $update
     **/
    public function accion_equipo(){
        if ($this->update){
            $this->actualizar_equipo();
        }else{
            $this->crear_equipo();
        }
    }

    /**
     * @Method Para crear un equipo
     **/
    public function crear_equipo(){
        $this->validate([
            'nombre' => 'required|unique:equipos,nombre',
            'descripcion' => 'required'
        ], $message = [
            'nombre.required' => 'El campo nombre es requerido.',
            'nombre.unique' => 'El campo nombre debe de ser único.',
            'descripcion.required' => 'El campo descripción es requerido.'
        ]);
        Equipo::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion
        ]);
        session()->flash('exito', 'Registro creado con éxito.');
        $this->resetear();
        $this->emit('cerrar_alert');
    }

    /**
     * @Method Para traer la información del equipo a actualizar
     **/
    public function info_equipo($id){
        if ($id){
            $this->id_equipo = $id;
            $datos = Equipo::find($id);
            $this->nombre = $datos->nombre;
            $this->descripcion = $datos->descripcion;
            $this->update = true;
            $this->emit('mostrar_collapse_equipo');
        }
    }

    /**
     * @Method Para actualizar el registro de un equipo
     **/
    public function actualizar_equipo(){
        if ($this->id_equipo){
            $this->validate([
                'nombre' => 'required|unique:equipos,nombre,'.$this->id_equipo,
                'descripcion' => 'required'
            ], $message = [
                'nombre.required' => 'El campo nombre es requerido.',
                'nombre.unique' => 'El campo nombre debe de ser único.',
                'descripcion.required' => 'El campo descripción es requerido.'
            ]);
            Equipo::find($this->id_equipo)->update([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion
            ]);
            session()->flash('exito', 'Registro actualizado con éxito.');
            $this->resetear();
            $this->emit('cerrar_alert');
        }
    }

    /**
     * @Method para borrar un equipo
     **/
    public function borrar_equipo($id, bool $confirmacion){
        if ($id){
            $this->id_equipo = $id;
            $confirmacion = Proyecto::where('id_equipo',$id)->count() >= 1;
            if ($confirmacion){
                if ($this->delete){
                    Equipo::find($id)->delete();
                    session()->flash('exito','Registro borrado con éxito.');
                    $this->emit('cerrar_alert');
                    $this->resetear();
                }else{
                    $this->nombre_proyecto = Proyecto::where('id_equipo',$id)->pluck('nombre')->first();
                    $this->delete = true;
                    $this->emit('mostrar_modal_borrar_equipo');
                }
            }else{
                Equipo::find($id)->delete();
                session()->flash('exito','Registro borrado con éxito.');
                $this->emit('cerrar_alert');
            }
        }
    }

    /**
     * @Method Para asignar una persona a un equipo
     **/
    public function asignar_equipo(){
        if ($this->id_equipo){
            $this->validate([
                'id_equipo' => 'required',
                'id_persona' => 'required|unique:miembros_equipos',
            ], $message = [
                'id_equipo.required' => 'El campo equipo es requerido.',
                'id_persona.required' => 'El campo persona es requerido.',
                'id_persona.unique' => 'El campo persona es único, solo puede asignarse una vez a un solo equipo.'
            ]);
            MiembrosEquipo::create([
                'id_persona' => $this->id_persona,
                'id_equipo' => $this->id_equipo
            ]);
            $this->miembros_equipos();
            $this->reset('id_persona');
        }
    }

    /**
     * @Method Para establecer valores al momento de abrir modal de asignar miembro
     **/
    public function establecer_valores($id){
        $this->asignar = true; // para saber que se esta en el modal de asignar miembro a un equipo
        $this->id_equipo = $id;
        $this->emit('mostrar_modal_asignar_miembro');
    }

    /**
     * @Method Para remover a un miembro de un equipo
     **/
    public function remover_miembro($id){
        if ($id){
            MiembrosEquipo::find($id)->delete();
            $this->miembros_equipos();
        }
    }
}
