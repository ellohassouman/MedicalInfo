<?php

namespace App\Http\Controllers\Api;

use App\Http\Constants\GlobalConst;
use App\Http\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AuthController extends Controller
{


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

                $errorDetail = 'Veuillez remplir tous les champs.';

                return ApiResponse::return_error_response(ApiResponse::INVALID_CREDENTIALS, $errorDetail, 422);

            }

            // mettre l'email en minuscule
            $email = strtolower($request->email);

            // Récupérer l'utilisateur par email
            $user = User::where('email', $email)->first();

            // Vérifier si l'utilisateur existe
            if (!$user) {

                $errorDetail = 'Aucun utilisateur trouvé';

                return ApiResponse::return_error_response(ApiResponse::INVALID_CREDENTIALS, $errorDetail, 404);

            }

            // Vérifier si le mot de passe correspond
            if (!Hash::check($request->password, $user->password)) {

                $message = ApiResponse::INVALID_CREDENTIALS;
                $errorDetail = 'Aucun utilisateur trouvé';

                return ApiResponse::return_error_response(ApiResponse::INVALID_CREDENTIALS, $errorDetail, 401);

            }

            // Authentification réussie, générer le token JWT
            $token = $user->createToken('accessToken')->plainTextToken;

            // set last_login avec la date et l'heure actuelles
            $user->userLogs()->create([
                'ip' => $request->ip(),
                'action' => GlobalConst::ACTION_LOGIN,
            ]);

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


    public function logout(Request $request){
        try {
            // Récupérer l'utilisateur actuellement authentifié
            $user = auth()->user();

            // Mettre à jour le champ last_logout avec la date et l'heure actuelles
            $user->userLogs()->create([
                'action' => GlobalConst::ACTION_LOGOUT,
                'ip' => $request->ip(),
            ]);

            // Révoquer tous les jetons d'authentification associés à l'utilisateur
            $user->tokens()->delete();

            $message = ApiResponse::OK;
            return ApiResponse::return_success_response($message, null, 202);

        } catch (Throwable $th) {

            // Gérer les éventuelles erreurs
            Log::error("Error while logout : ".$th->getMessage());

            return ApiResponse::return_server_error_response();

        }
    }
}
