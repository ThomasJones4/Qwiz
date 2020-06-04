<?php

namespace App\Policies;

use App\Quiz;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuizPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Quiz  $quiz
     * @return mixed
     */
    public function view(User $user, Quiz $quiz)
    {
        return ($user->quizzes()->get()->contains($quiz) || Gate::inspect('view_master', $quiz)->allowed())
                  ? Response::allow()
                  : Response::deny('You can not view this quiz. (001)');
    }

    /**
     * Determine whether the quiz has questions that can still be edited
     *
     * @param  \App\User  $user
     * @param  \App\Quiz  $quiz
     * @return mixed
     */
    public function editable(User $user, Quiz $quiz)
    {
        return ($quiz->questions()->where('released', '0')->count() > 0)
                  ? Response::allow()
                  : Response::deny('This quiz is not longer editable (005)');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Quiz  $quiz
     * @return mixed
     */
    public function view_master(User $user, Quiz $quiz)
    {
        return ($user->my_quizzes->contains($quiz))
                ? Response::allow()
                : Response::deny('You do not own this quiz. (002)');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Quiz  $quiz
     * @return mixed
     */
    public function update(User $user, Quiz $quiz)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Quiz  $quiz
     * @return mixed
     */
    public function delete(User $user, Quiz $quiz)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Quiz  $quiz
     * @return mixed
     */
    public function restore(User $user, Quiz $quiz)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Quiz  $quiz
     * @return mixed
     */
    public function forceDelete(User $user, Quiz $quiz)
    {
        //
    }
}
