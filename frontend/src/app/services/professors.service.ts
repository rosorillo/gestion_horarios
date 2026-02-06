import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Professor {
  id: number;
  name: string;
  email: string;
}

@Injectable({
  providedIn: 'root'
})
export class ProfessorsService {

  private apiUrl = 'http://localhost:8000/api/profesores';

  constructor(private http: HttpClient) {}

  getAll(): Observable<Professor[]> {
    return this.http.get<Professor[]>(this.apiUrl);
  }

  getById(id: number): Observable<Professor> {
    return this.http.get<Professor>(`${this.apiUrl}/${id}`);
  }

  create(data: Partial<Professor>): Observable<Professor> {
    return this.http.post<Professor>(this.apiUrl, data);
  }

  update(id: number, data: Partial<Professor>): Observable<Professor> {
    return this.http.put<Professor>(`${this.apiUrl}/${id}`, data);
  }

  delete(id: number): Observable<void> {
    return this.http.delete<void>(`${this.apiUrl}/${id}`);
  }
}
