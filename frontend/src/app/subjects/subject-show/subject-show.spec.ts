import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SubjectShow } from './subject-show';

describe('SubjectShow', () => {
  let component: SubjectShow;
  let fixture: ComponentFixture<SubjectShow>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [SubjectShow]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SubjectShow);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
