<?php

namespace App\Http\Services;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class UserService
{
    public function registerUser(array $data): User
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'date_of_birth' => 'required|string|max:255',
            'gender' => 'required|in:M,W',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);

      
        return User::create([
            'name' => $data['name'],
            'email' => strtolower($data['email']),
            'password' => Hash::make(value: $data['password']),
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'],
            'phone_number' => $data['phone_number'],
            'address' => $data['address'],
            'role_id' => $data['role_id'],
        ]);
    }

    public function updateUser(array $data, $id): User
    {
        $user = User::find($id);

        if (!$user) {
            throw new \Exception('Utilisateur non trouvé');
        }

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'date_of_birth' => 'required|string|max:255',
            'gender' => 'required|in:M,W',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
           return 'Utilisateur non sélectionné';
        }

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'] ? Hash::make($data['password']) : $user->password,
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'],
            'phone_number' => $data['phone_number'],
            'address' => $data['address'],
            'role_id' => $data['role_id'],
        ]);

        return $user;
    }

    // a ne pas considérer
    public function deleteUser($id)
    {
        
            $users = User::withTrashed()->find($id);
            if(!$users) {
                return 'Utilisateur non trouvé';
            }

            if($users->trashed()) {
                //return response()->json[('message' => 'ee')];
                return response()->json(['message' => 'User is already soft deleted'], 200);
            }

            $users->delete();

          
        
    }


    public function restoreUser($id)
    {
        // Récupérer l'utilisateur supprimé
        $user = User::withTrashed()->find($id);

        if (!$user) {
            return 'Utilisateur non trouvé';
        }

        // Vérifier si l'utilisateur est soft deleted avant de restaurer
        if ($user->trashed()) {
            $user->restore();
            return response()->json(['message' => 'User has been restored'], 200);
        }

        return response()->json(['message' => 'User is not deleted'], 200);
    }


    public function getAllUsersWithTrashed()
    {
        return User::withTrashed()->get();
    }




    public function getUserById($id): ?User
    {
        return User::find($id);
    }

    public function getAllUsers()
    {
        return User::all();
    }
}