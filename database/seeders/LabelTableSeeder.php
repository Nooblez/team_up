<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class LabelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('labels')->insert([
            ['label_name' => 'web developer',
            'label_description' => 'sviluppatore web'],
            ['label_name' => 'java developer',
            'label_description' => 'sviluppatore java']
        ]);

    }
}
