import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, RouterLink} from '@angular/router';
import {ProfessorsService } from '../../services/professors.service';

@Component({
  selector: 'app-professor-show',
  imports: [RouterLink],
  templateUrl: './professor-show.html',
  styleUrls: ['./professor-show.scss']
})
export class ProfessorShowComponent implements OnInit {

  professor: any = null;
  id!: number;

  constructor(
    private route: ActivatedRoute,
    private professorService: ProfessorsService
  ) {}

  ngOnInit(): void {
    this.id = Number(this.route.snapshot.paramMap.get('id'));
    this.loadProfessor();
  }

  loadProfessor(): void {
    this.professorService.getProfessor(this.id).subscribe({
      next: (data) => this.professor = data,
      error: (err) => console.error(err)
    });
  }
}
