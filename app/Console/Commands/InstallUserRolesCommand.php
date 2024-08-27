<?php

namespace App\Console\Commands;

use App\Enums\Role as RoleEnum;
use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class InstallUserRolesCommand extends Command
{
    protected $signature = 'install:user-roles';

    protected $description = 'Install Roles and set the admin role to the first user';

    public function handle(): void
    {
        RoleEnum::collect()
            ->each(fn (RoleEnum $role) => Role::createOrFirst(['name' => $role->value]));

        $user = User::first();
        $user->assignRole(RoleEnum::DEV);
        $user->assignRole(RoleEnum::ADMIN);
    }
}
