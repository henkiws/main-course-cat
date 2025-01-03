<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\UserGroup;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::create([
            'name' => 'Group 1',
            'description' => 'Description Group 1',
            'created_by' => 1
        ]);

        Group::create([
            'name' => 'Group 2',
            'description' => 'Description Group 2',
            'created_by' => 1
        ]);

        UserGroup::create([
            'fk_user' => 2,
            'fk_group' => 1
        ]);

        UserGroup::create([
            'fk_user' => 2,
            'fk_group' => 2
        ]);
    }
}