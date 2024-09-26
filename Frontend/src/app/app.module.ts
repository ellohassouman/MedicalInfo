import { APP_INITIALIZER, CUSTOM_ELEMENTS_SCHEMA, LOCALE_ID, NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { registerLocaleData } from '@angular/common';
import { DashboardMedecinComponent } from './dashboard-medecin/dashboard-medecin.component';

import localeFr from '@angular/common/locales/fr';
import { RouterModule, Routes } from '@angular/router';
import { ConfigurationService } from './Services/configuration.service';
import { HttpClientModule } from '@angular/common/http';
import { RequesterService } from './Services/requester.service';
import { LoginComponent } from './login/login.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { NgxSpinnerModule } from 'ngx-spinner';
import { BrowserAnimationsModule } from "@angular/platform-browser/animations";



registerLocaleData(localeFr, 'fr');

const appRoutes: Routes = [
  { path: 'DashboardMedecin', component: DashboardMedecinComponent }, //, canActivate :[SessionGuard],},//, canActivate :[SessionGuard],},
  { path: 'Login', component: LoginComponent }, //, canActivate :[SessionGuard],},//, canActivate :[SessionGuard],},
  {

    path: '', redirectTo: 'Login', pathMatch:"prefix" },

]

export function initServicesFactory(
  configurationService: ConfigurationService,requesterService : RequesterService
) {
  return async () => {
    // console.log('initServicesFactory - started');
    const config = await configurationService.loadConfiguration();
    // RequesterService.RouteBaseApi = config.RouteBaseApi
    // console.log(requesterService.RouteBaseApi)
    // console.log('initServicesFactory - completed',config.RouteBaseApi);
  };
}

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    RouterModule,
    RouterModule.forRoot(appRoutes),
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule,
    BrowserAnimationsModule,
    NgxSpinnerModule,
  ],
  providers: [
    { provide: LOCALE_ID, useValue: "fr-FR" },

    {
      provide: APP_INITIALIZER,
      useFactory: initServicesFactory,
      multi : true,
      deps: [ConfigurationService],
    },

  ],
  bootstrap: [AppComponent],
  schemas: [CUSTOM_ELEMENTS_SCHEMA],

})
export class AppModule { }
