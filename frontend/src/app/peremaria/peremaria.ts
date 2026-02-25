import { Component, OnInit, inject, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import { ScheduleService, Schedule } from '../services/schedule.service';
import { AusenciasService, Ausencia } from '../services/ausencias';

@Component({
  selector: 'app-peremaria',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './peremaria.html',
})
export class PeremariaComponent implements OnInit {
  private scheduleService = inject(ScheduleService);
  private ausenciasService = inject(AusenciasService);

  cargando = signal<boolean>(true);
  error = signal<string | null>(null);

  profesores = signal<any[]>([]);      // cards: TODOS
  faltasHoy = signal<Schedule[]>([]);  // tabla: solo afectados hoy

  ngOnInit(): void {
    this.cargar();
  }

  cargar(): void {
    this.cargando.set(true);
    this.error.set(null);

    this.scheduleService.getAll().subscribe({
      next: (horarios) => {
        // ✅ cards: todos los profes a partir del horario
        const map = new Map<number, any>();
        for (const h of horarios) {
          if (h.user && h.user.id && !map.has(h.user.id)) {
            map.set(h.user.id, h.user);
          }
        }
        this.profesores.set(Array.from(map.values()));

        // ✅ ausencias: cruzamos por rango de fechas (hoy)
        this.ausenciasService.getAll().subscribe({
          next: (ausencias) => {
            const ausentesHoy = this.usuariosAusentesHoy(ausencias);

            const afectado = horarios.filter(h => ausentesHoy.has(h.usuario_id));
            this.faltasHoy.set(afectado);

            this.cargando.set(false);
          },
          error: (err) => {
            console.error(err);
            this.error.set('No se pudieron cargar las ausencias');
            this.cargando.set(false);
          }
        });
      },
      error: (err) => {
        console.error(err);
        this.error.set('No se pudo cargar el horario');
        this.cargando.set(false);
      }
    });
  }

  // ---------- FILTRO CORRECTO ----------
  private usuariosAusentesHoy(ausencias: Ausencia[]): Set<number> {
    const ahora = new Date(); // hora local del navegador

    const set = new Set<number>();

    for (const a of ausencias) {
      const inicio = this.parseLaravelDate(a.fecha_inicio);
      const fin = this.parseLaravelDate(a.fecha_fin);

      if (inicio && fin) {
        if (inicio.getTime() <= ahora.getTime() && ahora.getTime() <= fin.getTime()) {
          set.add(a.usuario_id);
        }
      }
    }

    return set;
  }

  // "2026-02-24 21:02:50" -> Date
  private parseLaravelDate(value: string): Date | null {
    if (!value) return null;

    // Convertimos "YYYY-MM-DD HH:mm:ss" a "YYYY-MM-DDTHH:mm:ss"
    const isoLike = value.replace(' ', 'T');
    const d = new Date(isoLike);

    if (isNaN(d.getTime())) return null;
    return d;
  }

  diaNombre(dia: number): string {
    if (dia === 1) return 'Lunes';
    if (dia === 2) return 'Martes';
    if (dia === 3) return 'Miércoles';
    if (dia === 4) return 'Jueves';
    if (dia === 5) return 'Viernes';
    if (dia === 6) return 'Sábado';
    if (dia === 7) return 'Domingo';
    return `Día ${dia}`;
  }
}
