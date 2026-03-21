@extends('layouts.master')
@section('rol','active')
@section('title','LISTADO DE PERMISOS')
@section('content')
<div class="box box-primary">
    <div class="box-body">
        <table class="table table-hover table-striped table-bordered datatable">
            <thead>
                <tr class="bg-yellow">
                    <th>#</th>
                    <th>NOMBRE</th>
                    <th>DESCRIPCION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permisos as $numero => $permiso)
                <tr>
                    <td>{{ $numero + 1 }}</td>
                    <td>{{ $permiso->name }}</td>
                    <td>{{ $permiso->description ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
