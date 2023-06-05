<?php

namespace App\Http\Livewire;

use App\Models\Comentario;
use App\Models\MiembrosEquipo;
use App\Models\Persona;
use App\Models\Proyecto;
use App\Models\RecursosMedia;
use App\Models\Tarea;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Tareas extends Component
{
    use WithPagination, WithFileUploads;

    public $titulo, $descripcion, $prioridad, $estado,$fecha_inicio, $nombre_responsable,$nombre_proyecto, $cuerpo,$archivos,$archivo_temporal,
        $fecha_fin, $id_proyecto, $id_responsable, $id_tarea, $update = false, $asignada = false, $delete = false, $comentario = false;
    public function render()
    {
        return view('livewire.Tareas.tareas')
            ->with('prioridades',['Alta','Media','Baja'])
            ->with('proyectos',$this->lista_proyectos())
            ->with('responsables', $this->lista_personas())
            ->with('tareas', $this->lista_tareas())
            ->with('comentarios', $this->lista_comentarios())
            ->extends('welcome')->section('content');
    }

    /**
     * @Method para resetear los valores
     **/
    public function resetear(){
        $this->delete ? $this->emit('ocultar_modal_borrar_tarea'):$this->emit('ocultar_collapse_tarea');
        $this->reset();
        $this->resetErrorBag();
    }

    /**
     * @Method Para traer la lista de tareas creadas
     **/
    public function lista_tareas(){
        $query = [];
        if (Auth::user()->hasRole('Administrador')){
            $query = Tarea::leftJoin('proyectos','proyectos.id','=','tareas.id_proyecto')
                ->leftJoin('personas','personas.id','=','tareas.id_responsable')
                ->select(DB::raw("concat(personas.nombres,' ',personas.apellidos) as responsable"),'tareas.id','tareas.titulo','tareas.estado',
                    'proyectos.nombre','tareas.prioridad')->whereNull('personas.deleted_at')->paginate(12);
        }elseif (Auth::user()->hasRole('Editor')){
            $id_equipo = MiembrosEquipo::where('id_persona', Auth::user()->id_persona)->pluck('id_equipo')->first();

            $query = Tarea::leftJoin('proyectos','proyectos.id','=','tareas.id_proyecto')
                ->leftJoin('personas','personas.id','=','tareas.id_responsable')
                ->select(DB::raw("concat(personas.nombres,' ',personas.apellidos) as responsable"),'tareas.id','tareas.titulo','tareas.estado',
                    'proyectos.nombre','tareas.prioridad')
                ->where('proyectos.id_equipo',$id_equipo)->whereNull('personas.deleted_at')
                ->paginate(12);
        }
        return $query;
    }

    /**
     * @Method Para traer la lista de los proyectos relacionados al equipo
     **/
    public function lista_proyectos(){
        $query = [];
        if (Auth::user()->hasRole('Administrador')){
            $query = DB::table('proyectos')
                ->leftJoin('equipos','equipos.id','=','proyectos.id_equipo')
                ->select('equipos.nombre as nombre_equipo','proyectos.nombre as nombre_proyecto','proyectos.id')->get();
        }else if (Auth::user()->hasRole('Editor')){
            $query = DB::table('proyectos')
                ->leftJoin('miembros_equipos','miembros_equipos.id_equipo','=','proyectos.id_equipo')
                ->leftJoin('equipos','equipos.id','=','proyectos.id_equipo')
                ->select('equipos.nombre as nombre_equipo','proyectos.nombre as nombre_proyecto','proyectos.id')
                ->where('miembros_equipos.id_persona',Auth::user()->id_persona)->get();
        }
        return $query;
    }

    /**
     * @Method Para traer la lista de las personas responsables para asignar
     **/
    public function lista_personas(){
        $query = [];
        if (Auth::user()->hasRole('Administrador')){
            $query = Persona::leftJoin('miembros_equipos','miembros_equipos.id_persona','=','personas.id')
                ->leftJoin('proyectos','proyectos.id_equipo','=','miembros_equipos.id_equipo')
                ->select(DB::raw("concat(personas.nombres,' ',personas.apellidos) as responsable"),'personas.id')
                ->where('proyectos.id',$this->id_proyecto)->get();
        }else if (Auth::user()->hasRole('Editor')){
            $query = Persona::leftJoin('miembros_equipos','miembros_equipos.id_persona','=','personas.id')
                ->select('personas.id',DB::raw("concat(personas.nombres,' ',personas.apellidos) as responsable"))
                ->where('miembros_equipos.id_equipo',Auth::user()->getIdEquipo())->get();
        }
        return $query;
    }

    /**
     * @Method Para traer el listado de todos los comentarios realizados en una tarea
     **/
    public function lista_comentarios(){
        return $this->comentario ? DB::table('comentarios')
            ->leftJoin('tareas','tareas.id','=','comentarios.id_tarea')
            ->leftJoin('users','users.id_persona','=','comentarios.id_persona')
            ->leftJoin('recursos_media','recursos_media.id_comentario','=','comentarios.id')
            ->select('comentarios.*','tareas.titulo','users.name','recursos_media.ruta')
            ->where('tareas.id',$this->id_tarea)->latest()->get():[];
    }

    /**
     * @Method Acción para crear o actualizar un registro dependiendo del estado $update
     **/
    public function accion_tarea(){
        if ($this->update){
            $this->actualizar_tarea();
        }else{
            $this->crear_tarea();
        }
    }

    public function crear_tarea(){
        $this->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'prioridad' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'id_proyecto' => 'required'
        ], $message = [
            'titulo.required' => 'El campo titulo es requerido.',
            'descripcion.required' => 'El campo descripcion es requerido.',
            'prioridad.required' => 'El campo prioridad es requerido.',
            'fecha_inicio.required' => 'El campo fecha inicio es requerido.',
            'fecha_fin.required' => 'El campo fecha fin es requerido.',
            'id_proyecto.required' => 'El campo proyecto es requerido.'
        ]);

        if ($this->fecha_inicio > $this->fecha_fin){
            session()->flash('error','La fecha fin no puede ser menor a la inicial');
        }else{
            Tarea::create([
                'titulo' => $this->titulo,
                'descripcion' => $this->descripcion,
                'prioridad' => $this->prioridad,
                'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin' => $this->fecha_fin,
                'id_proyecto' => $this->id_proyecto,
                'estado' => $this->id_responsable ? 'Asignada':'Creada',
                'id_responsable' => $this->id_responsable ? $this->id_responsable:null
            ]);
            session()->flash('exito', 'El registro fue creado con éxito.');
            $this->resetear();
            $this->emit('cerrar_alert');
        }
    }

    /**
     * @Method para traer la información del registro que se editará
     **/
    public function info_tarea($id){
        if ($id){
            $this->id_tarea = $id;
            $this->update = true;
            $datos = Tarea::find($id);
            $this->titulo = $datos->titulo;
            $this->descripcion = $datos->descripcion;
            $this->fecha_inicio = $datos->fecha_inicio;
            $this->fecha_fin = $datos->fecha_fin;
            $this->prioridad = $datos->prioridad;
            $this->id_proyecto = $datos->id_proyecto;
            $this->id_responsable = $datos->id_responsable;
            $this->emit('mostrar_collapse_tarea');
            $tarea = Tarea::where([['id',$id],['id_responsable', $this->id_responsable],['estado','En Proceso']])
                ->orWhere([['id',$id],['id_responsable', $this->id_responsable],['estado','Terminada']])->count();
            $this->asignada = $tarea > 0;
            $this->nombre_responsable = $this->id_responsable ?
                Persona::find($this->id_responsable)->select(DB::raw("concat(nombres,' ',apellidos) as responsable"))->first():null;
            $this->nombre_proyecto = $this->id_proyecto ?
                Proyecto::find($this->id_proyecto)->leftJoin('equipos','equipos.id','proyectos.id_equipo')
                    ->select(DB::raw("concat(proyectos.nombre,' | Equipo: ',equipos.nombre) as proyecto"))->first() : null;
        }
    }

    /**
     * @Method para actualizar el registro de una tarea
     **/
    public function actualizar_tarea(){
        if ($this->id_tarea){
            $this->validate([
                'titulo' => 'required',
                'descripcion' => 'required',
                'fecha_inicio' => 'required',
                'fecha_fin' => 'required',
                'prioridad' => 'required',
                'id_proyecto' => 'required',
                'id_responsable' => !$this->id_responsable ? 'nullable':'required'
            ], $message = [
                'titulo.required' => 'El campo titulo es requerido',
                'descripcion.required' => 'El campo descripcion es requerido.',
                'fecha_incio.required' => 'El campo fecha inicio es requerido',
                'fecha_fin.required' => 'El campo fecha fin es requerido',
                'prioridad.required' => 'El campo prioridad es requerido',
                'id_proyecto.required' => 'El campo proyecto es requerido',
                'id_responsable.required' => 'El campo responsable es requerido',
            ]);
            if ($this->fecha_inicio > $this->fecha_fin){
                session()->flash('error','La fecha fin no puede ser menor a la inicial');
            }else{
                $update = Tarea::find($this->id_tarea);
                $update->update([
                    'titulo' => $this->titulo,
                    'descripcion' => $this->descripcion,
                    'prioridad' => $this->prioridad,
                    'fecha_inicio' => $this->fecha_inicio,
                    'fecha_fin' => $this->fecha_fin,
                    'id_proyecto' => $this->id_proyecto,
                    'id_responsable' => !$this->id_responsable ? null:$this->id_responsable,
                    'estado' => $this->seleccionar_estado($this->id_responsable, $update->estado)
                ]);
                session()->flash('exito', 'El registro fue actualizado con éxito.');
                $this->resetear();
                $this->emit('cerrar_alert');
            }
        }
    }

    /**
     * @Method para borrar un registro de tarea
     **/
    public function borrar_tarea($id,bool $confirmacion){
        $this->id_tarea = $id;
        if ($confirmacion){
            if ($this->delete){
                Tarea::find($id)->delete();
                session()->flash('exito','Registro borrado con éxito.');
                $this->resetear();
            }else{
                $this->delete = true;
                $this->emit('mostrar_modal_borrar_tarea');
            }
        }else{
            Tarea::find($id)->delete();
            session()->flash('exito','Registro borrado con éxito.');
        }
    }

    /**
     * @Method para actualizar el estado de la tarea
     **/
    public function actualizar_estado($id, $estado){
        Tarea::find($id)->update(['estado' => $estado]);
        session()->flash('exito','Estado de la tarea actualizada con exito a '.$estado);
        $this->emit('cerrar_alert');
    }

    /**
     * @Method para abrir el modal para poder comentar las tareas
     **/
    public function abrir_comentarios($id){
        $this->id_tarea = $id;
        $this->comentario = true;
        $this->emit('mostrar_modal_comentarios');
    }

    /**
     * @Method Para crear un comentario
     **/
    public function crear_comentario(){
        $this->validate([
            'cuerpo' => 'required'
        ], $message = [
            'cuerpo.required' => 'El campo cuerpo es requerido.'
        ]);
        $comentario = Comentario::create([
            'id_tarea' => $this->id_tarea,
            'id_persona' => Auth::user()->id_persona,
            'cuerpo' => $this->cuerpo
        ]);
        $this->crear_recurso($this->archivos, $comentario->id);
        $this->lista_comentarios();
        $this->reset(['cuerpo','archivos']);
    }

    /**
     * @Function Para seleccionar el estado al momento de actualizar un registro de tarea que no tenga responsable asignado
     * o que tenga responsable asignado, pero que la tarea siga en estado 'Asignada'
     * @param $id
     * @param string $estado
     * @return string|void
     */
    function seleccionar_estado($id, $estado){
        if ($estado == 'Creada' && $id){
            return 'Asignada';
        }elseif ($estado == 'Creada' && !$id){
            return 'Creada';
        }elseif ($estado == 'Asignada' && $id){
            return 'Asignada';
        }elseif ($estado == 'Asignada' && !$id){
            return 'Creada';
        }elseif ($estado == 'En Proceso'){
            return 'En Proceso';
        }elseif ($estado == 'Terminada'){
            return 'Terminada';
        }
    }


    /**
     * @Method para crear un recurso medio
     **/
    public function crear_recurso($archivo, $id_comentario){
        if ($archivo){
            $archivo = Storage::disk('public')->put('Recursos-Media', $archivo);
            RecursosMedia::create([
                'ruta' => $archivo,
                'id_comentario' => $id_comentario,
                'id_persona' => Auth::user()->id_persona
            ]);
        }
    }

    /**
     * @Method para descargar el archivo relacionado al comentario
     **/
    public function descargar_archivo($ruta): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $ruta = Storage::url($ruta);
        return response()->download(public_path($ruta));
    }
}
