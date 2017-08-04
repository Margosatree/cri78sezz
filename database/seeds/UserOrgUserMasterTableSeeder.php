<?php

use Illuminate\Database\Seeder;
use App\Model\BaseModel\User_Master;
use App\Model\BaseModel\User_Organisation;
class UserOrgUserMasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_master = array(
            'first_name' => 'Bhavik',
            'middle_name' => 'Shashikant',
            'last_name' => 'Govindia',
            'date_of_birth' => '1993-08-01',
            'gender' => 'male',
            'physically_challenged' => 'no',
            'phone' => '9769893965',
            'email' => 'bhavikgovindia@gmail.com',
            'is_verify_phone' => 1,
            'is_verify_email' => 1,
            'username' => 'Bhavik',
            'address' => '103 Aishwariya Apt Veersavarkar Nagar Navaghar',
            'suburb' => 'Vasai-Road (W)',
            'city' => 'Thane',
            'state' => 'Maharashtra',
            'country' => 'India',
            'pin' => 401202,
            'deleted_by' => null,
            'updated_by' => 1,
        );
        User_Master::create($user_master);
        $user_org = array(
            'id' => 1,
            'user_master_id' => 1,
            'organization_master_id' => 0,
            'registration_type' => null,
            'registration_date' => null,
            'email' => 'bhavikgovindia@gmail.com',
            'password' => '$2y$10$tQse19uIs4wpAJSGefDWjeUv9MNAP6b7fV6m..ln3gkI9zJwkyHPm',
            'status' => 1,
            'role' => 'admin',
            'remember_token' => 1,
            'deleted_by' => 1,
            'updated_by' => 1,
        );
        User_Organisation::create($user_org);
    }
}
