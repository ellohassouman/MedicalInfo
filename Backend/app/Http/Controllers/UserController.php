<?php 

namespace App\Http\Controllers;

use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Helpers\ApiResponse;


class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(Request $request)
    {
        try {
            $user = $this->userService->registerUser($request->all());
            $message = ApiResponse::CREATED;
            return ApiResponse::return_success_response($message, $user, 200);
        } catch (\Throwable $e) {
            Log::error('Error occured when user tried to login. ' . $e->getMessage());
            return ApiResponse::return_server_error_response();
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
            return response()->json(['message' => 'User not found'], 404);
            
        }

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = $this->userService->updateUser($request->all(), $id);

            $message = ApiResponse::ACCEPTED;
            return ApiResponse::return_success_response($message, $user, 200);
        } 
        catch (\Throwable $e) {
            Log::error('Error occured when update of user.' . $e->getMessage());
            return ApiResponse::return_server_error_response();
        }
    }

    public function destroy($id)
    {
        try {
            $this->userService->deleteUser($id);

            $message = ApiResponse::ACCEPTED;
            return ApiResponse::return_success_response($message, $id, 200);
        } catch (\Throwable $e) {
            Log::error('Error occured when update of user.' . $e->getMessage());
            return ApiResponse::return_server_error_response();
        }
    }
}

?>