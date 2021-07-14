<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddnewTableData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('courses')->truncate();
        DB::table('course_features')->truncate();
        DB::table('course_chapters')->truncate();
        $coursedata = [];
        $teacher = DB::table('teachers')->get();
        foreach ($teacher as $key => $teach) {
            $category = DB::table('categories')->get();
            foreach ($category as $catindex => $cat) {
                $coursedata[] = [
                    'categoryId' => $cat->id,
                    'teacherId' => $teach->id,
                    'course_name' => 'UX/UI Design',
                    'course_image' => 'assets/img/co-3.jpg',
                    'course_description' => "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>",
                    'is_verified' => 1
                ];
                $coursedata[] = [
                    'categoryId' => $cat->id,
                    'teacherId' => $teach->id,
                    'course_name' => 'UX/UI Design2',
                    'course_image' => 'assets/img/co-5.jpg',
                    'course_description' => "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>",
                    'is_verified' => 1
                ];
            }
        }
        DB::table('courses')->insert($coursedata);
        $feature = [];$chapter=[];
        $courses = DB::table('courses')->get();
        foreach ($courses as $key => $course) {
            $feature[] = [
                'course_id' => $course->id,
                'feature' => '24x7 Support',
            ];
            $feature[] = [
                'course_id' => $course->id,
                'feature' => 'Fully Programming',
            ];
            $chapter[] = [
                'courseId' => $course->id,
                'name' => 'Web Designing Beginner',
                'description' => '',
                'price' => rand(199,499).'.99',
            ];
            $chapter[] = [
                'courseId' => $course->id,
                'name' => 'Startup Designing with HTML5 & CSS3',
                'description' => '',
                'price' => rand(199,499).'.99',
            ];
            $chapter[] = [
                'courseId' => $course->id,
                'name' => 'How To Call Google Map iFrame',
                'description' => '',
                'price' => rand(199,499).'.99',
            ];
            $chapter[] = [
                'courseId' => $course->id,
                'name' => 'How to Create Sticky Navigation Using JS',
                'description' => '',
                'price' => rand(199,499).'.99',
            ];
        }
        DB::table('course_features')->insert($feature);
        DB::table('course_chapters')->insert($chapter);
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
