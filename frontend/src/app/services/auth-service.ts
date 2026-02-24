import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {tap} from 'rxjs';
@Injectable({
  providedIn: 'root',
})
export class AuthService {


  private apiUrl = 'http://localhost:8000/api/login';

  constructor(private http: HttpClient) {}

  login(email: string, password: string) {
    return this.http.post<any>(this.apiUrl, {
      email,
      password
    }).pipe(
      tap(response => {
        localStorage.setItem('user', JSON.stringify(response.user));
        if (response.token) {
          localStorage.setItem('token', response.token);
        }
      })
    );
  }

  isAuth():boolean
  {
    const token = localStorage.getItem('token');
    if(token){
      return true;
    }
    else{
      return false;
    }
  }
}
