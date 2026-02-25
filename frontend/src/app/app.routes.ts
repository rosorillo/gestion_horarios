import { Routes } from '@angular/router';
import { DashboardComponent } from './dashboard/dashboard';
import {ProfessorsComponent} from './professors/professors';
import { LoginComponent } from './login/login';
import { authGuard } from './guards/auth-guard'
import {ScheduleComponent} from './schedule/scheduleComponent';
import {SubjectsComponent} from './subjects/subjects';
import {SubjectShowComponent} from './subjects/subject-show/subject-show';
import { ProfessorShowComponent } from './professors/professor-show/professor-show';

export const routes: Routes = [
  { path: '', redirectTo: 'dashboard', pathMatch: 'full' },

  { path: 'login', component: LoginComponent },

  { path: 'dashboard', component: DashboardComponent, canActivate: [authGuard] },

  { path: 'horario', component: ScheduleComponent, canActivate: [authGuard] },

  { path: 'profesores', component: ProfessorsComponent, canActivate: [authGuard] },
  { path: 'profesores/:id', component: ProfessorShowComponent, canActivate: [authGuard] },

  { path: 'asignaturas', component: SubjectsComponent, canActivate: [authGuard] },
  { path: 'asignaturas/:id', component: SubjectShowComponent, canActivate: [authGuard] },

  { path: '**', redirectTo: 'dashboard' }
];
