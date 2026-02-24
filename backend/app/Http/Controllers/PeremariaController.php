<?php

namespace App\Http\Controllers;

use App\Models\Ausencia;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeremariaController extends Controller
{
    /**
     * Aulas con ausencias de profesores (público, para el profesor de guardia).
     * Query param opcional: fecha (Y-m-d). Por defecto hoy.
     */
    public function index(Request $request)
    {
        $fecha = $request->has('fecha')
            ? Carbon::parse($request->fecha)->startOfDay()
            : Carbon::today();

        $ausencias = Ausencia::with([
            'user:id,nombre',
            'ausenciaDetalles.horario.aula',
            'ausenciaDetalles.horario.asignatura',
            'ausenciaDetalles.horario.curso',
            'ausenciaDetalles.horario.franjaHoraria'
        ])
            ->whereDate('fecha_inicio', '<=', $fecha)
            ->whereDate('fecha_fin', '>=', $fecha)
            ->get();

        $aulasMap = [];
        foreach ($ausencias as $ausencia) {
            foreach ($ausencia->ausenciaDetalles as $detalle) {
                $aula = $detalle->horario?->aula;
                if (!$aula) continue;
                $aulaId = $aula->id;
                if (!isset($aulasMap[$aulaId])) {
                    $aulasMap[$aulaId] = [
                        'aula' => [
                            'id' => $aula->id,
                            'nombre' => $aula->nombre,
                        ],
                        'ausencias' => [],
                    ];
                }
                $profesorKey = $ausencia->user->id;
                if (!isset($aulasMap[$aulaId]['ausencias'][$profesorKey])) {
                    $aulasMap[$aulaId]['ausencias'][$profesorKey] = [
                        'profesor' => [
                            'id' => $ausencia->user->id,
                            'nombre' => $ausencia->user->nombre,
                        ],
                        'fecha_inicio' => $ausencia->fecha_inicio,
                        'fecha_fin' => $ausencia->fecha_fin,
                        'motivo' => $ausencia->motivo,
                        'detalles' => [],
                    ];
                }
                $aulasMap[$aulaId]['ausencias'][$profesorKey]['detalles'][] = [
                    'fecha' => $detalle->fecha,
                    'tareas' => $detalle->tareas,
                    'asignatura' => $detalle->horario->asignatura?->nombre,
                    'curso' => $detalle->horario->curso?->nombre,
                    'franja' => $detalle->horario->franjaHoraria ? [
                        'hora_inicio' => $detalle->horario->franjaHoraria->hora_inicio,
                        'hora_fin' => $detalle->horario->franjaHoraria->hora_fin,
                    ] : null,
                ];
            }
        }

        $resultado = array_values(array_map(function ($item) {
            $item['ausencias'] = array_values($item['ausencias']);
            return $item;
        }, $aulasMap));

        return response()->json($resultado);
    }
}
