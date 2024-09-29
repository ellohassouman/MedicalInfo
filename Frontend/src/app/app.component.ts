import { Component } from '@angular/core';
import { SecurityService } from './Services/security.service';

declare function AllFunctionInit(): any;

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  constructor(public SecurityService : SecurityService) {}

  ngOnInit(): void {
    //Called after the constructor, initializing input properties, and the first call to ngOnChanges.
    //Add 'implements OnInit' to the class.
    setTimeout(() => {
      AllFunctionInit();
    }, 1);
  }
}
