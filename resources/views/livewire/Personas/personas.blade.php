<div xmlns:wire="http://www.w3.org/1999/xhtml" style="padding-top: 15px">
    <div class="container">
        @include('livewire.Personas.Modales.confirmacion_borrar_persona')
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
                <h5>Personas
                    <button class="btn btn-sm btn-outline-success btn-small" data-toggle="collapse" data-target="#collapse-persona">
                        <i class="fas fa-plus-circle"></i> {{$this->update ? 'Actualizar':'Crear'}}
                    </button>
                </h5>

                <!-- Collapse para crear el registro de una persona -->
                <div class="collapse" id="collapse-persona" wire:ignore.self>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Nombres:</label>
                                        <input class="form-control size-small @error('nombres') is-invalid @enderror"
                                               type="text" maxlength="30" wire:model.defer="nombres">
                                        @error('nombres')<span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Apellidos:</label>
                                        <input class="form-control size-small @error('apellidos') is-invalid @enderror"
                                               type="text" maxlength="30" wire:model.defer="apellidos">
                                        @error('apellidos')<span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Fecha Nacimiento:</label>
                                        <input class="form-control size-small @error('fecha_nacimiento') is-invalid @enderror"
                                               type="date" wire:model="fecha_nacimiento">
                                        @error('fecha_nacimiento')<span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Sexo:</label>
                                        <div class="row" style="padding-top: 15px">
                                            <div class="form-check col-md-6">
                                                <input type="radio" id="masculino" name="sexo" value="M"
                                                       wire:model.defer="sexo">
                                                <label class="form-check-label" for="masculino">
                                                    Masculino
                                                </label>
                                            </div>
                                            <div class="form-check col-md-6">
                                                <input type="radio" id="femenino" name="sexo" value="F"
                                                       wire:model.defer="sexo">
                                                <label class="form-check-label" for="femenino">
                                                    Femenino
                                                </label>
                                            </div>
                                        </div>
                                        @error('sexo')<span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Teléfono:</label>
                                        <input class="form-control size-small @error('telefono') is-invalid @enderror"
                                               type="text" maxlength="8" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                               wire:model.defer="telefono">
                                        @error('telefono')<span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Correo electrónico:</label>
                                        <input class="form-control size-small @error('correo_electronico') is-invalid @enderror"
                                               type="email" maxlength="30" wire:model.defer="correo_electronico">
                                        @error('correo_electronico')<span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6" style="display: grid; place-items: end">
                                    <div class="form-inline">
                                        <button class="btn btn-sm btn-outline-danger btn-small float-right" wire:click="resetear()">
                                            <i class="fas fa-window-close"></i> Cancelar
                                        </button>
                                        <button class="btn btn-sm btn-small btn-outline-success" wire:click="accion_personas()">
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
                            <th>Sexo</th>
                            <th>Telefono</th>
                            <th>Fecha Nacimiento</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($personas as $item => $value)
                            <tr>
                                <th>{{$item+$personas->firstItem()}}</th>
                                <td>{{$value->nombre_persona}}</td>
                                <td>{{$value->sexo == 'F' ? 'Femenino':'Masculino'}}</td>
                                <td>{{$value->telefono}}</td>
                                <td>{{$value->fecha_nacimiento}}</td>
                                <td>{{$value->correo_electronico}}</td>
                                <td>
                                    <span class="fas fa-pencil-alt btn-table-edit" type="button" title="Editar"
                                          wire:click="info_persona({{$value->id}})"></span>
                                    <span class="fas fa-trash btn-table-delete" type="button" title="Borrar"
                                          wire:click="borrar_persona({{$value->id}})"></span>
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
                            <th colspan="7" style="text-align: center">Total personas: {{$personas->count()}}</th>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="pagination-sm">
                        {{$personas->links('pagination-links')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
