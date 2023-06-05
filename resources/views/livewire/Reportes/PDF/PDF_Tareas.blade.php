<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <div class="content">
        <div class="row">
            <div class="col-md-9 text-center" style="padding-right: 15%;">
                <h5>Reporte de Tareas</h5>
                <h6>Estado: {{$estado ? $estado:'Todos'}}</h6>
            </div>
        </div>
    </div>
</head>
<body>
<table class="table table-sm size-small" style="padding-top: 100px">
    <thead>
    <tr>
        <th>N°</th>
        <th>Proyecto</th>
        <th>Tarea</th>
        <th>Responsable</th>
        <th>Fecha Inicio</th>
        <th>Fecha Fin</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody>
    @forelse($tareas as $item=>$value)
        <tr>
            <th>{{$item+=1}}</th>
            <td>{{$value->nombre}}</td>
            <td>{{$value->titulo}}</td>
            <td>{{!$value->nombre_responsable ? 'Sin asignar': $value->nombre_responsable}}</td>
            <td>{{$value->fecha_inicio}}</td>
            <td>{{$value->fecha_fin}}</td>
            <td>
                <span
                    @if($value->estado == 'Creada')
                        class="badge bg-warning"
                    @elseif($value->estado == 'Asignada')
                        class="badge bg-success"
                    @elseif($value->estado == 'En Proceso')
                        class="badge bg-info"
                    @elseif($value->estado == 'Terminada')
                        class="badge bg-black"
                    @endif>{{$value->estado}}
                </span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7">
                <span class="badge bg-info" style="width: 100%"> No hay ningún registro en esta tabla.</span>
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
</body>
<footer style="position: fixed; bottom: 0; left: 0; right: 0; text-align: right">
    <span style="font-size: 10px;">
        Fecha generado: {{\Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM YYYY[,] h:mm A')}}
    </span>
</footer>
</html>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>

