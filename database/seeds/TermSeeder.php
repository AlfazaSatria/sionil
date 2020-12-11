<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('term')->insert([
            'id' => 1,
            'term'=> 1,
            'semester' => 1,
            'kepsek' => "Ibnu Mulyana, M.Pd",
            'delivered_on' => "2020-12-23"
        ]);
    }
}
