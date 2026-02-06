import { Component, signal, NgModule  } from '@angular/core';

import { Header } from './layout/header/header';
import { Footer } from './layout/footer/footer';
import { Login } from './login/login';
import {RouterOutlet} from '@angular/router';


@Component({
  selector: 'app-root',
  imports: [Header, Footer, RouterOutlet],
  templateUrl: './app.html',
  styleUrl: './app.scss'
})
export class App {
  protected readonly title = signal('web');
}
