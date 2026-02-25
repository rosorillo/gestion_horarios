import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

export interface PeremariaResponse {
  // lo dejamos flexible hasta ver tu JSON
  horarios?: any[];
  ausencias_hoy?: any[];
  profesores?: any[];
}

@Injectable({ providedIn: 'root' })
export class PeremariaService {
  private apiBase = '/api/peremaria';

  constructor(private http: HttpClient) {}

  getToday(): Observable<PeremariaResponse | any[]> {
    return this.http.get<PeremariaResponse | any[]>(this.apiBase)
      .pipe(catchError(this.handleError));
  }

  getProfesores(): Observable<any[]> {
  return this.http.get<any[]>('/api/usuarios')
    .pipe(catchError(this.handleError));
  }

  private handleError(error: HttpErrorResponse) {
    console.error('API Error:', error);
    return throwError(() => error);
  }


}
