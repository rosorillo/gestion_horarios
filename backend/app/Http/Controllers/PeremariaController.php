<?php

namespace App\Http\Controllers;

use App\Models\Ausencia;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Endpoint público: no requiere autenticación.
 * Para el profesor de guardia: ver profesores que faltan, días, horas y tareas.
 */
class PeremariaController extends Controller
{
    /**
     * Aulas con ausencias y resumen de profesores ausentes (público).
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
        $resumen = [];

        foreach ($ausencias as $ausencia) {
            if (!$ausencia->user) {
                continue;
            }

            $horasYTareas = [];

            foreach ($ausencia->ausenciaDetalles as $detalle) {
                $franja = $detalle->horario?->franjaHoraria;
                $horasYTareas[] = [
                    'hora_inicio' => $franja?->hora_inicio,
                    'hora_fin' => $franja?->hora_fin,
                    'asignatura' => $detalle->horario?->asignatura?->nombre,
                    'curso' => $detalle->horario?->curso?->nombre,
                    'tareas' => $detalle->tareas ?? '',
                ];

                $aula = $detalle->horario?->aula;
                if (!$aula) continue;

                $aulaId = $aula->id;
                if (!isset($aulasMap[$aulaId])) {
                    $aulasMap[$aulaId] = [
                        'aula' => ['id' => $aula->id, 'nombre' => $aula->nombre],
                        'ausencias' => [],
                    ];
                }
                $profesorKey = $ausencia->user->id;
                if (!isset($aulasMap[$aulaId]['ausencias'][$profesorKey])) {
                    $aulasMap[$aulaId]['ausencias'][$profesorKey] = [
                        'profesor' => ['id' => $ausencia->user->id, 'nombre' => $ausencia->user->nombre],
                        'dias' => [
                            'desde' => Carbon::parse($ausencia->fecha_inicio)->toDateString(),
                            'hasta' => Carbon::parse($ausencia->fecha_fin)->toDateString(),
                        ],
                        'motivo' => $ausencia->motivo,
                        'horas_y_tareas' => [],
                    ];
                }
                $aulasMap[$aulaId]['ausencias'][$profesorKey]['horas_y_tareas'][] = [
                    'hora_inicio' => $franja?->hora_inicio,
                    'hora_fin' => $franja?->hora_fin,
                    'asignatura' => $detalle->horario?->asignatura?->nombre,
                    'curso' => $detalle->horario?->curso?->nombre,
                    'tareas' => $detalle->tareas ?? '',
                ];
            }

            $resumen[] = [
                'profesor' => ['id' => $ausencia->user->id, 'nombre' => $ausencia->user->nombre],
                'dias' => [
                    'desde' => Carbon::parse($ausencia->fecha_inicio)->toDateString(),
                    'hasta' => Carbon::parse($ausencia->fecha_fin)->toDateString(),
                ],
                'motivo' => $ausencia->motivo,
                'horas_y_tareas' => $horasYTareas,
            ];
        }

        $aulas = array_values(array_map(function ($item) {
            $item['ausencias'] = array_values($item['ausencias']);
            return $item;
        }, $aulasMap));

        $tareas = [];
        foreach ($resumen as $r) {
            foreach ($r['horas_y_tareas'] as $h) {
                $tareas[] = [
                    'profesor' => $r['profesor']['nombre'],
                    'asignatura' => $h['asignatura'] ?? null,
                    'curso' => $h['curso'] ?? null,
                    'hora_inicio' => $h['hora_inicio'] ?? null,
                    'hora_fin' => $h['hora_fin'] ?? null,
                    'tareas' => $h['tareas'] ?? '',
                ];
            }
        }

        return response()->json([
            'fecha' => $fecha->toDateString(),
            'aulas' => $aulas,
            'profesores_ausentes' => $resumen,
            'tareas' => $tareas,
        ]);
    }
}
