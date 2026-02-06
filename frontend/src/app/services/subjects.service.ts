import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Subject {
  id: number;
  name: string;
  code: string;
}

@Injectable({
  providedIn: 'root'
})
export class SubjectsService {

  private apiUrl = 'http://localhost:8000/api/asignaturas';

  constructor(private http: HttpClient) {}

  getAll(): Observable<Subject[]> {
    return this.http.get<Subject[]>(this.apiUrl);
  }

  create(data: Partial<Subject>): Observable<Subject> {
    return this.http.post<Subject>(this.apiUrl, data);
  }

  update(id: number, data: Partial<Subject>): Observable<Subject> {
    return this.http.put<Subject>(`${this.apiUrl}/${id}`, data);
  }

  delete(id: number): Observable<void> {
    return this.http.delete<void>(`${this.apiUrl}/${id}`);
  }
}
