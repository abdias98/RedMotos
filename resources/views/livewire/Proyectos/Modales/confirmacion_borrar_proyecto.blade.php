<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div wire:ignore.self class="modal fade" id="modal-confirmacion-borrar-proyecto" tabindex="-1" role="dialog" aria-hidden="true"
         data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Confirmación eliminar proyecto</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetear()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <label>Este proyecto cuenta con las siguientes tareas ya asignadas:</label>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-head-fixed table-valign-middle" style="white-space: nowrap">
                                    <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Titulo</th>
                                        <th>Responsable</th>
                                        <th>Estado</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tareas_proyecto as $item => $value)
                                        <tr>
                                            <th>{{$item+=1}}</th>
                                            <td>{{$value->titulo}}</td>
                                            <td>{{$value->responsable}}</td>
                                            <td>
                                                <span
                                                    @if($value->estado == 'Creada')
                                                        class="badge bg-warning"
                                                    @elseif($value->estado == 'Asignada')
                                                        class="badge bg-success"
                                                    @elseif($value->estado == 'En Proceso')
                                                        class="badge bg-info"
                                                    @endif>{{$value->estado}}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <label>¿Está seguro de eliminar este proyecto?</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-inline">
                        <button class="btn btn-sm btn-small btn-outline-danger" wire:click="borrar_proyecto({{$this->id_proyecto}},true)">
                            <i class="fas fa-trash"></i> Borrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
