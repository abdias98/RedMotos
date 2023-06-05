<?php

namespace App\Http\Livewire;

use App\Models\Equipo;
use App\Models\Persona;
use App\Models\Proyecto;
use App\Models\Tarea;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use function Illuminate\Events\queueable;

class Reportes extends Component
{

    public $tab_proyectos = true, $tab_tareas = false, $tab_personas = false;
    public $id_equipo, $estado_proyecto, $estado_tarea, $id_proyecto, $id_equipo_personas;
    public function render()
    {
        $equipos = Equipo::all();
        $proyectos = Proyecto::leftJoin('equipos','equipos.id','=','proyectos.id_equipo')
            ->select('proyectos.id','proyectos.nombre','equipos.nombre as equipo')->get();

        return view('livewire.Reportes.reportes')
            ->with('equipos', $equipos)
            ->with('proyectos', $proyectos)
            ->with('lista_proyectos',$this->lista_proyectos())
            ->with('lista_tareas', $this->lista_tareas())
            ->with('lista_personas', $this->lista_personas())
            ->extends('welcome')->section('content');
    }

    /**
     * @Method para resetear los filtros de buscada dependiendo el tab en el que se encuentre
     **/
    public function resetear(){
        if ($this->tab_proyectos){
            $this->reset(['id_equipo','estado_proyecto']);
        }elseif ($this->tab_tareas){
            $this->reset(['id_proyecto','estado_tarea']);
        }elseif ($this->tab_personas){
            $this->reset('id_equipo_personas');
        }

    }

    /**
     * @Method Para traer a lista de proyectos según los filtros que se le apliquen
     **/
    public function lista_proyectos()
    {
        $query_final = [];
        $sql = '(SELECT COUNT(titulo) FROM tareas where id_proyecto = proyectos.id and tareas.estado = "En Proceso" or
            id_proyecto = proyectos.id and tareas.estado = "Terminada")';//contar tareas que esten en proceso o terminadas para traer los datos
        $en_proceso = '(SELECT COUNT(titulo) FROM tareas where id_proyecto = proyectos.id and tareas.estado = "En Proceso")';// tareas en proceso
        $terminada = '(SELECT COUNT(titulo) FROM tareas where id_proyecto = proyectos.id and tareas.estado = "Terminada")';//tareas terminadas
        $total_tareas = '(SELECT COUNT(titulo) FROM tareas where id_proyecto = proyectos.id)';//total de tareas por proyecto

        if ($this->estado_proyecto == 'Creado'){
            $query = Proyecto::leftJoin('equipos','equipos.id','=','proyectos.id_equipo')
                ->leftJoin('tareas','tareas.id_proyecto','=','proyectos.id')
                ->select('proyectos.nombre','proyectos.fecha_inicio','proyectos.fecha_fin','equipos.nombre as nombre_equipo')
                ->whereNull('tareas.titulo')->where('equipos.id', $this->id_equipo)
                ->orWhereNull('tareas.titulo')->get();
            foreach ($query as $item) {
                $item->estado = 'Creado';
                $item->porcentaje = 0;
            }
        }elseif ($this->estado_proyecto == 'En proceso'){
            $query = Proyecto::leftJoin('equipos','equipos.id','=','proyectos.id_equipo')
                ->select('proyectos.nombre','proyectos.fecha_inicio','proyectos.fecha_fin','equipos.nombre as nombre_equipo',
                    DB::raw($en_proceso.' as en_proceso'), DB::raw($terminada.' as terminada'), DB::raw($total_tareas.' as total'));
            if ($this->id_equipo){
                $query_final = $query->where('equipos.id', '=', $this->id_equipo)
                    ->whereDate('proyectos.fecha_fin','>=',Carbon::now())
                    ->where(DB::raw($sql),'>=',1)
                    ->whereRaw($total_tareas.'>'.$terminada)
                    ->get();
            }else{
                $query_final = $query->whereDate('proyectos.fecha_fin','>=',Carbon::now())
                    ->where(DB::raw($sql),'>=',1)
                    ->whereRaw($total_tareas.'>'.$terminada)->get();
            }

            foreach ($query_final as $item) {
                $item->estado = 'En Proceso';
                $item->porcentaje = (($item->terminada / $item->total) * 100) + ((($item->en_proceso * 0.5)/$item->total) * 100);
            }
        }elseif ($this->estado_proyecto == 'Terminado'){
            $query = Proyecto::leftJoin('equipos', 'equipos.id', '=', 'proyectos.id_equipo')
                ->select('proyectos.nombre', 'proyectos.fecha_inicio', 'proyectos.fecha_fin', 'equipos.nombre as nombre_equipo',
                    DB::raw($terminada . ' as terminada'), DB::raw($total_tareas . ' as total'));
            if ($this->id_equipo){
                $query_final = $query->where('equipos.id', $this->id_equipo)
                    ->whereDate('proyectos.fecha_fin','>=',Carbon::now())
                    ->whereRaw($terminada . ' = ' . $total_tareas)->get();
            }else{
                $query_final = $query->whereRaw($terminada . ' = ' . $total_tareas)
                    ->whereDate('proyectos.fecha_fin', '>=', Carbon::now())
                    ->get();
            }

            foreach ($query_final as $item) {
                $item->estado = 'Terminado';
                $item->porcentaje = ($item->terminada/$item->total) * 100;
            }
        }elseif ($this->estado_proyecto == 'Vencido'){
            $query = DB::table('proyectos')
                ->leftJoin('equipos','equipos.id','=','proyectos.id_equipo')
                ->select('proyectos.nombre','proyectos.fecha_inicio','proyectos.fecha_fin','equipos.nombre as nombre_equipo',
                    DB::raw($en_proceso.' as en_proceso'), DB::raw($terminada.' as terminada'), DB::raw($total_tareas.' as total'));
            if ($this->id_equipo){
                $query_final = $query->where('equipos.id', $this->id_equipo)
                    ->where(DB::raw($sql),'>=',1)
                    ->whereDate('proyectos.fecha_fin','<',Carbon::now())->get();
            }else{
                $query_final = $query->where(DB::raw($sql),'>=',1)
                    ->whereDate('proyectos.fecha_fin','<',Carbon::now())
                    ->get();
            }

            foreach ($query_final as $item) {
                $item->estado = 'Vencido';
                $item->porcentaje = (($item->terminada / $item->total) * 100) + ((($item->en_proceso * 0.5)/$item->total) * 100);
            }
        }

        return $query_final;
    }

    /**
     * @Method Para traer la lista de tareas segun los filtros aplicados
     **/
    public function lista_tareas(){
        $query_final = [];
        $query = Tarea::leftJoin('proyectos','proyectos.id','=','tareas.id_proyecto')
            ->leftJoin('personas','personas.id','=','tareas.id_responsable')
            ->select('tareas.*','proyectos.nombre',
                DB::raw("concat(personas.nombres,' ',personas.apellidos) as nombre_responsable"));
        if ($this->id_proyecto){
            if ($this->estado_tarea){
                $query_final = $query->where('tareas.id_proyecto',$this->id_proyecto)
                    ->where('tareas.estado',$this->estado_tarea)->get();
            }else{
                $query_final = $query->where('tareas.id_proyecto',$this->id_proyecto)->get();
            }

        }else{
            $query_final = $query->where('tareas.estado',$this->estado_tarea)->get();
        }

        return $query_final;
    }

    /**
     * @Method Para traer la lista de personas segun los filtros
     **/
    public function lista_personas(){
        $query_final = [];

        $query = Persona::leftJoin('miembros_equipos','miembros_equipos.id_persona','=','personas.id')
            ->leftJoin('equipos','equipos.id','=','miembros_equipos.id_equipo')
            ->select('personas.*','equipos.nombre as nombre_equipo');
        if ($this->id_equipo_personas){
            $query_final = $query->where('miembros_equipos.id_equipo',$this->id_equipo_personas)->get();
        }else{
            $query_final = $query->get();
        }

        return $query_final;
    }

    /**
     * @Method Para cambiar estado booleano de el tab que se selecciona
     **/
    public function cambiar_tab($tab){
        if ($tab == 'Proyectos'){
            $this->tab_proyectos = true;
            $this->tab_tareas = false;
            $this->tab_personas = false;
        }elseif ($tab == 'Tareas'){
            $this->tab_proyectos = false;
            $this->tab_tareas = true;
            $this->tab_personas = false;
        }elseif ($tab == 'Personas'){
            $this->tab_proyectos = false;
            $this->tab_tareas = false;
            $this->tab_personas = true;
        }
    }

    /**
     * @Method Para descargar el pdf de reportes begun lo filtros aplicados
     **/
    public function descargar_pdf(){
        $nombre = '';
        $pdf = null;
        if ($this->tab_proyectos){
            $proyectos = $this->lista_proyectos();
            $estado = $this->estado_proyecto;
            $pdf = PDF::loadView('livewire.Reportes.PDF.PDF_Proyectos', compact('proyectos','estado'))->output();
            $nombre = 'Reporte-Proyectos.pdf';
        }elseif ($this->tab_tareas){
            $tareas = $this->lista_tareas();
            $estado = $this->estado_tarea;
            $pdf = PDF::loadView('livewire.Reportes.PDF.PDF_Tareas', compact('tareas','estado'))->output();
            $nombre = 'Reporte-Tareas.pdf';
        }elseif ($this->tab_personas){
            $personas = $this->lista_personas();
            $nombre_equipo = $this->id_equipo_personas ? Equipo::find($this->id_equipo_personas)->pluck('nombre')->first():'Todos';
            $pdf = PDF::loadView('livewire.Reportes.PDF.PDF_Personas', compact('personas','nombre_equipo'))->output();
            $nombre = 'Reporte-Personas.pdf';
        }
        return response()->streamDownload(fn () => print($pdf), $nombre);
    }
}
