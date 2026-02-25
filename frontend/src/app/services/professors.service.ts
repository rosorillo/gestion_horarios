import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

export interface Professor {
  id: number;
  name: string;
  email: string;
}

@Injectable({
  providedIn: 'root'
})
export class ProfessorsService {

  private apiBase = '/api/usuarios';


  constructor(private http: HttpClient) {}

  getAll(): Observable<Professor[]> {
    return this.http.get<Professor[]>(this.apiBase)
      .pipe(catchError(this.handleError));
  }

  getById(id: number): Observable<Professor> {
    return this.http.get<Professor>(`${this.apiBase}/${id}`)
      .pipe(catchError(this.handleError));
  }

  create(data: Partial<Professor>): Observable<Professor> {
    return this.http.post<Professor>(this.apiBase, data)
      .pipe(catchError(this.handleError));
  }

  update(id: number, data: Partial<Professor>): Observable<Professor> {
    return this.http.put<Professor>(`${this.apiBase}/${id}`, data)
      .pipe(catchError(this.handleError));
  }

  delete(id: number): Observable<void> {
    return this.http.delete<void>(`${this.apiBase}/${id}`)
      .pipe(catchError(this.handleError));
  }

  private handleError(error: HttpErrorResponse) {
    console.error('API Error:', error);
    return throwError(() => error);
  }

  getProfessor(id: number): Observable<any> {
    return this.http.get(`${this.apiBase}/${id}`);
  }
}
