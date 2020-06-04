<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;
use App\Quiz;
use Illuminate\Support\Facades\DB;

class QuestionTest extends DuskTestCase
{

    /**
     * Test a quiz master can add a random question from the api
     *
     * @return void
     */
    public function testUserCanAddRandomQuestion()
    {
      $user = factory(User::class)->create();

      $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/quizzes/mine')
                ->assertSee('Create New Quiz')
                ->clickLink('Create New Quiz')
                ->assertPathIs('/quizzes/create')
                ->assertSee('Create a new quiz')
                ->type('name', 'The big new quiz')
                ->type('scheduled_start', '2019-04-30')
                ->press('Create Quiz')
                ->assertSee('The big new quiz Questions')
                ->assertSee('Add new Random Question')
                ->clickLink('Add new Random Question')
                ->press('Add to Quiz')
                ->assertSee('1')
                ->assertPresent('@question-edit')
                ;


      });
    }
    /**
     * Test a quiz master can add a random question from the api
     *
     * @return void
     */
    public function testUserCanEditQuestion()
    {
      $user = factory(User::class)->create();

      $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/quizzes/mine')
                ->assertSee('Create New Quiz')
                ->clickLink('Create New Quiz')
                ->assertPathIs('/quizzes/create')
                ->assertSee('Create a new quiz')
                ->type('name', 'The big new quiz')
                ->type('scheduled_start', '2019-04-30')
                ->press('Create Quiz')
                ->assertSee('The big new quiz Questions')
                ->assertSee('Add new Random Question')
                ->clickLink('Add new Random Question')
                ->press('Add to Quiz')
                ->assertSee('1')
                ->assertPresent('@question-edit')
                ->click('@question-edit')
                ->type('title', "Wow")
                ->press('Update question')
                ->assertSee('Wow')
                ;

      });
    }



}
