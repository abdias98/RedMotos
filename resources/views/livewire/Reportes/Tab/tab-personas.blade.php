<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    <div class="row float-left">
                        <div class="col-md-12">
                            <label>Equipo:</label>
                            <select class="form-control size-small" wire:model="id_equipo_personas">
                                <option value="{{null}}">Seleccione una opción</option>
                                @foreach($equipos as $item)
                                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                                @endforeach
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
                        <th>Equipo</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                        <th>Correo electronic</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($lista_personas as $item => $value)
                        <tr>
                            <th>{{$item+=1}}</th>
                            <td>{{$value->nombre_equipo}}</td>
                            <td>{{$value->nombres}}</td>
                            <td>{{$value->apellidos}}</td>
                            <td>{{$value->telefono}}</td>
                            <td>{{$value->correo_electronico}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
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
