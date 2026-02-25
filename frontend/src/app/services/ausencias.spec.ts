import { TestBed } from '@angular/core/testing';

import { Ausencias } from './ausencias';

describe('Ausencias', () => {
  let service: Ausencias;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(Ausencias);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
