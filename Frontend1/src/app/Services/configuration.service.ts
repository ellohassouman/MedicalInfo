import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { ConfigurationModel } from '../Models/configuration-model.model';

@Injectable({
  providedIn: 'root'
})
export class ConfigurationService {


  constructor(private httpClient: HttpClient) {}


  config : any;
  async loadConfiguration(): Promise<ConfigurationModel> {

    let url="./assets/config/configuration.json"

     await this.httpClient.get<ConfigurationModel>(url).toPromise().then(
      data => {
        this.config=data
      }
    );
    // Object.assign(this, this.config);
    return this.config.RouteBaseApi;


    // RouteApiToDeploy
  }
}
