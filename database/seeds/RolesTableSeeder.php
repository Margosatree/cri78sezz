<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Model\BaseModel\Role;

namespace database\seeds;
class RolesTableSeeder extends Seeder {

    public function run() {
        // $faker = Faker::create();

        $insert_data = array(
            array(
                'name' => 'Super_Admin'
                , 'slug' => 'super_admin'
                , 'is_admin' => 1
            ),
            array(
                'name' => 'Admin'
                , 'slug' => 'admin'
                , 'is_admin' => 1
            ),
            array(
                'name' => 'Organization'
                , 'slug' => 'organization'
            ),
            array(
                'name' => 'Tour_Admin'
                , 'slug' => 'tour_admin'
            ),
            array(
                'name' => 'Player'
                , 'slug' => 'player'
            )
        );
        foreach ($insert_data as $index) {
            Role::create($index);
        }
    }
}
