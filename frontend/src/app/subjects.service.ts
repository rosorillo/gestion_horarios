import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

export interface Subject {
  id: number;
  name: string;
  code: string;
}

@Injectable({
  providedIn: 'root'
})
export class SubjectsService {


  private apiUrl = `http://localhost:4200/api/asignaturas`;

  constructor(private http: HttpClient) {}

  // 🔹 Obtener todas las asignaturas
  getAll(): Observable<Subject[]> {
    return this.http.get<Subject[]>(this.apiUrl)
      .pipe(catchError(this.handleError));
  }

  // 🔹 Obtener una asignatura por ID
  getById(id: number): Observable<Subject> {
    return this.http.get<Subject>(`${this.apiUrl}/${id}`)
      .pipe(catchError(this.handleError));
  }

  // 🔹 Crear asignatura
  create(data: Partial<Subject>): Observable<Subject> {
    return this.http.post<Subject>(this.apiUrl, data)
      .pipe(catchError(this.handleError));
  }

  // 🔹 Actualizar asignatura
  update(id: number, data: Partial<Subject>): Observable<Subject> {
    return this.http.put<Subject>(`${this.apiUrl}/${id}`, data)
      .pipe(catchError(this.handleError));
  }

  // 🔹 Eliminar asignatura
  delete(id: number): Observable<void> {
    return this.http.delete<void>(`${this.apiUrl}/${id}`)
      .pipe(catchError(this.handleError));
  }

  // 🔹 Manejo de errores
  private handleError(error: HttpErrorResponse) {
    console.error('API Error:', error);
    return throwError(() => error);
  }
}
