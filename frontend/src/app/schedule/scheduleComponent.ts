import { Component, OnInit, inject, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Schedule, ScheduleService } from '../services/schedule.service';

@Component({
  selector: 'app-schedules',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './scheduleComponent.html',
  styleUrls: ['./scheduleComponent.scss'],
})
export class ScheduleComponent implements OnInit {
  private scheduleService = inject(ScheduleService);

  schedules = signal<Schedule[]>([]);
  cargando = signal<boolean>(true);
  error = signal<string | null>(null);

  ngOnInit(): void {
    this.cargar();
  }

  cargar(): void {
    this.cargando.set(true);
    this.error.set(null);

    this.scheduleService.getAll().subscribe({
      next: (data) => {
        this.schedules.set(data);
        this.cargando.set(false);
      },
      error: (err) => {
        console.error('Error cargando horarios', err);
        this.error.set('No se pudieron cargar los horarios');
        this.cargando.set(false);
      }
    });
  }

  diaNombre(dia: number): string {
    // Si tu backend usa 1=Lunes ... 7=Domingo
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
