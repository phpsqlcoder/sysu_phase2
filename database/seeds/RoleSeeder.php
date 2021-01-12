<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Role::create([
            'name' => 'Admin',
            'description' => 'Administrator of the system',
            'created_by' => 1
        ]);

//            [
//                'name' => 'Approver',
//                'description' => 'Approver of pages',
//                'created_by'    => 1,
//                'created_at' => '2019-10-06 20:31:26',
//                'updated_at' => '2019-10-06 20:31:26'
//            ],
//            [
//                'name' => 'Contributor',
//                'description' => 'Author of the pages',
//                'created_by'    => 1,
//                'created_at' => '2019-10-06 20:31:26',
//                'updated_at' => '2019-10-06 20:31:26'
//            ],
    }
}
