<div xmlns:wire="http://www.w3.org/1999/xhtml" style="padding-top: 15px">
    <div class="container">
        @include('livewire.Tareas.Modales.confirmacion_borrar_tarea')
        @include('livewire.Tareas.Modales.comentarios')
        @if (session()->has('exito'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('exito') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h5>
                    Tareas
                    <button class="btn btn-sm btn-small btn-outline-success" data-toggle="collapse" data-target="#collapse-tareas">
                        <i class="fas fa-plus-circle"></i> Crear
                    </button>
                </h5>
                <!-- Collapse para crear o actualizar un registro de tareas -->
                <div class="collapse" id="collapse-tareas" wire:ignore.self>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Titulo:</label>
                                        <input class="form-control size-small @error('titulo') is-invalid @enderror" type="text" maxlength="30"
                                               wire:model.defer="titulo">
                                        @error('titulo')<span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Fecha Inicio:</label>
                                        <input class="form-control size-small @error('fecha_inicio') is-invalid @enderror" type="date"
                                               wire:model.defer="fecha_inicio">
                                        @error('fecha_inicio')<span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Fecha Fin:</label>
                                        <input class="form-control size-small @error('fecha_fin') is-invalid @enderror" type="date"
                                               wire:model.defer="fecha_fin">
                                        @error('fecha_fin')<span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Prioridad:</label>
                                        <select class="form-control size-small @error('prioridad') is-invalid @enderror"
                                               wire:model.defer="prioridad">
                                            <option>Seleccione una opción</option>
                                            @foreach($prioridades as $value)
                                                <option value="{{$value}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                        @error('prioridad')<span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Descripción:</label>
                                        <textarea class="form-control size-small @error('descripcion') is-invalid @enderror"
                                               wire:model.defer="descripcion"></textarea>
                                        @error('descripcion')<span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Proyecto:</label>
                                        @if($this->asignada)
                                            <span class="form-control size-small">{{$this->nombre_proyecto->proyecto}}</span>
                                        @else
                                            <select class="form-control size-small @error('id_proyecto') is-invalid @enderror"
                                                    wire:model="id_proyecto">
                                                <option>Seleccione una opción</option>
                                                @foreach($proyectos as $value)
                                                    <option value="{{$value->id}}">{{$value->nombre_proyecto}} |Equipo: {{$value->nombre_equipo}}</option>
                                                @endforeach
                                            </select>
                                            @error('id_proyecto')<span class="text-danger">{{$message}}</span>@enderror
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Responsable:</label>
                                        @if($this->asignada)
                                            <span class="form-control size-small">{{$this->nombre_responsable->responsable}}</span>
                                        @else
                                            <select class="form-control size-small @error('id_responsable') is-invalid @enderror"
                                                    wire:model.defer="id_responsable">
                                                <option value="{{null}}">Seleccione una opción</option>
                                                @foreach($responsables as $value)
                                                    <option value="{{$value->id}}">{{$value->responsable}}</option>
                                                @endforeach
                                            </select>
                                            @error('id_responsable')<span class="text-danger">{{$message}}</span>@enderror
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3" style="display: grid; place-items: end">
                                    <div class="form-inline">
                                        <button class="btn btn-sm btn-outline-danger btn-small float-right" wire:click="resetear()">
                                            <i class="fas fa-window-close"></i> Cancelar
                                        </button>
                                        <button class="btn btn-sm btn-small btn-outline-success" wire:click="accion_tarea()">
                                            <i class="fas fa-save"></i> {{$this->update ? 'Actualizar':'Crear'}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-valign-middle table-head-fixed" style="white-space: nowrap">
                        <thead>
                        <tr>
                            <th>N°</th>
                            <th>Título</th>
                            <th>Responsable</th>
                            <th>Proyecto</th>
                            <th>Estado</th>
                            <th>Prioridad</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tareas as $item => $value)
                            <tr>
                                <th>{{$item+$tareas->firstItem()}}</th>
                                <td>{{$value->titulo}}</td>
                                <td>{{$value->responsable ? $value->responsable:'Tarea sin asignar.'}}</td>
                                <td>{{$value->nombre}}</td>
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
                                        @endif>{{$value->estado}}</span>
                                </td>
                                <td>
                                    <span class="badge {{$value->prioridad == 'Alta' ? 'bg-red':($value->prioridad == 'Media' ? 'bg-warning':'bg-grey')}}">
                                        {{$value->prioridad}}
                                    </span>
                                </td>
                                <td>
                                    <span class="fas fa-pencil-alt btn-table-edit" type="button" title="Editar"
                                          wire:click="info_tarea({{$value->id}})"></span>
                                    <span class="fas fa-trash btn-table-delete" type="button" title="Borrar"
                                          wire:click="borrar_tarea({{$value->id}},'{{$value->responsable ? true:false}}')"></span>
                                    @if($value->estado != 'Creada' && $value->estado != 'Terminada')
                                        <span class="fas fa-circle-notch btn-table-info" type="button" data-toggle="dropdown"
                                              title="Actualizar Estado"></span>
                                        <ul class="dropdown-menu" style="font-size: small">
                                            @if($value->estado == 'Asignada')
                                                <li><span class="dropdown-item" type="button"
                                                          wire:click="actualizar_estado({{$value->id}},'En Proceso')">En Proceso</span></li>
                                            @elseif($value->estado == 'En Proceso')
                                                <li><span class="dropdown-item" type="button"
                                                          wire:click="actualizar_estado({{$value->id}},'Terminada')">Terminada</span></li>                                            @endif
                                        </ul>
                                    @endif
                                    <span class="fas fa-comment btn-table-comment" type="button" title="Comentarios"
                                          wire:click="abrir_comentarios({{$value->id}})"></span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <span class="badge bg-info" style="width: 100%">No hay elementos en esta lista.</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="7" style="text-align: center;">Total tareas: {{$tareas->count()}}</th>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="pagination-sm">
                        {{$tareas->links('pagination-links')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
