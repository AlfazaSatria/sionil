<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AffectiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('description_affective')->insert([
            'id' => 1,
            'deskripsi_a_sp'=> "Very Good at being able to do the assignment with truly
            demeanor and accept the suggestion fairly. Good at being grateful to Allah for what
            they have. ",
            'deskripsi_b_sp' => "Very Good at being able to do the assignment with truly
            demeanor and accept the suggestion fairly. Good at being grateful to Allah for what
            they have.",
            'deskripsi_c_sp' => "Very Good at being able to do the assignment with truly
            demeanor and accept the suggestion fairly. Good at being grateful to Allah for what
            they have.",
            'deskripsi_d_sp' => "Very Good at being able to do the assignment with truly
            demeanor and accept the suggestion fairly. Good at being grateful to Allah for what
            they have.",
            'deskripsi_a_so'=> "Good at obey the rules and be on time. Very Good at
            saying proper words, showing respect to the teacher and older people. ",
            'deskripsi_b_so' => "Good at being grateful to Allah for what
            they have.",
            'deskripsi_c_so' => "Good at obey the rules and be on time. Very Good at
            saying proper words, showing respect to the teacher and older people.",
            'deskripsi_d_so' => "Good at obey the rules and be on time. Very Good at
            saying proper words, showing respect to the teacher and older people."
        ]);
    }
}
