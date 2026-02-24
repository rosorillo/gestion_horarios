import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { inject } from '@angular/core';
import { SubjectsService, Subject } from '../subjects.service';

@Component({
  selector: 'app-subjects',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './subjects.html',
  styleUrls: ['./subjects.scss'],
})
export class SubjectsComponent {

  private subjectService = inject(SubjectsService);

  subjects: Subject[] = [];
  selectedSubject: Subject | null = null;

  constructor() {
    this.getAll(); // cargar al inicio
  }

  // 🔹 Obtener todas las asignaturas
  getAll() {
    this.subjectService.getAll().subscribe({
      next: (data) => {
        this.subjects = data;
        console.log('Asignaturas cargadas:', this.subjects);
      },
      error: (err) => {
        console.error('Error al obtener asignaturas:', err);
      }
    });
  }

  // 🔹 Obtener asignatura por ID
  getById(id: number) {
    this.subjectService.getAll().subscribe({
      next: (data) => {
        this.selectedSubject = data.find(s => s.id === id) || null;
        console.log('Asignatura seleccionada:', this.selectedSubject);
      },
      error: (err) => console.error('Error al buscar asignatura:', err)
    });
  }

  // 🔹 Eliminar asignatura
  delete(id: number) {
    if (!confirm('¿Seguro que quieres eliminar esta asignatura?')) return;

    this.subjectService.delete(id).subscribe({
      next: () => {
        console.log('Asignatura eliminada:', id);
        // refrescar lista
        this.getAll();
      },
      error: (err) => console.error('Error al eliminar:', err)
    });
  }

  // 🔹 Mostrar asignatura (ejemplo para modal o console)
  show(id: number) {
    this.getById(id);
    if (this.selectedSubject) {
      console.log('Mostrar asignatura:', this.selectedSubject);
    }
  }
}
