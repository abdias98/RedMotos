<div xmlns:wire="http://www.w3.org/1999/xhtml" style="padding-top: 15px">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5>Tareas Asignadas</h5>
            </div>
            <div class="card-body">
                <div wire:ignore>
                    <div id="calendario"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
                var calendar = new FullCalendar.Calendar(document.getElementById('calendario'), {
                    // Configuración de FullCalendar
                    locale: 'es',
                    events: @json($lista_tareas)
                });
                calendar.render();

        });
    </script>

@endpush
