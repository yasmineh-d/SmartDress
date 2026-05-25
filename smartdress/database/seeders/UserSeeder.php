<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class UserSeeder extends Seeder
{
    /**
     * Crée les utilisateurs et leur attribue des rôles
     */
    public function run(): void
    {
        $csvPath = database_path('data/users.csv');

        if (!File::exists($csvPath)) {
            return;
        }

        $lines = explode("\n", File::get($csvPath));
        $header = str_getcsv(array_shift($lines));

        foreach ($lines as $line) {
            if (empty(trim($line))) {
                continue;
            }

            $row = str_getcsv($line);
            $data = array_combine($header, $row);

            if (!$data || empty($data['email']) || empty($data['role'])) {
                continue;
            }

            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'] ?? 'Utilisateur SmartDress',
                    'password' => $data['password'] ?? 'password',
                ]
            );

            $emailVerifiedAt = !empty($data['email_verified_at']) ? $data['email_verified_at'] : null;
            if ($user->email_verified_at != $emailVerifiedAt) {
                $user->email_verified_at = $emailVerifiedAt;
                $user->save();
            }

            $role = Role::where('nom', $data['role'])->first();

            if ($role) {
                $user->roles()->syncWithoutDetaching([$role->id]);
            }
        }
    }
}
