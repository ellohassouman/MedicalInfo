import { Injectable } from '@angular/core';
import Swal from 'sweetalert2';

@Injectable({
  providedIn: 'root'
})
export class SweetAlertService {

  constructor() { }

  async ShowSweetAlertInfo(titles='',message='')
    {
      var Confirmation=0
      await Swal.fire(
        {
          title : titles,
          html : message,
          icon : 'info',
        }

      ).then(async (result) => {
        if (result.isConfirmed) {
          Confirmation=1
          console.log('heree')
        }
      })
      return Confirmation;
    }

    async ShowSucessMessage(titles='',message='')
    {
      var Confirmation=0
      await Swal.fire(
        {
          title : titles,
          html : message,
          icon : 'success',
        }

      ).then(async (result) => {
        if (result.isConfirmed) {
          Confirmation=1
          console.log('heree')
        }
      })
      return Confirmation;
    }

    async GetConfirmation(titles='',message='')
    {
      var Confirmation=0
      await Swal.fire(
        {
          title : titles,
          text : message,
          icon : 'question',
          showDenyButton: true,
          confirmButtonText: 'Oui',
          denyButtonText: 'No',
        }

      ).then(async (result) => {
        if (result.isConfirmed) {
          Confirmation=1
        }
      })
      return Confirmation;
    }

    async ShowErrorMessage(titles='',message='')
    {
      var Confirmation=0
      await Swal.fire(
        {
          title : titles,
          html : message,
          icon : 'error',
        }

      ).then(async (result) => {
        if (result.isConfirmed) {
          Confirmation=1
          console.log('heree')
        }
      })
      return Confirmation;
    }

    async ShowQuestionMessage(titles='',message='',colorConfirmButton='')
    {
      var Confirmation=0
      await Swal.fire(
        {
          title : titles,
          html : message,
          icon : 'question',
          showCancelButton: true,
          confirmButtonText : 'Oui',
          cancelButtonText : 'Non',
          confirmButtonColor:colorConfirmButton,

        }

      ).then(async (result) => {
        if (result.isConfirmed) {
          Confirmation=1
          console.log('heree')
        }
      })
      return Confirmation;
    }

    CloseLoader()
    {
      Swal.close()
    }



    ShowLoader()
    {

      Swal.fire({
        icon : 'info',
        // title: 'Succès',
        html: 'Opération en cours veuillez patienter ...',
        // timer: 2000,
        allowOutsideClick: false,
        timerProgressBar: true,
        didOpen: () => {
          Swal.showLoading()
        },
      }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
          console.log('I was closed by the timer')
        }
      })
    }


}
