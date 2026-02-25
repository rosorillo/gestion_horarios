import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PeremariaProfesor } from './peremaria-profesor';

describe('PeremariaProfesor', () => {
  let component: PeremariaProfesor;
  let fixture: ComponentFixture<PeremariaProfesor>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [PeremariaProfesor]
    })
    .compileComponents();

    fixture = TestBed.createComponent(PeremariaProfesor);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
