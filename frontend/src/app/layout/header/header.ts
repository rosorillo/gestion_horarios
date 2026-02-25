import { Component, inject } from '@angular/core';
import { AuthService } from '../../services/auth-service';
import { Router, RouterLink } from '@angular/router';

@Component({
  selector: 'app-header',
  imports: [RouterLink],
  templateUrl: './header.html',
  styleUrl: './header.scss',
})
export class Header {
  private auth = inject(AuthService);
  private router = inject(Router);

  get isLoggedIn(): boolean {
    return this.auth.isAuth();
  }

  logout() {
    this.auth.logout().subscribe({
      next: () => this.router.navigate(['/login']),
      error: () => {
        // si falla la API, al menos limpia local
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        this.router.navigate(['/login']);
      }
    });
  }

  get isAdmin(): boolean {
    return this.auth.isAdmin();
  }
}
