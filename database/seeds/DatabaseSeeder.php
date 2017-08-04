<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(database\seeds\RolesTableSeeder::class);
        $this->call(database\seeds\TournamentRuleMasterTableSeeder::class);
        $this->call(database\seeds\UserOrgUserMasterTableSeeder::class);
    }
}
