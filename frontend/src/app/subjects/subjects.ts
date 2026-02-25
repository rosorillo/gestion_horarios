import { Component, inject, OnInit, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import { SubjectsService, Subject } from '../services/subjects.service';

@Component({
  selector: 'app-subjects',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './subjects.html',
  styleUrls: ['./subjects.scss'],
})
export class SubjectsComponent implements OnInit {
  private subjectService = inject(SubjectsService);

  subjects = signal<Subject[]>([]);
  cargando = signal<boolean>(true);
  error = signal<string | null>(null);

  ngOnInit(): void {
    this.getAll();
  }

  getAll(): void {
    this.cargando.set(true);
    this.error.set(null);

    this.subjectService.getAll().subscribe({
      next: (data) => {
        this.subjects.set(data);
        this.cargando.set(false);
      },
      error: (err) => {
        console.error('Error al obtener asignaturas:', err);
        this.error.set('No se pudieron cargar las asignaturas');
        this.cargando.set(false);
      }
    });
  }

  delete(id: number): void {
    if (!confirm('¿Seguro que quieres eliminar esta asignatura?')) return;

    this.subjectService.delete(id).subscribe({
      next: () => this.getAll(),
      error: (err) => console.error('Error al eliminar:', err)
    });
  }
}
