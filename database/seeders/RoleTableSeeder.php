<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('roles')->insert([
            ['name' => 'Leader',
            'description' => 'Leader - Ha accesso a tutto'],
            ['name' => 'Member',
            'description' => 'Member - Ha accesso ad alcune cose']
        ]);

    }
}
