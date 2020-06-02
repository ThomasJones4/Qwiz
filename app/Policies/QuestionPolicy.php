<?php

namespace App\Policies;

use App\Question;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
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
     * @param  \App\Question  $question
     * @return mixed
     */
    public function view(User $user, Question $question)
    {

      // can view quiz
      Gate::authorize('view', $question->quiz);

      return ($question->released == '1')
            ? Response::allow()
            : Response::deny('This Question has not been released. (003)');
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
     * Determine whether the question can be moved up
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function move_up(User $user, Question $question)
    {
      Gate::authorize('view_master', $question->quiz);

        return ($question->order != "0")
          ? Response::allow()
          : Response::deny("Didn't think we'd every see you here. (004_up)");
    }

    /**
     * Determine whether the question can be moved down
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function move_down(User $user, Question $question)
    {
      Gate::authorize('view_master', $question->quiz);

      return ($question->order != $question->quiz->questions->count() - 1)
        ? Response::allow()
        : Response::deny("Didn't think we'd every see you here. (004_down)");
    }

    /**
     * Determine whether the question can be viewed
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view_master(User $user, Question $question)
    {
      return Gate::authorize('view_master', $question->quiz);
    }

    /**
     * Determine whether the question can be edited
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function is_editable(User $user, Question $question)
    {
      Gate::authorize('view_master', $question->quiz);

      return ($question->title != "%%scores%%" && $question->question == "-")
        ? Response::allow()
        : Response::deny("Didn't think we'd every see you here. (004_edit)");
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Question  $question
     * @return mixed
     */
    public function update(User $user, Question $question)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Question  $question
     * @return mixed
     */
    public function delete(User $user, Question $question)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Question  $question
     * @return mixed
     */
    public function restore(User $user, Question $question)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Question  $question
     * @return mixed
     */
    public function forceDelete(User $user, Question $question)
    {
        //
    }
}
