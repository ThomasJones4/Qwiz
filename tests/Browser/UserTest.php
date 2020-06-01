<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;
use App\Quiz;

class UserTest extends DuskTestCase
{
    /**
     * Test the user can login
     *
     * @return void
     */
    public function testUserCanLogin()
    {

      print_r( DB::select('SHOW DATABASES'));
      echo env('DB_HOST');
      echo env('DB_DATABASE');
      echo env('DB_USERNAME');
      echo env('DB_PASSWORD');

        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                  ->type('email', $user->email)
                  ->type('password', 'password')
                  ->press('Sign in')
                  ->assertPathIs('/home');
        });
    }

    /**
     * Test a new user can see the quizzes dashboard
     *
     * @return void
     */
    public function testUserCanSeeFreshDashboard()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/quizzes/mine')
                  ->assertSee('Your Quizzes')
                  ->assertSee('You haven\'t made any quizzes yet')
                  ->assertSee('Quizzes Your Part Of')
                  ->assertSee('You haven\'t joined any quizzes yet');
        });
    }

    /**
     * Test a new user can create a new quiz
     *
     * @return void
     */
    public function testUserCanCreateNewQuiz()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser){
            $browser->visit('/quizzes/mine')
                  ->assertSee('Create New Quiz')
                  ->clickLink('Create New Quiz')
                  ->assertPathIs('/quizzes/create')
                  ->assertSee('Create a new quiz')
                  ->type('name', 'The big new quiz')
                  ->type('scheduled_start', '2019-04-30')
                  ->press('Create Quiz')
                  ->assertSee('The big new quiz Questions');
        });
    }

    /**
     * Test a new user can create a new quiz
     *
     * @return void
     */
    public function testUserCanAddQuestions()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/quizzes/mine')
                  ->assertSee('Create New Quiz')
                  ->clickLink('Create New Quiz')
                  ->assertPathIs('/quizzes/create')
                  ->assertSee('Create a new quiz')
                  ->type('name', 'The big new quiz')
                  ->type('scheduled_start', '2019-04-30')
                  ->press('Create Quiz')
                  ->assertSee('The big new quiz Questions')
                  ->assertSee('Add new Question')
                  ->clickLink('Add new Question')
                  ->type('title', 'Cat #1')
                  ->type('question', 'But is it really?')
                  ->press('Add question')
                  ->assertSee('CATEGORY')
                  ->assertSee('Cat #1')
                  ->assertSee('But is it really?')
                  ;
        });
    }

    /**
     * Test a new user can create a new quiz
     *
     * @return void
     */
    public function testUserCanJoinAQuiz()
    {
        $quiz_master = factory(User::class)->create();
        $participant = factory(User::class)->create();

        $this->browse(function (Browser $qm_browser, Browser $p_browser) use ($quiz_master, $participant){
            $qm_browser->visit('/quizzes/mine')
                  ->assertSee('Create New Quiz')
                  ->clickLink('Create New Quiz')
                  ->assertPathIs('/quizzes/create')
                  ->assertSee('Create a new quiz')
                  ->type('name', 'The big new quiz')
                  ->type('scheduled_start', '2019-04-30')
                  ->press('Create Quiz')
                  ->assertSee('The big new quiz Questions')
                  ->assertSee('Add new Question')
                  ->clickLink('Add new Question')
                  ->type('title', 'Cat #1')
                  ->type('question', 'But is it really?')
                  ->press('Add question')
                  ->assertSee('CATEGORY')
                  ->assertSee('Cat #1')
                  ->assertSee('But is it really?');

          $invite_code = $qm_browser->value('@invite_code');
          $quiz_id = $qm_browser->value('@quiz_id');

          $p_browser->visit('/login')
                ->type('email', $participant->email)
                ->type('password', 'password')
                ->press('Sign in')
                ->assertPathIs('/home')
                ->visit(route('show.join.quiz', Quiz::find($quiz_id), false))
                ->type('invite_code', $invite_code)
                ->press('Join')
                ->assertPathIs(route('quiz.show', Quiz::find($quiz_id), false))
                ->assertSee('Waiting for quiz master')
                ;
        });
    }
}
