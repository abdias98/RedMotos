<div xmlns:wire="http://www.w3.org/1999/xhtml" style="padding-top: 15px">
    <div class="container">
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
                <h5>Usuarios
                    <button class="btn btn-sm btn-outline-success btn-small" data-toggle="collapse" data-target="#collapse-usuario">
                        <i class="fas fa-plus-circle"></i> {{$this->update ? 'Actualizar' : 'Crear'}}
                    </button>
                </h5>

                <!-- Collapse para crear o actualizar usuario-->
                <div class="collapse" id="collapse-usuario" wire:ignore.self>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Nombre usuario:</label>
                                        <input class="form-control size-small @error('nombre') is-invalid @enderror" type="text"
                                               maxlength="10" wire:model.defer="nombre">
                                        @error('nombre')<small class="text-danger">{{$message}}</small>@enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Persona:</label>
                                        <select class="form-control size-small @error('id_persona') is-invalid @enderror" wire:model.defer="id_persona">
                                            <option>Seleccione una persona</option>
                                            @foreach($personas as $item)
                                                <option value="{{$item->id}}">{{$item->nombre_persona}}</option>
                                            @endforeach
                                        </select>
                                        @error('id_persona')<small class="text-danger">{{$message}}</small>@enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Rol:</label>
                                        <select class="form-control size-small" wire:model.defer="rol">
                                            <option>Seleccione un rol</option>
                                            @foreach($roles as $item)
                                                <option value="{{$item->name}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Contraseña:</label>
                                        <input class="form-control size-small @error('password') is-invalid @enderror" type="password" wire:model.defer="password" id="password">
                                        @error('password')<small class="text-danger">{{$message}}</small>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Confirmación de contraseña:</label>
                                        <input class="form-control size-small @error('password_confirmation') is-invalid @enderror" type="password"
                                               wire:model.defer="password_confirmation" id="password_confirm">
                                        @error('password_confirmation')<small class="text-danger">{{$message}}</small>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="size-small" for="mostrar_contraseña">
                                        <input class="float-left border" type="checkbox" id="mostrar_contraseña"
                                               style="margin-right: 3px; margin-top: 2px"
                                               wire:click="$emit('mostrar_contraseña')"/>
                                        Mostrar contraseña
                                    </label>
                                    <button class="btn btn-sm btn-outline-success btn-small float-right" wire:click="accion_usuario()">
                                        <i class="fas fa-save"></i> {{$update ? 'Actualizar':'Crear'}}
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger btn-small float-right" wire:click="resetear()">
                                        <i class="fas fa-window-close"></i> Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-head-fixed table-valign-middle" style="white-space: nowrap;">
                        <thead>
                        <tr>
                            <th>N°</th>
                            <th>Persona</th>
                            <th>Usuario</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($lista_usuarios as $item => $value)
                            <tr>
                                <th>{{$item+$lista_usuarios->firstItem()}}</th>
                                <td>{{$value->nombre_persona}}</td>
                                <td>{{$value->name}}</td>
                                <td>{{$value->rol}}</td>
                                <td>
                                    <span class="fas fa-pencil-alt btn-table-edit" type="button" title="Editar"
                                          wire:click="info_usuario({{$value->id}})"></span>
                                    <span class="fas fa-trash btn-table-delete" type="button" title="Borrar"
                                          wire:click="borrar_usuario({{$value->id}})"></span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <span class="badge bg-info" style="width: 100%">No hay elementos en esta lista.</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                        <tfoot>
                        <tr>
                            <th style="text-align: center" colspan="6">Total de usuarios: {{$lista_usuarios->count()}}</th>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="pagination-sm">
                        {{$lista_usuarios->links('pagination-links')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

