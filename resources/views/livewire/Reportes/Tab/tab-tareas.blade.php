<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    <div class="row float-left">
                        <div class="col-md-6">
                            <label>Proyecto:</label>
                            <select class="form-control size-small" data-placeholder="Estado" wire:model="id_proyecto">
                                <option value="{{null}}">Seleccione una opción</option>
                                @foreach($proyectos as $value)
                                    <option value="{{$value->id}}">{{$value->nombre}} | {{$value->equipo}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Estado:</label>
                            <select class="form-control size-small" data-placeholder="Estado" wire:model="estado_tarea">
                                <option>Seleccione una opción</option>
                                <option>Creada</option>
                                <option>Asignada</option>
                                <option>En Proceso</option>
                                <option>Terminada</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-inline float-right">
                        <button class="btn btn-sm btn-small btn-outline-danger" type="button" wire:click="resetear()"
                                wire:loading.attr="disabled" title="Resetear Campos">
                            <i class="fas fa-eraser"></i>
                        </button>
                        <button class="btn btn-small btn-sm btn-outline-info" type="button" wire:click="descargar_pdf()"
                                wire:loading.attr="disabled">
                            <i class="fas fa-file-download"></i> Descargar
                        </button>
                        <div wire:loading wire:target="descargar_pdf">
                            <div class="spinner-border text-warning float-right" role="status"
                                 style="height: 16px; width: 16px;padding-left: 10px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-head-fixed table-valign-middle table-p">
                    <thead>
                    <tr>
                        <th>N°</th>
                        <th>Proyecto</th>
                        <th>Tarea</th>
                        <th>Responsable</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($lista_tareas as $item=>$value)
                        <tr>
                            <th>{{$item+=1}}</th>
                            <td>{{$value->nombre}}</td>
                            <td>{{$value->titulo}}</td>
                            <td>{{!$value->nombre_responsable ? 'Sin asignar': $value->nombre_responsable}}</td>
                            <td>{{$value->fecha_inicio}}</td>
                            <td>{{$value->fecha_fin}}</td>
                            <td>
                                <span
                                    @if($value->estado == 'Creada')
                                        class="badge bg-warning"
                                    @elseif($value->estado == 'Asignada')
                                        class="badge bg-success"
                                    @elseif($value->estado == 'En Proceso')
                                        class="badge bg-info"
                                    @elseif($value->estado == 'Terminada')
                                        class="badge bg-black"
                                    @endif>{{$value->estado}}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <span class="badge bg-info" style="width: 100%"> No hay ningún registro en esta tabla.</span>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
