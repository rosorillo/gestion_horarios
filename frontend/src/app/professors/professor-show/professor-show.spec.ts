import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ProfessorShow } from './professor-show';

describe('ProfessorShow', () => {
  let component: ProfessorShow;
  let fixture: ComponentFixture<ProfessorShow>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ProfessorShow]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ProfessorShow);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
