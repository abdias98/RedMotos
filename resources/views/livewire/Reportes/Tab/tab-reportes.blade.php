<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    <div class="row float-left">
                        <div class="col-md-6">
                            <label>Equipo:</label>
                            <select class="form-control size-small" wire:model="id_equipo">
                                <option value="{{null}}">Seleccione una opción</option>
                                @foreach($equipos as $item)
                                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Estado:</label>
                            <select class="form-control size-small" wire:model="estado_proyecto">
                                <option>Seleccione una opción</option>
                                <option>Creado</option>
                                <option>En proceso</option>
                                <option>Terminado</option>
                                <option>Vencido</option>
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
                        <th>Equipo</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Porcentaje</th>
                        <th>Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($lista_proyectos as $item => $value)
                        <tr>
                            <th>{{$item+=1}}</th>
                            <td>{{$value->nombre_equipo}}</td>
                            <td>{{$value->nombre}}</td>
                            <td>{{$value->fecha_inicio}}</td>
                            <td>{{$value->fecha_fin}}</td>
                            <td>
                                <div class="progress" role="progressbar" aria-valuenow="{{$value->porcentaje}}" aria-valuemin="0"
                                     aria-valuemax="100" style="border-radius: 5px;height: 13px;width: 80%">
                                    <div class="progress-bar"
                                         style="width: {{$value->porcentaje}}%; height: 13px; border-radius: 5px">{{$value->porcentaje}}%</div>
                                </div>
                            </td>
                            <td>{{$value->estado}}</td>
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
