import { Component, inject, OnInit, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import { ProfessorsService, Professor } from '../services/professors.service';

@Component({
  selector: 'app-professors',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './professors.html',
})
export class ProfessorsComponent implements OnInit {
  private professorsService = inject(ProfessorsService);

  profesores = signal<Professor[]>([]);
  cargando = signal<boolean>(true);
  error = signal<string | null>(null);

  ngOnInit(): void {
    this.cargando.set(true);
    this.error.set(null);

    this.professorsService.getAll().subscribe({
      next: (data) => {
        this.profesores.set(data);
        this.cargando.set(false);
      },
      error: (err) => {
        console.error('Error cargando profesores', err);
        this.error.set('No se pudieron cargar los profesores');
        this.cargando.set(false);
      }
    });
  }
}
