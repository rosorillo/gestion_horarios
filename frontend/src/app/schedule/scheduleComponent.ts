import { Component } from '@angular/core';
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

  constructor(private scheduleService: ScheduleService) {}

  ngOnInit() {
    this.scheduleService.getAll().subscribe({
      next: data => this.schedules = data,
      error: err => console.error(err)
    });
  }
}
