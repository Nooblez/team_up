<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class LabelUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('label_user')->insert([
            [1, 1],
        ]);

    }
}
