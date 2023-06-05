<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <div class="content">
        <div class="row">
            <div class="col-md-9 text-center" style="padding-right: 15%;">
                <h5>Reporte de Proyectos</h5>
                <h6>Equipo: {{$nombre_equipo}}</h6>
            </div>
        </div>
    </div>
</head>
<body>
<table class="table table-sm size-small" style="padding-top: 100px">
    <thead>
    <tr>
        <th>N°</th>
        <th>Equipo</th>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>Teléfono</th>
        <th>Correo electronico</th>
    </tr>
    </thead>
    <tbody>
    @forelse($personas as $item => $value)
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
</body>
<footer style="position: fixed; bottom: 0; left: 0; right: 0; text-align: right">
    <span style="font-size: 10px;">
        Fecha generado: {{\Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM YYYY[,] h:mm A')}}
    </span>
</footer>
</html>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>

