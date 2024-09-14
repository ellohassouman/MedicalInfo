<?php

namespace App\Http\Controllers;

use App\Http\Services\RoleService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Http\Helpers\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    // create role
    public function store(Request $request)
    {
        try {
            $role = $this->roleService->registerRole($request->all());
            $message = ApiResponse::CREATED;
            return ApiResponse::return_success_response($message, $role, 200);

        } catch (\Exception $e) {
            Log::error(message: 'An error occurred while registering the role . ' . $e->getMessage());
            return ApiResponse::return_server_error_response();
        }
    }

    // get all roles
    public function index()
    {
        $roles = $this->roleService->getAllRoles(); 
        return response()->json($roles);
    }

    // role by Id
    public function show($id)
    {
        $role = $this->roleService->getRoleById($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        return response()->json($role);
    }

    // update role
    public function update(Request $request, $id)
    {
        try {
            $role = $this->roleService->updateRole($request->all(), $id);

            $message = ApiResponse::ACCEPTED;
            return ApiResponse::return_success_response($message, $role, 200);
            
        } catch (\Exception $e) {
            Log::error(message: 'An error occurred while modifying the role . ' . $e->getMessage());
            return ApiResponse::return_server_error_response();
        }
    }

    // delete role (coming soon)
    public function destroy($id)
    {
        try {
            $this->roleService->deleteRole($id);

            $message = ApiResponse::ACCEPTED;
            return ApiResponse::return_success_response($message, $id, 200);
            
        } catch (\Exception $e) {
            Log::error(message: 'An error occurred while deleting the user . ' . $e->getMessage());
            return ApiResponse::return_server_error_response();
        }
    }
}


?>