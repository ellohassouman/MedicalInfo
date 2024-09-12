<?php

namespace App\Http\Controllers;

use App\Http\Services\RoleService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    // Créer un rôle (déjà existante)
    public function store(Request $request)
    {
        try {
            $role = $this->roleService->registerRole($request->all());

            return response()->json([
                'message' => 'Rôle créé avec succès',
                'role' => $role,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création du rôle',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    // Lire tous les rôles (déjà existante)
    public function index()
    {
        $roles = $this->roleService->getAllRoles(); // Correction pour utiliser le service
        return response()->json($roles);
    }

    // Lire un rôle par ID
    public function show($id)
    {
        $role = $this->roleService->getRoleById($id);

        if (!$role) {
            return response()->json(['message' => 'Rôle non trouvé'], 404);
        }

        return response()->json($role);
    }

    // Mettre à jour un rôle
    public function update(Request $request, $id)
    {
        try {
            $role = $this->roleService->updateRole($request->all(), $id);

            return response()->json([
                'message' => 'Rôle mis à jour avec succès',
                'role' => $role,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la mise à jour du rôle',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    // Supprimer un rôle
    public function destroy($id)
    {
        try {
            $this->roleService->deleteRole($id);

            return response()->json([
                'message' => 'Rôle supprimé avec succès',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la suppression du rôle',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}


?>