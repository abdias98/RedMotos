<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div wire:ignore.self class="modal fade" id="modal-comentarios-tarea" tabindex="-1" role="dialog" aria-hidden="true"
         data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Comentarios</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetear()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                           <div class="card">
                               <div class="card-body">
                                   <div class="form-group">
                                       <textarea class="form-control size-small" placeholder="Cuerpo"
                                                 wire:model.defer="cuerpo"></textarea>
                                   </div>
                               </div>
                               <div style="display: block; padding: 15px">
                                   <div class="row">
                                       <div class="col-md-6" style="padding-left: 10px">
                                           <span type="button" title="Subir archivo" id="btn-subir-archivo">
                                               <i class="fas fa-upload"></i>
                                           </span>
                                           <input type="file" id="subir-archivo" wire:model="archivos"
                                                  style="display: none">
                                       </div>
                                       <div class="col-md-6" style="display: grid; place-items: end">
                                           <button class="btn btn-sm btn-small btn-outline-success float-right" wire:click="crear_comentario()">
                                               <i class="fas fa-paper-plane"></i> Enviar
                                           </button>
                                       </div>
                                   </div>
                                   <div class="row">
                                       @if($this->archivos)
                                           <div class="col-md-6">
                                               <div class="form-inline">
                                               <span class="fas fa-window-close float-right" type="button" wire:click="$set('archivos',null)"
                                                     style="display: inline-block;place-items: end" title="Borrar"></span>
                                               </div>
                                               <div class="form-inline">
                                                   @if(str_contains($this->archivos->getMimeType(), 'image'))
                                                       <img src="{{$this->archivos->temporaryUrl()}}" style="height: 100px; width: 110px">
                                                   @else
                                                       <img src="{{asset('storage/doc.png')}}" style="height: 100px; width: 110px">
                                                   @endif
                                                   <small>{{$this->archivos->getClientOriginalName()}}</small>
                                               </div>
                                           </div>
                                       @endif
                                   </div>
                               </div>
                           </div>
                        </div>
                        <div class="col-md-6 modal-comment">
                            @forelse($comentarios as $item => $value)
                                <div class="card" style="border: 1px solid grey; border-radius: 5px">
                                    <div class="card-body">
                                        <p>{{$value->cuerpo}}</p>
                                    </div>
                                    <div style="display: block; padding: 10px;">
                                        @if($value->ruta)
                                            <span class="fas fa-file-download float-left" type="button" style="color: green;padding-right: 5px"
                                                  wire:click="descargar_archivo('{{$value->ruta}}')" title="Descargar"></span>
                                        <small>Archivo adjunto</small>
                                            <div wire:loading wire:target="descargar_archivo">
                                                <div class="spinner-border text-warning float-right" role="status"
                                                     style="height: 16px; width: 16px;"></div>
                                            </div>

                                        @endif
                                        <span class="small float-right">
                                            <i class="fas fa-user"></i> {{$value->name}}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <span class="badge bg-info" style="width: 100%">Aún no hay comentarios en esta tarea.</span>
                            @endforelse
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="form-inline">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
