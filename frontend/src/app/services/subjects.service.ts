import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

export interface Subject {
  id: number;
  nombre: string;
  created_at: string;
  updated_at: string;
}

@Injectable({ providedIn: 'root' })
export class SubjectsService {
  private apiBase = '/api/asignaturas';

  constructor(private http: HttpClient) {}

  getAll(): Observable<Subject[]> {
    return this.http.get<Subject[]>(this.apiBase).pipe(catchError(this.handleError));
  }

  getById(id: number): Observable<Subject> {
    return this.http.get<Subject>(`${this.apiBase}/${id}`).pipe(catchError(this.handleError));
  }

  delete(id: number): Observable<void> {
    return this.http.delete<void>(`${this.apiBase}/${id}`).pipe(catchError(this.handleError));
  }

  private handleError(error: HttpErrorResponse) {
    console.error('API Error:', error);
    return throwError(() => error);
  }
}
