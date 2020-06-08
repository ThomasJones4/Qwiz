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
   * Test a simulated quiz
   * cmd: php artisan dusk --filter testSimulatedQuiz D:\Users\Thomas\Documents\Quiz\bigheffalockdownquiz\tests\Browser\QuizTest.php
   *
   * @return void
   */
  public function testSimulatedQuiz()
  {
      $quiz_master = factory(User::class)->create();
      $number_of_users = 1;
      $participant_browsers = [];

      $participants = factory(User::class, $number_of_users)->create();


      $this->browse(function (
        Browser $qm_browser,
        Browser $participant_browser_1//,
        // Browser $participant_browser_2,
        // Browser $participant_browser_3,
        // Browser $participant_browser_4,
        // Browser $participant_browser_5
          ) use (&$quiz_master, &$participants){

          $qm_browser->visit('/login')
                ->type('email', $quiz_master->email)
                ->type('password', 'password')
                ->press('Sign in')
                ->assertPathIs('/quizzes/mine')
                ->assertSee('Create New Quiz')
                ->clickLink('Create New Quiz')
                ->assertPathIs('/quizzes/create')
                ->assertSee('Create a new quiz')
                ->type('name', 'Simulation 1')
                ->type('scheduled_start', '2019-04-30')
                ->press('Create Quiz')
                ->assertSee('Simulation 1')
                ->assertSee('Add new Random Question')
                ->clickLink('Add new Random Question')
                ->type('amount', '10')
                ->press('Add to Quiz')
                ->assertSee('10')
                ->assertPresent('@question-edit')
                ->assertSee('Add result screen')
                ->clickLink('Add result screen')
                ->assertSee('Scores')
                ;

          $invite_code = $qm_browser->value('@invite_code');
          $quiz_id = $qm_browser->value('@quiz_id');
          $quiz = Quiz::find($quiz_id);

          $participant_browser_1->visit('/login')
                ->type('email', $participants[0]->email)
                ->type('password', 'password')
                ->press('Sign in')
                ->assertPathIs('/quizzes/mine')
                ->visit(route('show.join.quiz', $quiz->id, false))
                ->type('invite_code', $invite_code)
                ->press('Join')
                ->assertPathIs(route('quiz.show', $quiz->id, false))
                ->assertSee('Waiting for quiz master')
                ;

          $qm_browser->visit(route('quiz.start', $quiz))
                ->assertSee('responded')
                     ;

          // users join quiz
          $participant_browser_1->visit(route('quiz.show', $quiz->id, false))
                ->waitFor('@start_quiz')
                ->press('@start_quiz')
                ->type('answer', 'MYANSWER')
                ->assertSee('Submit')
                ->press('Submit')
                ->waitFor('@your-answer')
                ;

          $qm_browser->waitFor('@next_question')
                ->press('@next_question')
                ->waitFor('@release')
                ->press('@release')
                     ;

           $participant_browser_1->assertSee('Your Answer')
                 ->waitFor('@next_question')
                 ->assertSee('Next Question')
                 ->press('@next_question')
                 ->type('answer', 'MYANSWER')
                 ->assertSee('Submit')
                 ->press('Submit')
                 ->waitFor('@your-answer')
                 ;

           $qm_browser->waitFor('@next_question')
                 ->press('@next_question')
                 ->waitFor('@release')
                 ->press('@release')
                      ;

            $participant_browser_1->assertSee('Your Answer')
                  ->waitFor('@next_question')
                  ->assertSee('Next Question')
                  ->press('@next_question')
                  ->type('answer', 'MYANSWER')
                  ->assertSee('Submit')
                  ->press('Submit')
                  ->waitFor('@your-answer')
                  ;


           $qm_browser->waitFor('@next_question')
                 ->press('@next_question')
                 ->waitFor('@release')
                 ->press('@release')
                      ;

            $participant_browser_1->assertSee('Your Answer')
                  ->waitFor('@next_question')
                  ->assertSee('Next Question')
                  ->press('@next_question')
                  ->type('answer', 'MYANSWER')
                  ->assertSee('Submit')
                  ->press('Submit')
                  ->waitFor('@your-answer')
                  ;


           $qm_browser->waitFor('@next_question')
                 ->press('@next_question')
                 ->waitFor('@release')
                 ->press('@release')
                      ;

            $participant_browser_1->assertSee('Your Answer')
                  ->waitFor('@next_question')
                  ->assertSee('Next Question')
                  ->press('@next_question')
                  ->type('answer', 'MYANSWER')
                  ->assertSee('Submit')
                  ->press('Submit')
                  ->waitFor('@your-answer')
                  ;


           $qm_browser->waitFor('@next_question')
                 ->press('@next_question')
                 ->waitFor('@release')
                 ->press('@release')
                      ;

            $participant_browser_1->assertSee('Your Answer')
                  ->waitFor('@next_question')
                  ->assertSee('Next Question')
                  ->press('@next_question')
                  ->type('answer', 'MYANSWER')
                  ->assertSee('Submit')
                  ->press('Submit')
                  ->waitFor('@your-answer')
                  ;


           $qm_browser->waitFor('@next_question')
                 ->press('@next_question')
                 ->waitFor('@release')
                 ->press('@release')
                      ;

            $participant_browser_1->assertSee('Your Answer')
                  ->waitFor('@next_question')
                  ->assertSee('Next Question')
                  ->press('@next_question')
                  ->type('answer', 'MYANSWER')
                  ->assertSee('Submit')
                  ->press('Submit')
                  ->waitFor('@your-answer')
                  ;


           $qm_browser->waitFor('@next_question')
                 ->press('@next_question')
                 ->waitFor('@release')
                 ->press('@release')
                      ;

            $participant_browser_1->assertSee('Your Answer')
                  ->waitFor('@next_question')
                  ->assertSee('Next Question')
                  ->press('@next_question')
                  ->type('answer', 'MYANSWER')
                  ->assertSee('Submit')
                  ->press('Submit')
                  ->waitFor('@your-answer')
                  ;


           $qm_browser->waitFor('@next_question')
                 ->press('@next_question')
                 ->waitFor('@release')
                 ->press('@release')
                      ;

            $participant_browser_1->assertSee('Your Answer')
                  ->waitFor('@next_question')
                  ->assertSee('Next Question')
                  ->press('@next_question')
                  ->type('answer', 'MYANSWER')
                  ->assertSee('Submit')
                  ->press('Submit')
                  ->waitFor('@your-answer')
                  ;

           $qm_browser->waitFor('@next_question')
                 ->press('@next_question')
                 ->waitFor('@release')
                 ->press('@release')
                    ;

            $participant_browser_1->assertSee('Your Answer')
                  ->waitFor('@next_question')
                  ->assertSee('Next Question')
                  ->press('@next_question')
                  ->type('answer', 'MYANSWER')
                  ->assertSee('Submit')
                  ->press('Submit')
                  ->waitFor('@your-answer')
                  ;

            $qm_browser->waitFor('@next_question')
                  ->press('@next_question')
                  ->waitFor('@mark')
                  ->press('@mark')
                  ->assertSee('Quiz Marking')
                  ->press('@release_scores')
                  ->assertSee('Quiz Overview')
                     ;

             $participant_browser_1->waitFor('@scores')
                   ->press('@scores')
                   ->assertSee('Results Of Last Round')
                   ->waitFor('@end_of_quiz')
                   ->press('@end_of_quiz')
                   ->assertSee('Quiz Overview')
                   ;

      });
  }

}
