import { ComponentFixture, TestBed } from '@angular/core/testing';

import { Peremaria } from './peremaria';

describe('Peremaria', () => {
  let component: Peremaria;
  let fixture: ComponentFixture<Peremaria>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [Peremaria]
    })
    .compileComponents();

    fixture = TestBed.createComponent(Peremaria);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
