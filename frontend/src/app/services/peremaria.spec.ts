import { TestBed } from '@angular/core/testing';

import { Peremaria } from './peremaria';

describe('Peremaria', () => {
  let service: Peremaria;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(Peremaria);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
