@extends('layouts.master')
@section('sucursal','active')
@section('title','SUCURSALES REGISTRADAS')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">SUCURSALES REGISTRADAS</h3>
    </div>
    <div class="box-body">
        <a class="btn btn-success" href="{{ url('sucursal/nuevo') }}"><i class="fa fa-plus"></i> NUEVA SUCURSAL</a>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered table-sm datatable">
                <thead>
                    <tr class="bg-gray">
                        <th>#</th>
                        <th>SUCURSAL</th>
                        <th>INICIALES</th>
                        <th>LOCALIDAD</th>
                        <th>PLANES</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sucursales as $numero => $sucursal)
                    <tr>
                        <td>{{ $numero + 1 }}</td>
                        <td>{{ $sucursal->NOM_SUC }}</td>
                        <td>{{ $sucursal->ABR_SUC }}</td>
                        <td>{{ $sucursal->NOM_LOC }}</td>
                        <td>
                            @foreach ($sucursal->planes as $plan)
                            <span class="badge bg-blue">{{ $plan->NOM_PLAN }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ url('sucursal/edita/'.$sucursal->ID_SUC) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
