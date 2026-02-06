import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-professors',
  imports: [CommonModule],
  //templateUrl: './professors.html',
  styleUrl: './subjects.scss',
  template: `
    <div class="container my-4">
      <h2>Modulos</h2>
      <p>Página de gestión de modulos</p>
    </div>
  `
})
export class Subjects {

}
