import { Injectable } from '@angular/core';
import { RequesterService } from './requester.service';
import { EnumEndpoints } from '../Enum/enum-endpoints';
import { Router } from '@angular/router';
import { UserModel } from '../Models/user-model.model';

@Injectable({
  providedIn: 'root'
})
export class SecurityService {

  constructor(
    private RequesterService : RequesterService,
    private Router : Router
  ) { }


  CheckAuthOld()
    {
      // var IsAuth=0
      // if(localStorage.getItem('CurrentUser')!=null)
      // {
      //   var User : UserModel  = JSON.parse(localStorage.getItem('CurrentUser')!)
      // }
      this.SessionMangerOld()
      var IsAuth = Number(localStorage.getItem('IsAuth'))
      return IsAuth
    }

    CheckAuth()
    {
      var IsAuth=false
      if(localStorage.getItem('CurrentUser')!=null)
      {
        var User : UserModel  = JSON.parse(localStorage.getItem('CurrentUser')!)
        IsAuth=this.SessionManger(User)
      }
      return IsAuth
    }

    SessionManger(User : UserModel)
    {
        var hours = 1; // Reset when storage is more than 1hours
        var now = new Date().getTime();
        var setupTime = User.TimeToEndSession
        var StayConnect =false


        if(now-Number(setupTime) < hours*60*60*1000)
        {
          User.TimeToEndSession=now.toString()
          StayConnect=true
        }
        else
        {
          localStorage.removeItem('CurrentUser')
          User.TimeToEndSession=now.toString()
          localStorage.setItem('CurrentUser', JSON.stringify(User))
          StayConnect=false;
        }

        return StayConnect
    }

  SessionMangerOld()
    {
      var hours = 1; // Reset when storage is more than 1hours
        var now = new Date().getTime();
        var setupTime = localStorage.getItem('setupTime');
        var StayConnect =false
        if (setupTime == null) {
            localStorage.setItem('setupTime', now.toString())
            StayConnect=true
        } else {
            if(now-Number(setupTime) > hours*60*60*1000) {
                localStorage.clear()
                localStorage.setItem('setupTime', now.toString());
                StayConnect=false;

            }
        }
        return StayConnect
    }

  async Login(User : UserModel)
  {
    var ReturnedResponse =await this.RequesterService.AsyncPostResponse(EnumEndpoints.Authentication,User,false,true,false)
    if(ReturnedResponse[0]== 1)
    {
      this.RequesterService.Showlog('ISOK',ReturnedResponse[0])
      // User.accessToken=ReturnedResponse[0].data.accessToken
      User.TimeToEndSession=new Date().getTime().toString()

      // this.SessionManger(User)
      localStorage.removeItem('CurrentUser')
      localStorage.setItem('CurrentUser', JSON.stringify(User))

    this.Router.navigateByUrl('DashboardMedecin')
    }

    // console.log('ISOK',ReturnedResponse[0])
  }


}
