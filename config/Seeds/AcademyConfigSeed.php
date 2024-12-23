<?php
use Migrations\AbstractSeed;

class AcademyConfigSeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Aslafit',
                'logo' => 'logo.png',
                'motto' => 'Academy Motto',
                'primary_color' => '#000000',
                'secondary_color' => '#FFFFFF',
                'user_id' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('academy_config');
        $table->insert($data)->save();
    }
}
