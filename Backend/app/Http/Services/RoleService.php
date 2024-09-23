<?php

namespace App\Http\Services;

use App\Models\Role;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator; 



class RoleService
{
     /**
     * Enregistrer un nouveau rôle
     *
     * @param array $data
     * @return Role
     * @throws ValidationException
     */
    public function registerRole(array $data): Role
    {
        $validator = Validator::make($data, [
            'label' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return 'Role non créé';
        }

        if (Role::where('label', $data['label'])->exists()) {
            throw new \Exception('Un rôle avec ce label existe déjà');
        }

        return Role::create([
            'label' => $data['label'],
        ]);
    }

    public function getAllRoles()
    {
        return Role::all();
    }

    public function getRoleById($id): ?Role
    {
        return Role::find($id);
    }

    public function updateRole(array $data, $id): Role
    {
        $role = Role::find($id);
        if (!$role) {
            throw new \Exception('Role non trouvé');
        }

        $validator = Validator::make($data, [
            'label' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return 'Role non sélectionné';
        }

        $role->label = $data['label'];
        $role->save();

        return $role;
    }


    // a revoir
    public function deleteRole(int $id): bool
    {
        $role = Role::find($id);
        if (!$role) {
            return false;
        }
        return $role->delete();
    }

    // public function restoreRole(int $id): bool
    // {
    //     $role = Role::withTrashed()->find($id);
    //     if (!$role) {
    //         return false;
    //     }
    //     return $role->restore();
    // }

    // public function forceDeleteRole(int $id): bool
    // {
    //     $role = Role::withTrashed()->find($id);
    //     if (!$role) {
    //         return false;
    //     }
    //     return $role->forceDelete();
    // }
}
