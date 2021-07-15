<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubChapterDefaultData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $chapter = DB::table('sub_chapters')->get();
        $question = [];
        foreach ($chapter as $key => $chap) {
            $question[] = [
                'categoryId' => $chap->categoryId,
                'chapterId' => $chap->chapterId,
                'subChapterId' => $chap->id,
                'question' => 'assets/question/Exponent&Logs/question11.png',
                'difficulty' => rand(1,3),
            ];
            $question[] = [
                'categoryId' => $chap->categoryId,
                'chapterId' => $chap->chapterId,
                'subChapterId' => $chap->id,
                'question' => 'assets/question/Exponent&Logs/question2.gif',
                'difficulty' => rand(1,3),
            ];
            $question[] = [
                'categoryId' => $chap->categoryId,
                'chapterId' => $chap->chapterId,
                'subChapterId' => $chap->id,
                'question' => 'assets/question/Sequence&Series/question1.png',
                'difficulty' => rand(1,3),
            ];
            $question[] = [
                'categoryId' => $chap->categoryId,
                'chapterId' => $chap->chapterId,
                'subChapterId' => $chap->id,
                'question' => 'assets/question/Sequence&Series/question2.png',
                'difficulty' => rand(1,3),
            ];
            $question[] = [
                'categoryId' => $chap->categoryId,
                'chapterId' => $chap->chapterId,
                'subChapterId' => $chap->id,
                'question' => 'assets/question/BinomialTheorem/question1.png',
                'difficulty' => rand(1,3),
            ];
            $question[] = [
                'categoryId' => $chap->categoryId,
                'chapterId' => $chap->chapterId,
                'subChapterId' => $chap->id,
                'question' => 'assets/question/BinomialTheorem/question3.gif',
                'difficulty' => rand(1,3),
            ];
            $question[] = [
                'categoryId' => $chap->categoryId,
                'chapterId' => $chap->chapterId,
                'subChapterId' => $chap->id,
                'question' => 'assets/question/BinomialTheorem/question5.png',
                'difficulty' => rand(1,3),
            ];
            $question[] = [
                'categoryId' => $chap->categoryId,
                'chapterId' => $chap->chapterId,
                'subChapterId' => $chap->id,
                'question' => 'assets/question/Exponent&Logs/question7.gif',
                'difficulty' => rand(1,3),
            ];
            $question[] = [
                'categoryId' => $chap->categoryId,
                'chapterId' => $chap->chapterId,
                'subChapterId' => $chap->id,
                'question' => 'assets/question/Exponent&Logs/question5.png',
                'difficulty' => rand(1,3),
            ];
            $question[] = [
                'categoryId' => $chap->categoryId,
                'chapterId' => $chap->chapterId,
                'subChapterId' => $chap->id,
                'question' => 'assets/question/Exponent&Logs/question6.png',
                'difficulty' => rand(1,3),
            ];
            $question[] = [
                'categoryId' => $chap->categoryId,
                'chapterId' => $chap->chapterId,
                'subChapterId' => $chap->id,
                'question' => 'assets/question/Sequence&Series/question6.gif',
                'difficulty' => rand(1,3),
            ];
            $question[] = [
                'categoryId' => $chap->categoryId,
                'chapterId' => $chap->chapterId,
                'subChapterId' => $chap->id,
                'question' => 'assets/question/Sequence&Series/question8.png',
                'difficulty' => rand(1,3),
            ];
            $question[] = [
                'categoryId' => $chap->categoryId,
                'chapterId' => $chap->chapterId,
                'subChapterId' => $chap->id,
                'question' => 'assets/question/Sequence&Series/question10.gif',
                'difficulty' => rand(1,3),
            ];   
        }
        DB::table('questions')->truncate();
        foreach (array_chunk($question,500) as $t) {
            DB::table('questions')->insert($t);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
