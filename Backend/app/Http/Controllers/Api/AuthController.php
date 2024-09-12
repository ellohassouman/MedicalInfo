<?php

namespace App\Http\Controllers\Api;

use App\Http\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //


    public $successResponse;
    public $errorResponse;


    public function __construct()
    {
        $this->successResponse = null;
        $this->errorResponse = null;
    }


    public function login(Request $request)
    {
        //


        $errorDetail = '';

        // Valider les données de la requête
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [

            'email.required' => 'L\'email est requis.',
            'email.email' => 'L\'email n\'est pas valide.',
            'password.required' => 'Le mot de passe est requis.',
        ]);

        try {

            // erreur de validation
            if ($validator->fails()) {

                $errorDetail = 'Bad provided data.';

                return ApiResponse::return_error_response(ApiResponse::INVALID_CREDENTIALS, $errorDetail, 422);

            }

            // mettre l'email en minuscule
            $email = strtolower($request->email);

            // Récupérer l'utilisateur par email
            $user = User::where('email', $email)->first();

            // Vérifier si l'utilisateur existe
            if (!$user) {

                $errorDetail = 'User don\'t exist.';

                return ApiResponse::return_error_response(ApiResponse::INVALID_CREDENTIALS, $errorDetail, 404);


            }

            // Vérifier si le mot de passe correspond
            if (!Hash::check($request->password, $user->password)) {

                $message = ApiResponse::INVALID_CREDENTIALS;
                $errorDetail = 'Invalide credentials.';

                return ApiResponse::return_error_response(ApiResponse::INVALID_CREDENTIALS, $errorDetail, 401);

            }

            // Authentification réussie, générer le token JWT
            $token = $user->createToken('accessToken')->plainTextToken;

            // set last_login avec la date et l'heure actuelles
            $user->update(['last_login' => now()]);

            $data = [
                'accessToken' => $token
            ];
            $message = ApiResponse::ACCEPTED;

            return ApiResponse::return_success_response($message, $data, 200);



        } catch (\Throwable $th) {

            // Gérer les éventuelles erreurs
            Log::error('Error occured when user tried to login. ' . $th->getMessage());

            return ApiResponse::return_server_error_response();

        }


    }


    public function register(Request $request)
    {
        //
    }
}
