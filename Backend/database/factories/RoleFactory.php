<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{

    // Collection statique pour garder trace des labels disponibles
    protected static $availableLabels = ['super_admin', 'admin', 'user', 'doctor', 'patient', 'receptionist'];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        // Rafraîchir la collection si tous les labels sont utilisés
        if (empty(self::$availableLabels)) {
            self::$availableLabels = ['super_admin', 'admin', 'user', 'doctor', 'patient', 'receptionist'];
        }

        // Mélanger la collection et prendre un label unique
        shuffle(self::$availableLabels);
        $label = array_pop(self::$availableLabels);

        return [
            //
            'label' => $label,
        ];
    }
}
