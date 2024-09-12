<?php 

namespace App\Http\Controllers;

use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        try {
            $user = $this->userService->registerUser($request->all());

            return response()->json([
                'message' => 'Utilisateur créé avec succès',
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création de l\'utilisateur',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function index()
    {
        return response()->json($this->userService->getAllUsers());
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = $this->userService->updateUser($request->all(), $id);

            return response()->json([
                'message' => 'Utilisateur mis à jour avec succès',
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la mise à jour de l\'utilisateur',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $this->userService->deleteUser($id);

            return response()->json([
                'message' => 'Utilisateur supprimé avec succès',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la suppression de l\'utilisateur',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}

?>