<?php

use Migrations\AbstractSeed;

class AllSeed extends AbstractSeed
{
    public function run(): void
    {
        $this->call('RolesSeed');
        $this->call('PermissionsSeed');
        $this->call('RolesPermissionsSeed');
        $this->call('UsersSeed');
    }
}
