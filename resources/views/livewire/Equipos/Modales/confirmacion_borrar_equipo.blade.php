<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div wire:ignore.self class="modal fade" id="modal-confirmacion-borrar-equipo" tabindex="-1" role="dialog" aria-hidden="true"
         data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog" style="width: 500px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Confirmación eliminar equipo</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetear()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <label>Este equipo ya cuenta con el proyecto '{{$this->nombre_proyecto}}' asignado:</label>
                            <label>¿Está seguro de borrar este equipo?</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-inline">
                        <button class="btn btn-sm btn-small btn-outline-danger" wire:click="borrar_equipo({{$this->id_equipo}},true)">
                            <i class="fas fa-trash"></i> Borrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
