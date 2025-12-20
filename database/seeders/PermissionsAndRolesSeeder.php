<?php

namespace Database\Seeders;

use App\Enums\Permissions\User;
use App\Enums\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsAndRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            ...User::cases(),
        ];

        foreach($permissions as $permission) {
            Permission::findOrCreate($permission->value);
        }

        if (! Role::where('name', Roles::USER->value)->exists()) {
            (Role::create(['name' => Roles::USER->value]));
        }

        if (! Role::where('name', Roles::ADMIN->value)->exists()) {
            (Role::create(['name' => Roles::ADMIN->value]))
                ->givePermissionTo(Permission::all());
        }
    }
}
