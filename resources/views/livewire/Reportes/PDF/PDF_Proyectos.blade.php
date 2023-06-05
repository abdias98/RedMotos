<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <div class="content">
        <div class="row">
            <div class="col-md-9 text-center" style="padding-right: 15%;">
                <h5>Reporte de Proyectos</h5>
                <h6>Estado: {{$estado}}</h6>
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
        <th>Equipo</th>
        <th>Fecha Inicio</th>
        <th>Fecha Fin</th>
        <th>Porcentaje</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody>
    @forelse($proyectos as $item => $value)
        <tr>
            <th>{{$item+=1}}</th>
            <td>{{$value->nombre_equipo}}</td>
            <td>{{$value->nombre}}</td>
            <td>{{$value->fecha_inicio}}</td>
            <td>{{$value->fecha_fin}}</td>
            <td>
                <div class="progress form-inline" role="progressbar" aria-valuenow="{{$value->porcentaje}}" aria-valuemin="0"
                     aria-valuemax="100" style="border-radius: 5px;height: 15px;width: 100%">
                    <div class="progress-bar"
                         style="width: {{$value->porcentaje}}%; height: 13px; border-radius: 5px;">
                        <h6 style="font-size: 14px; color: #fff; text-align: center">{{$value->porcentaje}}%</h6>
                    </div>
                </div>
            </td>
            <td>{{$value->estado}}</td>
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

