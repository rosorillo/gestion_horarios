import { Routes } from '@angular/router';
import { DashboardComponent } from './dashboard/dashboard';
import {ProfessorsComponent} from './professors/professors';
import { LoginComponent } from './login/login';
import { authGuard } from './guards/auth-guard'
import {ScheduleComponent} from './schedule/scheduleComponent';
export const routes: Routes = [
  { path: '',
    redirectTo: 'login',
    pathMatch: 'full',
  },
  {
    path: 'login',
    component: LoginComponent
  },
  {
    path: 'profesores',
    component: ProfessorsComponent,
    canActivate: [authGuard],
  },
  {
    path: 'asignaturas',
    component: ScheduleComponent,
    canActivate: [authGuard],
  },
  {
    path: 'horario',
    component: DashboardComponent,
    canActivate: [authGuard],
  },
  {
    path: '**',
    redirectTo: 'login',
  }
];
