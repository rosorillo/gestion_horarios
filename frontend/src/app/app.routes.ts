import { Routes } from '@angular/router';
import { DashboardComponent } from './dashboard/dashboard';

export const routes: Routes = [
  { path: '', component: DashboardComponent },
  {
    path: 'profesores',
    loadComponent: () =>
      import('./professors/professors')
        .then(m => m.ProfessorsComponent)
  },
  {
    path: 'asignaturas',
    loadComponent: () =>
      import('./subjects/subjects')
        .then(m => m.Subjects)
  },
  {
    path: 'horario',
    loadComponent: () =>
      import('./schedule/scheduleComponent')
        .then(m => m.ScheduleComponent)
  }
];
