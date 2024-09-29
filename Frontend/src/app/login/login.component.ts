import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { RequesterService } from '../Services/requester.service';
import { EnumEndpoints } from '../Enum/enum-endpoints';
import { Router } from '@angular/router';
import { SecurityService } from '../Services/security.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {

  UserFormGroup! : FormGroup

  constructor(
    private FormBuilder : FormBuilder,
    private SecurityService : SecurityService,
    // private RequesterService : RequesterService,
    private Router : Router
  ) {}

  ngOnInit(): void {
    //Called after the constructor, initializing input properties, and the first call to ngOnChanges.
    //Add 'implements OnInit' to the class.
    this.InitFormGroup();

  }


  InitFormGroup()
  {
    this.UserFormGroup=this.FormBuilder.group(
      {
        email : ['', Validators.required],
        password : ['', Validators.required],
      }
    )

  }

  Login()
  {

    this.SecurityService.Login(this.UserFormGroup.value)
    // var ReturnedResponse =await this.RequesterService.AsyncPostResponse(EnumEndpoints.Authentication,this.UserFormGroup.value,false,true,false)
    // ReturnedResponse[0]== 1 ? this.Router.navigateByUrl('DashboardMedecin') : null
    // console.log('ISOK',ReturnedResponse[0])
  }

}
