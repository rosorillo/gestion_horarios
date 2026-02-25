import { Component, OnInit, inject, signal } from '@angular/core';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { CommonModule } from '@angular/common';
import { ProfessorsService, Professor } from '../../services/professors.service';

@Component({
  selector: 'app-professor-show',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './professor-show.html',
  styleUrls: ['./professor-show.scss']
})
export class ProfessorShowComponent implements OnInit {
  private route = inject(ActivatedRoute);
  private professorService = inject(ProfessorsService);

  professor = signal<Professor | null>(null);
  cargando = signal<boolean>(true);
  id: number = 0;


  ngOnInit(): void {
    const rawId = this.route.snapshot.paramMap.get('id');
    this.id = rawId ? Number(rawId) : 0;

    this.professorService.getById(this.id).subscribe({
      next: (data) => {
        console.log('DATA SHOW', data);
        this.professor.set(data);
        this.cargando.set(false);
      },
      error: (err) => {
        console.error(err);
        this.cargando.set(false);
      }
    });
  }
}
