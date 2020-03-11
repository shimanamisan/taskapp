<?php

namespace App\Http\Controllers;

use App\Task;
use App\User; //追加
use App\Folder; // 追加 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //追加
use App\Http\Requests\TaskRequest; // フォームリクエストクラスを追加

class TaskController extends Controller
{ 

  public function createTask(TaskRequest $request, $folder_id, $card_id)
  {
    // dd($folder_id);

    $user = Auth::user();

    $user_id = $user->id;

    $folder = Folder::find($folder_id);

    $folder->cards()->find($card_id)->tasks()->create($request->all());

    $allData = User::with(['folders.cards.tasks'])->find($user_id);

    $cardData = $allData->folders->find($folder_id);

    return $cardData;

  }

  public function deleteTask($folder_id, $card_id, $task_id)
  {
    // dd('タスクの削除処理です');

    $user = Auth::user();

    $user_id = $user->id;

    $folder = Folder::find($folder_id);

    $folder->cards()->find($card_id)->tasks()->find($task_id)->delete();

    $allData = User::with(['folders.cards.tasks'])->find($user_id);

    $cardData = $allData->folders->find($folder_id);
    
    return $cardData;
  }

  public function updateTask(TaskRequest $request, $folder_id, $card_id, $task_id)
  {
    $user = Auth::user();

    $user_id = $user->id;

    $folder = Folder::find($folder_id);

    $folder->cards()->find($card_id)->tasks()->find($task_id)->update($request->all());

    $allData = User::with(['folders.cards.tasks'])->find($user_id);

    $cardData = $allData->folders->find($folder_id);
    
    return $cardData;
  }

  public function updateTaskDraggable(Request $request, $task_id)
  { 

    $user = Auth::user();

    $user_id = $user->id;

    $task = Task::find($task_id);


    $task->update($request->all());

    return $task;
  }

  public function updateTaskSort(Request $request){

    $newTasks = $request->tasks;

    $tasks = Task::all();

    foreach($tasks as $task){

      foreach($newTasks as $newTask){
        if($newTask['id'] == $task->id ){
          // update(['カラム名'] => $更新する値の変数['key']); のように使用することも出来る
          $task->update(['priority' => $newTask['priority']]);
        }
      }
    } 

    return response(['success'], 200);
  }
}
