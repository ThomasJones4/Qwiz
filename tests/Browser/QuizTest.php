<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;
use App\Quiz;
use Illuminate\Support\Facades\DB;

class QuizTest extends DuskTestCase
{
    /**
     * Test the user can login
     *
     * @return void
     */
    public function testSocialMediaImageLoads()
    {
        $user = factory(User::class)->create();
        $quiz = $user->my_quizzes()->save(factory(Quiz::class)->make());

        $this->browse(function (Browser $browser) use ($quiz) {
            $browser->visit(route('social.quiz.header', $quiz, false))
                  ;
        });
    }


}
