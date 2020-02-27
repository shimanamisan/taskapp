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

  /****************************************
    フォルダー関連の処理
  *****************************************/
  // フォルダーやタスクデータの一覧を取得
  public function index()
  {  
    $user = Auth::user();

    $user_id = $user->id;

    $folderData = User::with('folders')->find($user_id);
    
    return $folderData;
  }    

  public function createFolder(TaskRequest $request)
  {  
    // Auth::user()はApp\Userのインスタンスを返す。モデルのこと
    // これで探しているのと同じ。User::find($id);
    $user = Auth::user();

    $user_id = $user->id;
    // https://programing-school.work/laravel-belongsto/
    $user->folders()->create($request->all());
    // 更新されたデータを新たに全て取得
    $allData = User::with('folders')->find($user_id);

    return $allData;
  }

  // フォルダーを削除
  public function deleteFolder($folder_id)
  { 

    $user = Auth::user();

    $user_id = $user->id;

    $user->folders()->find($folder_id)->delete();

    $allData = User::with('folders')->find($user_id);

    return $allData;

  }

  public function updateFolder(TaskRequest $request, $folder_id)
  {
    // dd('フォルダーのアップデート処理です： '. $request->title . 'フォルダーID： ' . $folder_id);

    $user = Auth::user();

    $user_id = $user->id;

    $user->folders()->find($folder_id)->update($request->all());

    $folderData = User::with('folders')->find($user_id);

    return $folderData;
  }

  // フォルダー配下のカードのデータを取得
  public function selectCrad($folder_id)
  {

    $user = Auth::user();

    $user_id = $user->id;
    
    $allData = User::with(['folders.cards.tasks'])->find($user_id);

    $cardData = $allData->folders->find($folder_id);

    return $cardData;
  }

  /****************************************
    カード関連の処理
  *****************************************/
  // カードの作成
  public function createCard(TaskRequest $request, $folder_id)
  {
    $user = Auth::user();

    $user_id = $user->id;

    $folder = Folder::find($folder_id);

    $folder->cards()->create($request->all());
    
    $allData = User::with(['folders.cards.tasks'])->find($user_id);

    $cardData = $allData->folders->find($folder_id);

    return $cardData;
  }

  // カードの削除
  public function deleteCard($folder_id, $card_id)
  {
    // dd('カード削除の処理です');
    $user = Auth::user();

    $user_id = $user->id;

    $folder = Folder::find($folder_id);

    $folder->cards()->find($card_id)->delete();

    $allData = User::with(['folders.cards.tasks'])->find($user_id);

    $cardData = $allData->folders->find($folder_id);

    return $cardData;
  }

  public function updateCard(TaskRequest $request, $folder_id, $card_id)
  {
    // dd('カードのアップデート処理です');
    $user = Auth::user();

    $user_id = $user->id;

    $folder = Folder::find($folder_id);

    $folder->cards()->find($card_id)->update($request->all());

    $allData = User::with(['folders.cards.tasks'])->find($user_id);

    $cardData = $allData->folders->find($folder_id);

    return $cardData;
  }

  /****************************************
    タスク関連の処理
  *****************************************/
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
    // dd('タスクのアップデート処理です');

    $user = Auth::user();

    $user_id = $user->id;

    $folder = Folder::find($folder_id);

    $folder->cards()->find($card_id)->tasks()->find($task_id)->update($request->all());

    $allData = User::with(['folders.cards.tasks'])->find($user_id);

    $cardData = $allData->folders->find($folder_id);
    
    return $cardData;
  }

  public function updateDraggable(Request $request, $task_id)
  { 
    
    $user = Auth::user();

    $user_id = $user->id;

    $task = Task::find($task_id);

    $task->update($request->all());

    return $task;
  }
}
