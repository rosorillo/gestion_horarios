import {Component, inject, } from '@angular/core';
import { FormsModule, ReactiveFormsModule, FormBuilder, Validators } from '@angular/forms';
import {RouterOutlet, RouterLink, RouterLinkWithHref} from '@angular/router';
import {AuthService} from '../services/auth-service';


@Component({
  selector: 'app-login',
  imports: [FormsModule, ReactiveFormsModule, RouterLink],
  templateUrl: './login.html',
  styleUrl: './login.scss',
})
export class LoginComponent {

  private authService = inject(AuthService);
  private fb = inject(FormBuilder);

  loginForm = this.fb.group({
    email: ['', [Validators.required, Validators.email]],
    password: ['', [Validators.required, Validators.minLength(4)]],
  });

  login() {
    if (this.loginForm.invalid) {
      console.log('Formulario inválido');
      return;
    }

    const { email, password } = this.loginForm.value;

    this.authService.login(email!, password!)
      .subscribe({
        next: res => {
          console.log('Login OK', res);
        },
        error: err => {
          console.error('Error login', err);
        }
      });
  }

}
