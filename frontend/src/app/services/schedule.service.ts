import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs';

export interface ScheduleUser {
  id: number;
  email: string;
  nombre: string;
  rol: string;
  foto: string |null;
  created_at: string;
  updated_at: string;
}

export interface ScheduleAsignatura {
  id: number;
  nombre: string;
  created_at: string;
  updated_at: string;
}

export interface ScheduleCurso {
  id: number;
  nombre: string;
  created_at: string;
  updated_at: string;
}

export interface ScheduleAula {
  id: number;
  nombre: string;
  created_at: string;
  updated_at: string;
}

export interface ScheduleFranjaHoraria {
  id: number;
  hora_inicio: string; // "08:00:00"
  hora_fin: string;    // "09:00:00"
  orden: number;
  created_at: string;
  updated_at: string;
}

export interface Schedule {
  id: number;
  usuario_id: number;
  asignatura_id: number;
  curso_id: number;
  aula_id: number;
  franja_id: number;
  dia_semana: number; // 1-7

  created_at: string;
  updated_at: string;

  user: ScheduleUser;
  asignatura: ScheduleAsignatura;
  curso: ScheduleCurso;
  aula: ScheduleAula;
  franja_horaria: ScheduleFranjaHoraria;
}

@Injectable({
  providedIn: 'root'
})
export class ScheduleService {

  private apiBase = '/api/horarios';

  constructor(private http: HttpClient) {}

  getAll(): Observable<Schedule[]> {
    return this.http.get<Schedule[]>(this.apiBase).pipe(catchError(this.handleError));
  }

  delete(id: number): Observable<void> {
    return this.http.delete<void>(`${this.apiBase}/${id}`).pipe(catchError(this.handleError));
  }

  private handleError(error: HttpErrorResponse) {
    console.error('API Error:', error);
    return throwError(() => error);
  }
}
