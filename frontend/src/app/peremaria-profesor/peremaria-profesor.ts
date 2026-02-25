import { Component, OnInit, inject, signal, computed } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { Schedule, ScheduleService } from '../services/schedule.service';

type DiaKey = 1 | 2 | 3 | 4 | 5;

interface CellData {
  asignatura: string;
  curso: string;
  aula: string;
  hora_inicio: string;
  hora_fin: string;
}

interface RowData {
  orden: number;
  hora_inicio: string;
  hora_fin: string;
  cells: Partial<Record<DiaKey, CellData[]>>; // por si hay más de 1 clase en la misma franja/día
}

@Component({
  selector: 'app-peremaria-profesor',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './peremaria-profesor.html',
  styleUrls: ['./peremaria-profesor.scss'],
})
export class PeremariaProfesorComponent implements OnInit {
  private route = inject(ActivatedRoute);
  private scheduleService = inject(ScheduleService);

  cargando = signal<boolean>(true);
  error = signal<string | null>(null);

  profesorId = signal<number>(0);
  profesorNombre = signal<string>('Profesor');

  // horarios del profe
  horarios = signal<Schedule[]>([]);

  // tabla semanal (L-V)
  dias: { key: DiaKey; label: string }[] = [
    { key: 1, label: 'Lunes' },
    { key: 2, label: 'Martes' },
    { key: 3, label: 'Miércoles' },
    { key: 4, label: 'Jueves' },
    { key: 5, label: 'Viernes' },
  ];

  rows = computed<RowData[]>(() => {
    const data = this.horarios();

    // agrupar por franja orden
    const map = new Map<number, RowData>();

    for (const h of data) {
      const dia = h.dia_semana as DiaKey;
      if (![1, 2, 3, 4, 5].includes(dia)) continue; // solo L-V

      const orden = h.franja_horaria?.orden ?? 999;

      if (!map.has(orden)) {
        map.set(orden, {
          orden,
          hora_inicio: h.franja_horaria?.hora_inicio ?? '',
          hora_fin: h.franja_horaria?.hora_fin ?? '',
          cells: {},
        });
      }

      const row = map.get(orden)!;

      const cell: CellData = {
        asignatura: h.asignatura?.nombre ?? '—',
        curso: h.curso?.nombre ?? '—',
        aula: h.aula?.nombre ?? '—',
        hora_inicio: row.hora_inicio,
        hora_fin: row.hora_fin,
      };

      const arr = row.cells[dia] ?? [];
      arr.push(cell);
      row.cells[dia] = arr;
    }

    // ordenar por orden de franja
    return Array.from(map.values()).sort((a, b) => a.orden - b.orden);
  });

  ngOnInit(): void {
    const rawId = this.route.snapshot.paramMap.get('id');
    const id = rawId ? Number(rawId) : 0;
    this.profesorId.set(id);

    this.cargar();
  }

  cargar(): void {
    this.cargando.set(true);
    this.error.set(null);

    this.scheduleService.getAll().subscribe({
      next: (all) => {
        const mine = all.filter(h => h.usuario_id === this.profesorId());
        this.horarios.set(mine);

        const nombre = mine[0]?.user?.nombre;
        if (nombre) this.profesorNombre.set(nombre);

        this.cargando.set(false);
      },
      error: (err) => {
        console.error(err);
        this.error.set('No se pudo cargar el horario del profesor');
        this.cargando.set(false);
      }
    });
  }
}
