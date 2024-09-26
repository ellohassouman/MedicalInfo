import { Component } from '@angular/core';
import { ConfigurationService } from '../Services/configuration.service';

declare function AllFunctionInit(): any;


@Component({
  selector: 'app-dashboard-medecin',
  templateUrl: './dashboard-medecin.component.html',
  styleUrls: ['./dashboard-medecin.component.css']
})
export class DashboardMedecinComponent {

  constructor(public ConfigurationService : ConfigurationService) {}

  ngOnInit(): void {
    //Called after the constructor, initializing input properties, and the first call to ngOnChanges.
    //Add 'implements OnInit' to the class.
    setTimeout(() => {
      AllFunctionInit();
    }, 1);
  }

}
