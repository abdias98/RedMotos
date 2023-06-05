<div xmlns:wire="http://www.w3.org/1999/xhtml" style="padding-top: 15px">
    <div class="container">
        @include('livewire.Equipos.Modales.asignar_miembro')
        @include('livewire.Equipos.Modales.confirmacion_borrar_equipo')
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
                    Equipos
                    <button class="btn btn-sm btn-small btn-outline-success" data-toggle="collapse" data-target="#collapse-equipo">
                        <i class="fas fa-plus-circle"></i> {{$this->update ? 'Actualizar':'Crear'}}
                    </button>
                </h5>

                <!-- Collapse para crear o actualizar un equipo -->
                <div class="collapse" id="collapse-equipo" wire:ignore.self>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Nombre:</label>
                                        <input class="form-control size-small @error('nombre') is-invalid @enderror"
                                               type="text" maxlength="30" wire:model.defer="nombre">
                                        @error('nombre')<span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Descripción:</label>
                                        <textarea class="form-control size-small @error('descripcion') is-invalid @enderror"
                                               type="text" maxlength="191" wire:model.defer="descripcion"></textarea>
                                        @error('descripcion')<span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-4" style="display: grid; place-items: end">
                                    <div class="form-inline">
                                        <button class="btn btn-sm btn-outline-danger btn-small float-right" wire:click="resetear()">
                                            <i class="fas fa-window-close"></i> Cancelar
                                        </button>
                                        <button class="btn btn-sm btn-small btn-outline-success" wire:click="accion_equipo()">
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
                    <table class="table table-sm table-head-fixed table-valign-middle" style="white-space: nowrap">
                        <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($equipos as $item => $value)
                            <tr>
                                <th>{{$item+$equipos->firstItem()}}</th>
                                <td>{{$value->nombre}}</td>
                                <td>{{$value->descripcion}}</td>
                                <td>
                                    <span class="fas fa-pencil-alt btn-table-edit" type="button" title="Editar"
                                          wire:click="info_equipo({{$value->id}})"></span>
                                    <span class="fas fa-trash btn-table-delete" type="button" title="Borrar"
                                          wire:click="borrar_equipo({{$value->id}},'false')"></span>
                                    <span class="fas fa-list-ol btn-table-info" type="button" title="Asignar | Miembros"
                                          data-toggle="collapse" data-target="#moda-asignar-miembro"
                                          wire:click="establecer_valores({{$value->id}})"></span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center">
                                    <span class="badge bg-info" style="width: 100%">No hay elementos en esta lista.</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                        <tfoot>
                        <tr>
                           <th colspan="4" style="text-align: center">Total equipos: {{$equipos->count()}}</th>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="pagination-sm">
                        {{$equipos->links('pagination-links')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
