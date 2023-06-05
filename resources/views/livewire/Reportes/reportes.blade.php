<div xmlns:wire="http://www.w3.org/1999/xhtml" style="padding-top: 15px">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5>Reportes</h5>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link {{$tab_proyectos ? 'active':''}}" aria-current="page"
                           href="#proyectos" wire:click="cambiar_tab('Proyectos')">Proyectos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$tab_tareas ? 'active':''}}" aria-current="page" href="#tareas"
                           wire:click="cambiar_tab('Tareas')">Tareas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$tab_personas ? 'active':''}}" aria-current="page" href="#personas"
                           wire:click="cambiar_tab('Personas')">Personas</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane {{$tab_proyectos ? 'active':''}}" id="proyectos">
                        @if($tab_proyectos)
                            @include('livewire.Reportes.Tab.tab-reportes')
                        @endif
                    </div>
                    <div class="tab-pane {{$tab_tareas ? 'active':''}}" id="tareas">
                        @if($tab_tareas)
                            @include('livewire.Reportes.Tab.tab-tareas')
                        @endif
                    </div>
                    <div class="tab-pane {{$tab_personas ? 'active':''}}" id="personas">
                        @if($tab_personas)
                            @include('livewire.Reportes.Tab.tab-personas')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
