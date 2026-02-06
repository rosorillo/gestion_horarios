import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Schedule {
  id: number;
  professor_id: number;
  subject_id: number;
  day: string;
  start_time: string;
  end_time: string;
}

@Injectable({
  providedIn: 'root'
})
export class ScheduleService {

  private apiUrl = 'http://localhost:8000/api/horarios';

  constructor(private http: HttpClient) {}

  getAll(): Observable<Schedule[]> {
    return this.http.get<Schedule[]>(this.apiUrl);
  }

  create(data: Partial<Schedule>): Observable<Schedule> {
    return this.http.post<Schedule>(this.apiUrl, data);
  }

  delete(id: number): Observable<void> {
    return this.http.delete<void>(`${this.apiUrl}/${id}`);
  }
}
