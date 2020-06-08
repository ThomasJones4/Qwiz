<?php

namespace App\Http\Controllers;

use App\Question;
use App\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;


class MediaController extends Controller
{
  /**
   * show add media page
   *
   * @param  \App\Question  $question
   * @return \Illuminate\Http\Response
   */
  public function create(Question $question)
  {
      return view('media.create', $question);
  }

  /**
   * store media
   *
   * @param  \App\Question  $question
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, Question $question)
  {
    Gate::authorize('view_master', $question);

    $request->validate([
      'file' => 'required|mimes:gif,png,jpeg,jpg,avi,mvv,mov,mp4,mp3,acc,wav,mpga',
      'answer' => '',
    ]);

    $images = ['gif', 'png', 'jpeg', 'jpg'];
    $video = ['avi', 'mvv', 'mov', 'mp4'];
    $audio = ['mp3', 'aac', 'wav', 'mpga'];

    $media = new Media;

    if (in_array($request->file->extension(), $images)) {
      $media->type = "image";
    } else if (in_array($request->file->extension(), $audio)) {
      $media->type = "audio";
    } else if (in_array($request->file->extension(), $video)) {
      $media->type = "video";
    }

    if ($request->answer == null) {
      $media->answer = "1";
    }

    $media->extension = $request->file->extension();

    //upload to s3 bucket
    $media->url = config('filesystems.disks.s3.url').$request->file('file')->store('images', 's3');

    $media->question_id = $question->id;
    $media->save();

    return redirect()->route('questions.edit', $question);

  }



      /**
       * Remove the specified resource from storage.
       *
       * @param  \App\Media  $media
       * @return \Illuminate\Http\Response
       */
      public function destroy(Question $question, Media $media)
      {
          Gate::authorize('view_master', $question);

          $media->delete();

          return redirect()->route('questions.edit', $question);
      }
}
