<?php

namespace App\Http\Livewire;

use App\Models\Persona;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Personas extends Component
{
    use WithPagination;

    public $nombres, $apellidos, $sexo, $fecha_nacimiento, $correo_electronico, $telefono,$update = false, $id_persona, $delete = false;

    public function render()
    {
        return view('livewire.Personas.personas')
            ->with('personas', $this->lista_personas())
            ->extends('welcome')->section('content');
    }

    /**
     * @Method para resetear todos los valores y ocultar el collapse de crear persona
     **/
    public function resetear(){
        $this->delete ? $this->emit('ocultar_modal_borrar_persona'):$this->emit('ocultar_collapse_persona');
        $this->reset();
        $this->resetErrorBag();
    }

    /**
     * @Method para traer el listado de personas registradas en el sistema
     **/
    public function lista_personas(){
        return Persona::select('correo_electronico',DB::raw("concat(nombres,' ',apellidos) as nombre_persona"),'telefono','id','sexo',
            'fecha_nacimiento')
            ->paginate(12);
    }

    /**
     * @Method para poder crear o actualizar el registro de las personas de acuerdo al estado $update
     **/
    public function accion_personas(){
        if ($this->update){
            $this->actualizar_persona();
        }else{
            $this->crear_persona();
        }
    }

    /**
     * @Method para crear un registro de las personas
     **/
    public function crear_persona(){
        $this->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'sexo' => 'required',
            'fecha_nacimiento' => 'required',
            'telefono' => 'required',
            'correo_electronico' => 'required|email'
        ],$message = [
            'nombres.required' => 'El campo nombre es requerido.',
            'apellidos.required' => 'El campo apellido es requerido.',
            'sexo.required' => 'El campo sexo es requerido.',
            'fecha_nacimiento.required' => 'El campo fecha de nacimiento es requerido.',
            'telefono.required' => 'El campo teléfono es requerido.',
            'correo_electronico.required' => 'El campo correo es requerido.',
            'correo_electronico.email' => 'El campo correo es de tipo email.'
        ]);
        Persona::create([
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'sexo' => $this->sexo,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'correo_electronico' => $this->correo_electronico,
            'telefono' => $this->telefono
        ]);

        session()->flash('exito','Registro creadot con éxito.');
        $this->resetear();
        $this->emit('cerrar_alert');
    }

    public function info_persona($id){
        if ($id){
            $this->id_persona = $id;
            $this->update = true;
            $datos = Persona::find($this->id_persona);
            $this->nombres = $datos->nombres;
            $this->apellidos = $datos->apellidos;
            $this->sexo = $datos->sexo;
            $this->fecha_nacimiento = $datos->fecha_nacimiento;
            $this->telefono = $datos->telefono;
            $this->correo_electronico = $datos->correo_electronico;
            $this->emit('mostrar_collapse_persona');
        }
    }

    public function actualizar_persona(){
        if ($this->id_persona){
            $this->validate([
                'nombres' => 'required',
                'apellidos' => 'required',
                'sexo' => 'required',
                'fecha_nacimiento' => 'required',
                'telefono' => 'required',
                'correo_electronico' => 'required|email'
            ],$message = [
                'nombres.required' => 'El campo nombre es requerido.',
                'apellidos.required' => 'El campo apellido es requerido.',
                'sexo.required' => 'El campo sexo es requerido.',
                'fecha_nacimiento.required' => 'El campo fecha de nacimiento es requerido.',
                'telefono.required' => 'El campo teléfono es requerido.',
                'correo_electronico.required' => 'El campo correo es requerido.',
                'correo_electronico.email' => 'El campo correo es de tipo email.'
            ]);
            Persona::find($this->id_persona)->update([
                'nombres' => $this->nombres,
                'apellidos' => $this->apellidos,
                'sexo' => $this->sexo,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'correo_electronico' => $this->correo_electronico,
                'telefono' => $this->telefono
            ]);
            session()->flash('exito','Registro actualizado con éxito.');
            $this->resetear();
            $this->emit('cerrar_alert');
        }
    }

    public function borrar_persona($id){
        $this->id_persona = $id;
        if ($this->delete){
            Persona::find($id)->delete();
            session()->flash('exito','Registro borrado con éxito.');
            $this->emit('cerrar_alert');
            $this->resetear();
        }else{
            $this->delete = true;
            $this->emit('mostrar_modal_borrar_persona');
        }
    }
}
