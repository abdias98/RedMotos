<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div wire:ignore.self class="modal fade" id="modal-confirmacion-borrar-persona" tabindex="-1" role="dialog" aria-hidden="true"
         data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog" style="width: 500px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Eliminar persona</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetear()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>¿Está seguro de eliminar esta persona y todos los registros relacionados a ella (tareas, usuario)?</label>
                </div>
                <div class="modal-footer">
                    <div class="form-inline">
                        <button class="btn btn-sm btn-small btn-outline-danger" wire:click="borrar_persona({{$this->id_persona}},true)">
                            <i class="fas fa-trash"></i> Borrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
