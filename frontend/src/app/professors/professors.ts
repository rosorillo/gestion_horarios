import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ProfessorsService, Professor } from '../services/professors.service';
import {RouterLink} from '@angular/router';

@Component({
  selector: 'app-professors',
  imports: [CommonModule, RouterLink],
  templateUrl: './professors.html'
})
export class ProfessorsComponent implements OnInit {

  public professors: Professor[] = [];

  constructor(private professorsService: ProfessorsService) {}

  ngOnInit() {
    this.professorsService.getAll().subscribe({
      next: data => this.professors = data,    // Guardamos los datos para mostrar
      error: err => console.error(err)
    });
  }
}
