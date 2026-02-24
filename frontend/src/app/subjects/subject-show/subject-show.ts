import { Component } from '@angular/core';
import {ActivatedRoute, RouterLink} from '@angular/router';
import {SubjectsService} from '../../services/subjects.service';


@Component({
  selector: 'app-subject-show',
  imports: [RouterLink],
  templateUrl: './subject-show.html',
  styleUrl: './subject-show.scss',
})
export class SubjectShowComponent {
  subject: any;
  id!: number;

  constructor(
    private route: ActivatedRoute,
    private subjectService: SubjectsService
  ) {}

  ngOnInit(): void {
    this.id = Number(this.route.snapshot.paramMap.get('id'));
    this.loadSubject();
  }

  loadSubject(): void {
    this.subjectService.getSubject(this.id).subscribe({
      next: (data) => this.subject = data,
      error: (err) => console.error(err)
    });
  }
}
