<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertDataIntoChaptersTable02062021 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('sub_chapters')->truncate();
        for ($i=1; $i <= 48 ; $i++) { 
            if ($i%3 == 1) {
                $data = [
                    [
                        'chapterId' => $i,
                        'name' => 'Sequence & Series',
                        'topics' => 'Arithmetic/Geometric sequence & Series,Sigma Notation,Financial Application,Compound Interest'
                    ],
                    [
                        'chapterId' => $i,
                        'name' => 'Exponents & Logs',
                        'topics' => 'Exponents Law & Logs Lawt'
                    ],
                    [
                        'chapterId' => $i,
                        'name' => 'BioNomial Theorem',
                        'topics' => 'Bionomial Theorem & Theorem with Integer'
                    ],
                    [
                        'chapterId' => $i,
                        'name' => 'Counting Principal',
                        'topics' => 'Permutation and Combination,Factorials, Product principle'
                    ],
                ];
            }
            if ($i%3 == 2) {
                $data = [
                    [
                        'chapterId' => $i,
                        'name' => 'Properties of Functions',
                        'topics' => 'Domain & range , COmposite Functions,Inverse Functions, Min & Max/ Intersencs'
                    ],
                    [
                        'chapterId' => $i,
                        'name' => 'Quadratics',
                        'topics' => 'Quadratics Functions and Intersections , Factorisation,Vertex...'
                    ],
                    [
                        'chapterId' => $i,
                        'name' => 'Rational Functions',
                        'topics' => 'Horizontal and vertical Asymptotes,Intersect with axis'
                    ],
                    [
                        'chapterId' => $i,
                        'name' => 'Polynomials',
                        'topics' => 'Ther Factor and Remainder Theorem,...'
                    ],
                ];
            }
            if ($i%3 == 0) {
                $data = [
                    [
                        'chapterId' => $i,
                        'name' => 'Differential Calculus',
                        'topics' => 'Domain & range , COmposite Functions,Inverse Functions, Min & Max/ Intersencs'
                    ],
                    [
                        'chapterId' => $i,
                        'name' => 'Integral Calculus',
                        'topics' => 'Quadratics Functions and Intersections , Factorisation,Vertex...'
                    ],
                    [
                        'chapterId' => $i,
                        'name' => 'Kinamatics',
                        'topics' => 'Horizontal and vertical Asymptotes,Intersect with axis'
                    ],
                    [
                        'chapterId' => $i,
                        'name' => 'Diffrential Equation',
                        'topics' => 'Ther Factor and Remainder Theorem,...'
                    ],
                ];
            }
            DB::table('sub_chapters')->insert($data);
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('sub_chapters')->truncate();
    }
}
