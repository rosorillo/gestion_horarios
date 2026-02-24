import { Component, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import {Schedule, ScheduleService} from '../services/schedule.service';

@Component({
  selector: 'app-schedules',
  imports: [CommonModule],
  templateUrl: './scheduleComponent.html',
  styleUrl: './scheduleComponent.scss',
})
export class ScheduleComponent {
  public schedules: Schedule[] = [];

  constructor(){}

  private scheduleService = inject(ScheduleService);


}
