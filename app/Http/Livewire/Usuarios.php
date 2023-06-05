<?php

namespace App\Http\Livewire;

use App\Models\Empleado;
use App\Models\Persona;
use App\Models\PuntoVenta;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Usuarios extends Component
{
    use WithPagination;

    public $nombre, $id_persona, $password, $password_confirmation, $rol, $update = false, $id_usuario;

    public function render()
    {
        $roles = Role::all();
        $personas = Persona::select('id',DB::raw("concat(nombres,' ',apellidos) as nombre_persona"))->get();

        return view('livewire.Usuarios.usuarios')
            ->with('roles',$roles)
            ->with('lista_usuarios',$this->lista_usuarios())
            ->with('personas', $personas)
            ->extends("welcome")->section("content");
    }

    /**
     *Método par traer una lista de los usuarios
     **/
    public function lista_usuarios()
    {
        return DB::table('personas')
            ->leftJoin('users','users.id_persona','=','personas.id')
            ->leftJoin('model_has_roles','model_has_roles.model_id','=','users.id')
            ->leftJoin('roles','roles.id','=','model_has_roles.role_id')
            ->select('users.name',DB::raw('concat(personas.nombres," ",personas.apellidos) as nombre_persona'),'roles.name as rol'
                ,'users.id')
            ->whereNotNull(['users.name'])->whereNull(['personas.deleted_at'])
            ->paginate(10);
    }

    /**
     * Método para resetear valores y validar si se esta actualizando un registro para ocultar el collapse en caso de cancelar
     * la actualizacion de datos
     **/
    public function resetear(){
        $this->emit('ocultar_collapse_usuario');
        $this->reset();
        $this->resetErrorBag();
    }

    /**
     * @Method acción para realizar un create o update dependiendo el estado de la variable booleana $update
     **/
    public function accion_usuario(){
        if ($this->update){
            $this->actualizar_usuario();
        }else{
            if ($this->nombre && $this->rol && $this->password){
                $this->crear_usuario();
            }else{
                session()->flash('error','Los campos deben de estar llenos.');
            }
        }
    }

    /**
     * @Method para crear el usuario
     * @param string [$nombre $password $password_confirm $rol]
     **/
    public function crear_usuario()
    {
        $this->validate(
            [
                'nombre' => 'required|max:10|min:1',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
                'id_persona' => 'required|unique:users,id_persona'
            ],
            [
                'nombre.required' => 'El nombre de usuario es requerido.',
                'password.required' => 'La contraseña es requerida.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
                'password_confirmation.required' => 'La confirmación de contraseña es requerida.',
                'id_persona.required' => 'La persona es requerida.',
                'id_persona.unique' => 'La persona debe de ser único.'
            ]);

            $crear = new User();
            $crear->name = $this->nombre;
            $crear->password = $this->password_verify($this->password, $this->password_confirmation);
            $crear->id_persona = $this->id_persona;
            $crear->save();
            $crear->assignRole($this->rol);
            $this->reset();
            $this->emit('ocultar_collapse_usuario');
            $this->emit('cerrar_alert');
            session()->flash('exito','Registro creado con éxito.');

    }

    /**
     * @Method para borrar el usuario con su respectivo rol
     * @param int $id
     **/
    public function borrar_usuario($id)
    {
        if ($id) {
            User::find($id)->delete();
            session()->flash('error','Registro eliminado con éxito.');
        }
    }

    /**
     * @Method para traer la informacion del usuario a editar
     **/
    public function info_usuario($id)
    {
        if ($id) {
            $info = User::find($id);
            $this->nombre = $info->name;
            $this->rol = $this->convert_collection($info->getRoleNames());
            $this->id_persona = $info->id_persona;
            $this->update = true;
            $this->id_usuario = $id;
            $this->emit('mostrar_collapse_usuario');
        }
    }

    /**
     * @Method para actualizar el usuario
     **/
    public function actualizar_usuario(){
        if ($this->id_usuario){
            $actualizar = User::find($this->id_usuario);
            if ($this->password){
                $this->password_verify($this->password, $this->password_confirmation) ?
                    $actualizar->update([
                        'name' => $this->nombre,
                        'id_persona' => $this->id_persona,
                        'password' => $this->password_verify($this->password, $this->password_confirmation)
                    ]) : null;
            }else{
                $actualizar->update([
                    'name' => $this->nombre,
                    'id_persona' => $this->id_persona
                ]);
            }
            $actualizar->removeRole($this->convert_collection($actualizar->getRoleNames()))->assignRole($this->rol);
            $this->reset();
            $this->emit('ocultar_collapse_usuario');
            $this->emit('cerrar_alert');
            session()->flash('exito','Registro actualizado con éxito.');
        }
    }

    /**
     * @Function para convertir una coleccion de un solo elemento a string
     **/
    function convert_collection($collection)
    {
        $string = "";
        foreach ($collection as $value) {
            $string = $value;
        }
        return $string;
    }

    /**
     * @Function para verificar las dos contraseñas
     **/
    function password_verify($pass, $pass_confirm){
        if ($pass == $pass_confirm){
            return bcrypt($pass);
        }else{
            $this->addError('not-match','Las contraseñas no coinciden');
        }
    }
}
