import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

export interface AusenciaUser {
  id: number;
  email: string;
  nombre: string;
  rol: string;
  foto: string | null;
  created_at: string;
  updated_at: string;
}

export interface Ausencia {
  id: number;
  usuario_id: number;
  fecha_inicio: string; // "2026-02-24 21:02:50"
  fecha_fin: string;    // "2026-02-26 21:02:50"
  motivo: string;
  created_at: string;
  updated_at: string;
  user: AusenciaUser;
}

@Injectable({ providedIn: 'root' })
export class AusenciasService {
  private apiBase = '/api/ausencias';

  constructor(private http: HttpClient) {}

  getAll(): Observable<Ausencia[]> {
    return this.http.get<Ausencia[]>(this.apiBase).pipe(catchError(this.handleError));
  }

  private handleError(error: HttpErrorResponse) {
    console.error('API Error:', error);
    return throwError(() => error);
  }
}
