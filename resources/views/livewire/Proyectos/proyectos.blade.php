<div xmlns:wire="http://www.w3.org/1999/xhtml" style="padding-top: 15px">
    <div class="container">
        @include('livewire.Proyectos.Modales.confirmacion_borrar_proyecto')
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
                    Proyectos
                    <button class="btn btn-sm btn-small btn-outline-success" data-toggle="collapse" data-target="#collapse-proyecto">
                        <i class="fas fa-plus-circle"></i> {{$this->update ? 'Actualizar':'Crear'}}
                    </button>
                </h5>
                <!-- Collapse para crear o actualizar un proyecto -->
                <div class="collapse" id="collapse-proyecto" wire:ignore.self>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Nombre:</label>
                                        <input class="form-control size-small @error('nombre') is-invalid @enderror" type="text" maxlength="30"
                                               wire:model.defer="nombre">
                                        @error('nombre')<span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Fecha Inicio:</label>
                                        <input class="form-control size-small @error('fecha_inicio') is-invalid @enderror" type="date" maxlength="30"
                                               wire:model.defer="fecha_inicio">
                                        @error('fecha_inicio')<span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Fecha fin:</label>
                                        <input class="form-control size-small @error('fecha_fin') is-invalid @enderror" type="date" maxlength="30"
                                               wire:model.defer="fecha_fin">
                                        @error('fecha_fin')<span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Descripción:</label>
                                        <textarea class="form-control size-small @error('descripcion') is-invalid @enderror" type="text"
                                                  maxlength="191" wire:model.defer="descripcion"></textarea>
                                        @error('descripcion')<span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Equipo:</label>
                                        @if($this->tareas_creadas)
                                            <span class="form-control size-small">{{$this->nombre_equipo}}</span>
                                        @else
                                            <select class="form-control size-small @error('id_equipo') is-invalid @enderror"
                                                    wire:model.defer=id_equipo>
                                                <option value="{{null}}">Seleccione un equipo</option>
                                                @foreach($equipos as $item)
                                                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                @endforeach
                                            </select>
                                            @error('id_equipo')<span class="text-danger">{{$message}}</span>@enderror
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4" style="display: grid; place-items: end">
                                    <div class="form-inline">
                                        <button class="btn btn-sm btn-outline-danger btn-small float-right" wire:click="resetear()">
                                            <i class="fas fa-window-close"></i> Cancelar
                                        </button>
                                        <button class="btn btn-sm btn-small btn-outline-success" wire:click="accion_proyecto()">
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
                    <table class="table table-sm table-head-fixed table-valign-middle table-p">
                        <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nombre</th>
                            <th>Equipo</th>
                            <th>Descripción</th>
                            <th>Fechas</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($proyectos as $item => $value)
                            <tr>
                                <th>{{$item+$proyectos->firstItem()}}</th>
                                <td>{{$value->nombre}}</td>
                                <td>{{$value->nombre_equipo}}</td>
                                <td class="table-description">{{$value->descripcion}}</td>
                                <td>
                                    Desde
                                    <b>{{\Carbon\Carbon::parse($value->fecha_inicio)->format('d/m/Y')}}</b>
                                    hasta
                                    <b>{{\Carbon\Carbon::parse($value->fecha_fin)->format('d/m/Y')}}</b>
                                </td>
                                <td>
                                    <span class="fas fa-pencil-alt btn-table-edit" type="button" title="Editar"
                                          wire:click="info_proyecto({{$value->id}})"></span>
                                    <span class="fas fa-trash btn-table-delete" type="button" title="Borrar"
                                          wire:click="borrar_proyecto({{$value->id}},false)"></span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <span class="badge bg-info" style="width: 100%">No hay elementos en esta lista.</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="6" style="text-align: center">Total proyectos {{$proyectos->count()}}</th>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="pagination-sm">
                        {{$proyectos->links('pagination-links')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
