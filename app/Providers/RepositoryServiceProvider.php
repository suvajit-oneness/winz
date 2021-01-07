<?php

namespace App\Providers;

use App\Contracts\AdminContract;
use App\Contracts\BlogContract;
use App\Contracts\BoardContract;
use App\Contracts\ClassContract;
use App\Contracts\KeyConceptContract;
use App\Contracts\MembershipContract;
use App\Contracts\PackageContract;
use App\Contracts\QuestionpaperContract;
use App\Contracts\QuizContract;
use App\Contracts\ShowContract;
use App\Contracts\SubjectContract;
use App\Contracts\SubtopicContract;
use App\Contracts\TopicContract;
use App\Contracts\TutorContract;
use App\Contracts\UserContract;
use App\Repositories\AdminRepository;
use App\Repositories\BlogRepository;
use App\Repositories\BoardRepository;
use App\Repositories\ClassRepository;
use App\Repositories\KeyConceptRepository;
use App\Repositories\MembershipRepository;
use App\Repositories\PackageRepository;
use App\Repositories\QuestionpaperRepository;
use App\Repositories\QuizRepository;
use App\Repositories\ShowRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\SubtopicRepository;
use App\Repositories\TopicRepository;
use App\Repositories\TutorRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        AdminContract::class        =>  AdminRepository::class,
        BoardContract::class     =>  BoardRepository::class,
        ClassContract::class       =>  ClassRepository::class,
        SubjectContract::class     =>  SubjectRepository::class,
        ShowContract::class         =>  ShowRepository::class,
        PackageContract::class      =>  PackageRepository::class,
        UserContract::class         =>  UserRepository::class,
        BlogContract::class         =>  BlogRepository::class,
        TopicContract::class         =>  TopicRepository::class,
        SubtopicContract::class         =>  SubtopicRepository::class,
        TutorContract::class         =>  TutorRepository::class,
        MembershipContract::class         =>  MembershipRepository::class,
        KeyConceptContract::class   =>  KeyConceptRepository::class,
        QuestionpaperContract::class   =>  QuestionpaperRepository::class,
        QuizContract::class         =>  QuizRepository::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implementation)
        {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
