<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Quiz;
use App\Question;
use App\Response;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin Admin',
            'email' => 'admin@argon.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'api_token' => Str::random(60),
            'created_at' => now(),
            'updated_at' => now()
        ]);


        factory(User::class, 10)->create()->each(function ($user) {
          $user->my_quizzes()->save(factory(Quiz::class)->make());
          $user->my_quizzes()->each(function ($quiz) {
            for ($i = 0; $i < 20; $i++) {
              $quiz->questions()->save(factory(Question::Class)->make(['order' => $i]));
            }
          });
        });

        $quizzes = App\Quiz::all();

        factory(User::class, 300)->create()->each(function ($user) use ($quizzes){
          $user->quizzes()->saveMany($quizzes->random(rand(1, 3)));
          $user->quizzes()->each(function ($quiz) use ($user){
            $quiz->questions()->each(function ($question) use ($user) {
              $response = new Response;
              $response->user_id = $user->id;
              $response->question_id = $question->id;
              $response->answer = "My Answer";
              $response->save();
            });
          });
        });


    }
}
