<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div wire:ignore.self class="modal fade" id="modal-asignar-miembro" tabindex="-1" role="dialog" aria-hidden="true"
         data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Asignar Miembro</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetear()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (session()->has('exito-asignar'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('exito-asignar') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Personas</label>
                                            <select class="form-control size-small @error('id_persona') is-invalid @enderror"
                                                    wire:model.defer="id_persona">
                                                <option>Seleccione una persona.</option>
                                                @foreach($personas as $item)
                                                    <option value="{{$item->id}}">{{$item->nombres}} {{$item->apellidos}}</option>
                                                @endforeach
                                            </select>
                                            @error('id_persona')<span class="text-danger">{{$message}}</span>@enderror
                                        </div>
                                        <div class="form-inline" style="display: grid;place-items: end">
                                            <button class="btn btn-sm btn-small btn-outline-success" wire:click="asignar_equipo()">
                                                Asignar <i class="fas fa-arrow-circle-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-7 border-left">
                                        <div class="table-responsive">
                                            <label>Lista de miembros de este equipo</label>
                                            <table class="table table-sm table-head-fixed table-valign-middle" style="white-space: nowrap">
                                                <thead>
                                                <tr>
                                                    <th>N°</th>
                                                    <th>Nombre</th>
                                                    <th>Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($miembros  as $item => $value)
                                                    <tr>
                                                        <th>{{$item+=1}}</th>
                                                        <td>{{$value->nombre_persona}}</td>
                                                        <td>
                                                            <span class="fas fa-trash btn-table-delete" type="button" title="Remover"
                                                                  wire:click="remover_miembro({{$value->id}})"></span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3" style="text-align: center">
                                                            <span class="badge bg-info" style="width: 100%">No hay elementos en esta lista.</span>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

