<?php

use Illuminate\Database\Seeder;
use App\Model\BaseModel\Tournament_Rules;
class TournamentRuleMasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insert_data = array(
            array(
                'name' => 'Max Teams',
                'specification' => null,
                'value' => null,
                'range_from' => null,
                'range_to' => null,
                'deleted_by' => null,
                'updated_by' => 1,
            ),
            array(
                'name' => 'Max Ball',
                'specification' => null,
                'value' => null,
                'range_from' => null,
                'range_to' => null,
                'deleted_by' => null,
                'updated_by' => 1,
            ),
            array(
                'name' => 'Max Over',
                'specification' => null,
                'value' => null,
                'range_from' => null,
                'range_to' => null,
                'deleted_by' => null,
                'updated_by' => 1,
            ),
            array(
                'name' => 'Max Bolwer Over',
                'specification' => null,
                'value' => null,
                'range_from' => null,
                'range_to' => null,
                'deleted_by' => null,
                'updated_by' => 1,
            ),
            array(
                'name' => 'Max Innings',
                'specification' => null,
                'value' => null,
                'range_from' => null,
                'range_to' => null,
                'deleted_by' => null,
                'updated_by' => 1,
            ),
            array(
                'name' => 'Max Wicket',
                'specification' => null,
                'value' => null,
                'range_from' => null,
                'range_to' => null,
                'deleted_by' => null,
                'updated_by' => 1,
            ),
            array(
                'name' => 'Max Players',
                'specification' => null,
                'value' => null,
                'range_from' => null,
                'range_to' => null,
                'deleted_by' => null,
                'updated_by' => 1,
            ),
            array(
                'name' => 'Min Players',
                'specification' => null,
                'value' => null,
                'range_from' => null,
                'range_to' => null,
                'deleted_by' => null,
                'updated_by' => 1,
            )
        );

        foreach ($insert_data as $index) {
            Tournament_Rules::create($index);
        }
    }
}
