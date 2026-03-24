<?php

use App\Http\Controllers\AlertaController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\BulkController;
use App\Http\Controllers\CanalController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\LocalidadController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ReclamoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\SolicitudWebController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebController::class, 'index'])->name('web.inicio');
if (class_exists(SolicitudWebController::class)) {
    Route::name('solicitudWeb.store')->post('solicitudWeb/store', [SolicitudWebController::class, 'store']);
}
if (class_exists(ReclamoController::class)) {
    Route::name('reclamo.store')->post('reclamo/store', [ReclamoController::class, 'store']);
}

Auth::routes();

Route::group(['middleware' => ['auth', 'activo']], function () {
    Route::get('/inicio', [InicioController::class, 'index'])->name('inicio');
    Route::get('/error', [InicioController::class, 'error']);
    Route::name('usuario.password')->post('usuario/password', [InicioController::class, 'password']);

    //______________________ CONFIGURACIONES
    if (class_exists(ConfiguracionController::class)) {
        Route::group(['middleware' => ['permission:CONFIGURACION']], function () {
            Route::resource('configuracion', ConfiguracionController::class);
        });
    }

    //______________________ USUARIOS
    Route::group(['middleware' => ['permission:USUARIOS']], function () {
        Route::resource('usuario', UsuarioController::class);
        Route::name('usuario.actualiza')->post('usuario/actualiza', [UsuarioController::class, 'actualiza']);
        Route::name('usuario.elimina')->post('usuario/elimina', [UsuarioController::class, 'elimina']);
        Route::name('usuario.reactiva')->post('usuario/reactiva', [UsuarioController::class, 'reactiva']);
    });

    //______________________ ROLES_PERMISOS
    Route::group(['middleware' => ['permission:ROLES_PERMISOS']], function () {
        Route::resource('rol', RoleController::class);
        Route::name('rol.busca')->post('rol/busca', [RoleController::class, 'busca']);
        Route::name('rol.update')->post('rol/update', [RoleController::class, 'update']);
        Route::resource('permiso', PermisoController::class);
    });

    //______________________ LOCALIDADES
    Route::group(['middleware' => ['permission:LOCALIDADES']], function () {
        Route::resource('localidad', LocalidadController::class);
        Route::name('localidad.update')->post('localidad/update', [LocalidadController::class, 'update']);
        Route::name('localidad.elimina')->post('localidad/elimina', [LocalidadController::class, 'elimina']);
    });

    //______________________ SUCURSALES
    Route::group(['middleware' => ['permission:SUCURSALES']], function () {
        Route::get('sucursal/nuevo', [SucursalController::class, 'nuevo']);
        Route::get('sucursal/edita/{id_suc}', [SucursalController::class, 'edita']);
        Route::resource('sucursal', SucursalController::class);
        Route::name('sucursal.update')->post('sucursal/update', [SucursalController::class, 'update']);
    });

    //______________________ PLANES
    Route::group(['middleware' => ['permission:PLANES']], function () {
        Route::get('plan/plan-canales/{id_plan}', [PlanController::class, 'planCanales']);
        Route::name('asigna.canales')->post('asigna/canales', [PlanController::class, 'asignaCanales']);
        Route::name('plan.actualiza')->post('plan/actualiza', [PlanController::class, 'actualiza']);
        Route::resource('plan', PlanController::class);
    });

    //______________________ CANALES
    Route::group(['middleware' => ['permission:CANALES']], function () {
        Route::name('canal.actualiza')->post('canal/actualiza', [CanalController::class, 'actualiza']);
        Route::resource('canal', CanalController::class);
    });

    //______________________ CLIENTES
    Route::group(['middleware' => ['permission:CLIENTES']], function () {
        Route::get('clientes/sucursal/{id_suc}', [ClienteController::class, 'clientes']);
        Route::get('cliente/nuevo/{id_suc}/{id_sw}', [ClienteController::class, 'nuevo']);
        Route::get('cliente/edita/{id_cli}', [ClienteController::class, 'edita']);
        Route::get('cliente/pdf/{id_cli}', [ClienteController::class, 'cliente_pdf']);
        Route::name('cliente.actualiza')->post('cliente/actualiza', [ClienteController::class, 'actualiza']);
        Route::name('cliente.file')->post('cliente/file', [ClienteController::class, 'file']);
        Route::resource('cliente', ClienteController::class);

        Route::get('cliente/contrato/pdf/tv/{id_con}', [ContratoController::class, 'pdfTvContrato']);
        Route::get('cliente/contrato/pdf/wifi/{id_con}', [ContratoController::class, 'pdfWifiContrato']);
        Route::resource('contrato', ContratoController::class);
        Route::name('contrato.activa')->post('contrato/activa', [ContratoController::class, 'activa']);
        Route::name('contrato.actualiza')->post('contrato/actualiza', [ContratoController::class, 'actualiza']);
        Route::name('contrato.baja')->post('contrato/baja', [ContratoController::class, 'baja']);
        Route::name('contrato.bajaForzosa')->post('contrato/bajaForzosa', [ContratoController::class, 'bajaForzosa']);
        Route::name('contrato.recoge')->post('contrato/recoge', [ContratoController::class, 'recoge']);

        Route::get('cliente/informacion/{id_cli}', [ClienteController::class, 'informacion']);
        Route::get('cliente/informacion/historial/{id_cli}', [ClienteController::class, 'historial']);
        Route::get('cliente/informacion/actual/{id_cli}', [ClienteController::class, 'actual']);

        Route::name('pago.store')->post('pago/store', [PagoController::class, 'store']);
        Route::name('pago.otros')->post('pago/otros', [PagoController::class, 'otros']);
        Route::get('cliente/informacion/calcular/{nro_mes}/{id_con}', [PagoController::class, 'calcular']);
        Route::get('cliente/informacion/calcula_dias_cancela/{id_con}', [PagoController::class, 'calcula_dias_cancela']);
        Route::get('cliente/informacion/calcula_dias_descuenta/{id_con}', [PagoController::class, 'calcula_dias_descuenta']);
        Route::get('cliente/informacion/calcula_puntos_extra/{id_con}', [PagoController::class, 'calcula_puntos_extra']);
        Route::get('cliente/informacion/pago/{id_pag}', [PagoController::class, 'pdfPago']);
        Route::get('cliente/informacion/pago/recibo/{id_pag}', [PagoController::class, 'pdfRecibo']);
        Route::get('cliente/informacion/pago/mensualidad/{id_pd}', [PagoController::class, 'pdfMensualidad']);
        Route::get('cliente/informacion/pago/instalacion/recibo/{id_pd}', [PagoController::class, 'pdfReciboInstalacion']);
        Route::get('cliente/informacion/pagos/{id_con}', [ClienteController::class, 'pagos']);
        Route::get('cliente/informacion/factura/{id_pd}', [ClienteController::class, 'factura']);
    });

    //______________________ ELIMINA PAGOS SOLO ADMINS
    Route::group(['middleware' => ['role:ADMINISTRADOR|SUPER_ADMIN|GERENCIA GENERAL']], function () {
        Route::name('pagoDetalle.elimina')->post('pagoDetalle/elimina', [PagoController::class, 'elimina']);
    });

    //______________________ INHABILITA CLIENTES
    Route::group(['middleware' => ['permission:INHABILITA_CLIENTE']], function () {
        Route::name('cliente.elimina')->post('cliente/elimina', [ClienteController::class, 'elimina']);
        Route::name('cliente.activa')->post('cliente/activa', [ClienteController::class, 'activa']);
    });

    //______________________ MATERIALES
    if (class_exists(MaterialController::class)) {
        Route::group(['middleware' => ['permission:MATERIALES']], function () {
            Route::name('material.agregaStock')->post('material/agregaStock', [MaterialController::class, 'agregaStock']);
            Route::name('material.actualiza')->post('material/actualiza', [MaterialController::class, 'actualiza']);
            Route::resource('material', MaterialController::class);
        });
    }

    //______________________ SOLICITUDES
    if (class_exists(SolicitudController::class) && class_exists(MaterialController::class)) {
        Route::group(['middleware' => ['permission:SOLICITUDES']], function () {
            Route::get('solicitudes/sucursal/{id_suc}', [SolicitudController::class, 'solicitudes']);
            Route::get('solicitud/atender/{id_sol}', [SolicitudController::class, 'atender']);
            Route::get('material/buscaMaterial/{id_mat}', [MaterialController::class, 'buscaMaterial']);
            Route::name('solicitud.enviar')->post('solicitud/enviar', [SolicitudController::class, 'enviar']);
            Route::name('solicitud.recepcion')->post('solicitud/recepcion', [SolicitudController::class, 'recepcion']);
            Route::name('solicitud.elimina')->post('solicitud/elimina', [SolicitudController::class, 'elimina']);
            Route::resource('solicitud', SolicitudController::class);
        });
    }

    //______________________ GASTOS
    if (class_exists(GastoController::class)) {
        Route::group(['middleware' => ['permission:GASTOS']], function () {
            Route::get('gastos/sucursal/{id_suc}/{fecha}', [GastoController::class, 'gastos']);
            Route::get('gasto/pdf/{id_gas}', [GastoController::class, 'pdfGasto']);
            Route::name('gasto.elimina')->post('gasto/elimina', [GastoController::class, 'elimina']);
            Route::resource('gasto', GastoController::class);
        });
    }

    //______________________ REPORTES
    if (class_exists(ReporteController::class)) {
        Route::group(['middleware' => ['permission:REPORTES']], function () {
            Route::name('reporte.ingreso_egreso')->post('reporte/ingreso_egreso', [ReporteController::class, 'ingreso_egreso']);
            Route::get('reporte/pdf/ingreso_egreso_detalle/{tipo}/{id_suc}/{fec_ini}/{fec_fin}/{mes}/{anio_m}/{anio_a}', [ReporteController::class, 'pdf_ingreso_egreso_detalle']);
            Route::get('reporte/pdf/ingreso_egreso/{tipo}/{id_suc}/{fec_ini}/{fec_fin}/{mes}/{anio_m}/{anio_a}', [ReporteController::class, 'pdf_ingreso_egreso']);

            Route::name('reporte.clientes')->post('reporte/clientes', [ReporteController::class, 'clientes']);
            Route::get('reporte/pdf/clientes/{id_suc}/{tipo}', [ReporteController::class, 'clientes_pdf']);

            Route::name('reporte.ingresos_egresos_total')->post('reporte/ingresos_egresos_total', [ReporteController::class, 'ingresos_egresos_total']);

            Route::name('reporte.mes_ingreso')->post('reporte/mes_ingreso', [ReporteController::class, 'mes_ingreso']);
            Route::name('reporte.puntualesDeudoresBody')->post('reporte/puntualesDeudoresBody', [ReporteController::class, 'puntualesDeudoresBody']);

            Route::get('reporte/pdf/cliente/{id_cli}', [ReporteController::class, 'informacion_pdf']);

            Route::resource('reporte', ReporteController::class);
        });
    }

    //______________________ ALERTAS
    if (class_exists(AlertaController::class)) {
        Route::group(['middleware' => ['permission:ALERTAS']], function () {
            Route::name('alerta.deudores')->post('alerta/deudores', [AlertaController::class, 'deudores']);
            Route::get('alerta/deudores/{id_suc}', [AlertaController::class, 'pdf_deudores']);
            Route::get('alerta/asignados/{id_suc}', [AlertaController::class, 'pdf_asignados']);
            Route::resource('alerta', AlertaController::class);
        });
    }

    //______________________ ASIGNACION
    if (class_exists(AsignacionController::class)) {
        Route::group(['middleware' => ['permission:ASIGNACIONES']], function () {
            Route::get('asignacion/clientes/pendientes/{id_suc}', [AsignacionController::class, 'clientes_pendientes']);
            Route::name('asignacion.asigna')->post('asignacion/asigna', [AsignacionController::class, 'asigna']);
            Route::get('asignacion/pdf/{id_con}', [AsignacionController::class, 'pdf_asignacion']);
            Route::get('asignaciones/pdf/{id_suc}', [AsignacionController::class, 'pdf_asignaciones']);
            Route::resource('asignacion', AsignacionController::class);
        });
    }

    //______________________ WEB
    Route::group(['middleware' => ['permission:WEB']], function () {
        if (class_exists(SolicitudWebController::class)) {
            Route::get('/solicitudWeb', [SolicitudWebController::class, 'index']);
            Route::get('web/solicitudes/{id_suc}', [SolicitudWebController::class, 'solicitudes']);
        }

        if (class_exists(ReclamoController::class)) {
            Route::get('/reclamo', [ReclamoController::class, 'index']);
            Route::get('web/reclamos/{id_suc}', [ReclamoController::class, 'reclamos']);
            Route::name('reclamo.atender')->post('reclamo/atender', [ReclamoController::class, 'atender']);
        }
    });

    if (class_exists(BulkController::class)) {
        Route::resource('excel', BulkController::class);
    }
});

