<?php
use Migrations\AbstractSeed;

class AllSeed extends AbstractSeed
{
    public function run(): void
    {
        $this->call('UsersSeed');
        $this->call('AcademyConfigSeed');
    }
}
