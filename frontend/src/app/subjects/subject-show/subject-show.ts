import { Component, inject, OnInit, signal } from '@angular/core';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { CommonModule } from '@angular/common';
import { SubjectsService, Subject } from '../../services/subjects.service';

@Component({
  selector: 'app-subject-show',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './subject-show.html',
  styleUrls: ['./subject-show.scss'],
})
export class SubjectShowComponent implements OnInit {
  private route = inject(ActivatedRoute);
  private subjectService = inject(SubjectsService);

  subject = signal<Subject | null>(null);
  cargando = signal<boolean>(true);
  id = signal<number>(0);

  ngOnInit(): void {
    const rawId = this.route.snapshot.paramMap.get('id');
    const parsed = rawId ? Number(rawId) : 0;
    this.id.set(parsed);

    this.loadSubject();
  }

  loadSubject(): void {
    this.cargando.set(true);

    this.subjectService.getById(this.id()).subscribe({
      next: (data) => {
        this.subject.set(data);
        this.cargando.set(false);
      },
      error: (err) => {
        console.error(err);
        this.subject.set(null);
        this.cargando.set(false);
      }
    });
  }
}
