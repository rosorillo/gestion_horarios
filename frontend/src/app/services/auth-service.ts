import { inject, Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { tap } from 'rxjs';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root',
})
export class AuthService {

  private apiBase = '/api';
  private router = inject(Router);

  constructor(private http: HttpClient) {}

  login(email: string, password: string) {
    return this.http.post<any>(
      `${this.apiBase}/login`,
      { email, password },
      { headers: { Accept: 'application/json' } }
    ).pipe(
      tap(response => {

        if (response.user) {
          localStorage.setItem('user', JSON.stringify(response.user));
        }

        if (response.token) {
          localStorage.setItem('token', response.token);
          this.router.navigate(['/dashboard']);
        }

      })
    );
  }

  isAuth(): boolean {
    const token = localStorage.getItem('token');

    if (token !== null && token !== undefined && token !== '') {
      return true;
    } else {
      return false;
    }
  }

  getUser() {
    const user = localStorage.getItem('user');

    if (user !== null && user !== undefined) {
      return JSON.parse(user);
    } else {
      return null;
    }
  }

  isAdmin(): boolean {
    const user = this.getUser();

    if (user !== null && user.rol === 'admin') {
      return true;
    } else {
      return false;
    }
  }

  logout() {
    return this.http.post(`${this.apiBase}/logout`, {}, {
      headers: { Accept: 'application/json' }
    }).pipe(
      tap(() => {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        this.router.navigate(['/login']);
      })
    );
  }
}
