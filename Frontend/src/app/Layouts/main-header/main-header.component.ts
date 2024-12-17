import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { SecurityService } from 'src/app/Services/security.service';

@Component({
  selector: 'app-main-header',
  templateUrl: './main-header.component.html',
  styleUrls: ['./main-header.component.css']
})
export class MainHeaderComponent {


  constructor(
    private SecurityService : SecurityService,
    // private RequesterService : RequesterService,
    private Router : Router
  ) {}

  Logout()
  {
    this.SecurityService.Logout()
  }

}
