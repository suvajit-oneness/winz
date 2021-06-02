<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertDataIntoQuestionsTable02062021 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('questions')->truncate();
        $id1 = 0;
        $id2 = 0;
        $id3 = 0;
        for ($i=1; $i <= 48 ; $i++) {
 
            if ($i%3 == 1) {
                $id1 = $id1+1;
                $data = [
                    [
                        'subjectCategoryId' => $id1,
                        'chapterId' => $i,
                        'question' => 'assets/question/Exponent&Logs/question11.png',
                        'difficulty' => 1,
                        // 'mark_scheme' => 'http://localhost/winz/public/upload/questions/markScheme/20210601013508427.png',
                        // 'answer1' => 'https://www.revisionvillage.com/ib-math-analysis-and-approaches-hl/questionbank/number-and-algebra/sequences-and-series/',
                        // 'answer2' => 'https://www.revisionvillage.com/ib-math-analysis-and-approaches-hl/questionbank/number-and-algebra/sequences-and-series/',
                        // 'answer3' => 'https://www.revisionvillage.com/ib-math-analysis-and-approaches-hl/questionbank/number-and-algebra/sequences-and-series/',
                        // 'answer4' => 'https://www.revisionvillage.com/ib-math-analysis-and-approaches-hl/questionbank/number-and-algebra/sequences-and-series/'
                    ],
                    [
                        'subjectCategoryId' => $id1,
                        'chapterId' => $i,
                        'question' => 'assets/question/Exponent&Logs/question2.gif',
                        'difficulty' => 2,
                    ],
                    [
                        'subjectCategoryId' => $id1,
                        'chapterId' => $i,
                        'question' => 'assets/question/Exponent&Logs/question3.gif',
                        'difficulty' => 3,
                    ],
                    [
                        'subjectCategoryId' => $id1,
                        'chapterId' => $i,
                        'question' => 'assets/question/Exponent&Logs/question4.gif',
                        'difficulty' => 3,
                    ],
                    [
                        'subjectCategoryId' => $id1,
                        'chapterId' => $i,
                        'question' => 'assets/question/Exponent&Logs/question5.png',
                        'difficulty' => 1,
                    ],
                    [
                        'subjectCategoryId' => $id1,
                        'chapterId' => $i,
                        'question' => 'assets/question/Exponent&Logs/question6.png',
                        'difficulty' => 1,
                    ],
                    [
                        'subjectCategoryId' => $id1,
                        'chapterId' => $i,
                        'question' => 'assets/question/Exponent&Logs/question7.gif',
                        'difficulty' => 3,
                    ],
                    [
                        'subjectCategoryId' => $id1,
                        'chapterId' => $i,
                        'question' => 'assets/question/Exponent&Logs/question8.gif',
                        'difficulty' => 2,
                    ],
                    [
                        'subjectCategoryId' => $id1,
                        'chapterId' => $i,
                        'question' => 'assets/question/Exponent&Logs/question9.gif',
                        'difficulty' => 1,
                    ],
                    [
                        'subjectCategoryId' => $id1,
                        'chapterId' => $i,
                        'question' => 'assets/question/Exponent&Logs/question10.png',
                        'difficulty' => 2,
                    ]
                ];
            }
            if ($i%3 == 2) {
                $id2 = $id2+1;
                $data = [
                    [
                        'subjectCategoryId' => $id2,
                        'chapterId' => $i,
                        'question' => 'assets/question/Sequence&Series/question1.png',
                        'difficulty' => 1,
                    ],
                    [
                        'subjectCategoryId' => $id2,
                        'chapterId' => $i,
                        'question' => 'assets/question/Sequence&Series/question2.png',
                        'difficulty' => 2,
                    ],
                    [
                        'subjectCategoryId' => $id2,
                        'chapterId' => $i,
                        'question' => 'assets/question/Sequence&Series/question3.png',
                        'difficulty' => 3,
                    ],
                    [
                        'subjectCategoryId' => $id2,
                        'chapterId' => $i,
                        'question' => 'assets/question/Sequence&Series/question4.gif',
                        'difficulty' => 1,
                    ],
                    [
                        'subjectCategoryId' => $id2,
                        'chapterId' => $i,
                        'question' => 'assets/question/Sequence&Series/question5.gif',
                        'difficulty' => 1,
                    ],
                    [
                        'subjectCategoryId' => $id2,
                        'chapterId' => $i,
                        'question' => 'assets/question/Sequence&Series/question6.gif',
                        'difficulty' => 2,
                    ],
                    [
                        'subjectCategoryId' => $id2,
                        'chapterId' => $i,
                        'question' => 'assets/question/Sequence&Series/question7.gif',
                        'difficulty' => 3,
                    ],
                    [
                        'subjectCategoryId' => $id2,
                        'chapterId' => $i,
                        'question' => 'assets/question/Sequence&Series/question8.png',
                        'difficulty' => 1,
                    ],
                    [
                        'subjectCategoryId' => $id2,
                        'chapterId' => $i,
                        'question' => 'assets/question/Sequence&Series/question9.png',
                        'difficulty' => 2,
                    ],
                    [
                        'subjectCategoryId' => $id2,
                        'chapterId' => $i,
                        'question' => 'assets/question/Sequence&Series/question10.gif',
                        'difficulty' => 1,
                    ]
                ];
            }
            if ($i%3 == 0) {
                $id3 = $id3+1;
                $data = [
                    [
                        'subjectCategoryId' => $id3,
                        'chapterId' => $i,
                        'question' => 'assets/question/BinomialTheorem/question1.png',
                        'difficulty' => 1,
                    ],
                    [
                        'subjectCategoryId' => $id3,
                        'chapterId' => $i,
                        'question' => 'assets/question/BinomialTheorem/question2.png',
                        'difficulty' => 2,
                    ],
                    [
                        'subjectCategoryId' => $id3,
                        'chapterId' => $i,
                        'question' => 'assets/question/BinomialTheorem/question3.gif',
                        'difficulty' => 3,
                    ],
                    [
                        'subjectCategoryId' => $id3,
                        'chapterId' => $i,
                        'question' => 'assets/question/BinomialTheorem/question4.gif',
                        'difficulty' => 1,
                    ],
                    [
                        'subjectCategoryId' => $id3,
                        'chapterId' => $i,
                        'question' => 'assets/question/BinomialTheorem/question5.png',
                        'difficulty' => 2,
                    ],
                    [
                        'subjectCategoryId' => $id3,
                        'chapterId' => $i,
                        'question' => 'assets/question/BinomialTheorem/question6.gif',
                        'difficulty' => 1,
                    ],
                    [
                        'subjectCategoryId' => $id3,
                        'chapterId' => $i,
                        'question' => 'assets/question/BinomialTheorem/question7.gif',
                        'difficulty' => 3,
                    ],
                    [
                        'subjectCategoryId' => $id3,
                        'chapterId' => $i,
                        'question' => 'assets/question/BinomialTheorem/question8.gif',
                        'difficulty' => 2,
                    ],
                    [
                        'subjectCategoryId' => $id3,
                        'chapterId' => $i,
                        'question' => 'assets/question/BinomialTheorem/question9.png',
                        'difficulty' => 2,
                    ],
                    [
                        'subjectCategoryId' => $id3,
                        'chapterId' => $i,
                        'question' => 'assets/question/BinomialTheorem/question10.gif',
                        'difficulty' => 1,
                    ],
                ];
            }
            DB::table('questions')->insert($data);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('questions')->truncate();
    }
}
