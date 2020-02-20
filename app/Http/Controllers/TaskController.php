<?php

namespace App\Http\Controllers;

use App\Folder; // 追加 
use App\User; //追加
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //追加

class TaskController extends Controller
{ 

  /****************************************
    フォルダー関連の処理
  *****************************************/
  // フォルダーやタスクデータの一覧を取得
  public function index()
  {   
    $user_id = Auth::user()->id;

    $allData = User::with('folders')->find($user_id);
    
    return $allData;
  }    

  public function createFolder(Request $request)
  {  
    // Auth::user()はApp\Userのインスタンスを返す。モデルのこと
    // これで探しているのと同じ。User::find($id);
    $user = Auth::user();
    // https://programing-school.work/laravel-belongsto/
    $user->folders()->create($request->all());
    // 更新されたデータを新たに全て取得
    $user_id = Auth::user()->id;

    $allData = User::with('folders')->find($user_id);

    return $allData;
  }

  // フォルダーを削除
  public function deleteFolder($folder_id)
  { 

    $user = Auth::user();

    $user_id = Auth::user()->id;

    $user->folders()->find($folder_id)->delete();

    $allData = User::with(['folders.cards.tasks'])->find($user_id);

    return $allData;

  }

  public function updateFolder($folder_id)
  {
    dd('フォルダーののアップデート処理です');
  }

  // フォルダー配下のカードのデータを取得
  public function selectCrad($folder_id)
  {
    // dd($folder_id);

    $user = Auth::user();

    $user_id = Auth::user()->id;

    // $folderId = $id->id;
    
    $allData = User::with(['folders.cards.tasks'])->find($user_id);

    $cardData = $allData->folders->find($folder_id);

    return $cardData;
  }

  /****************************************
    カード関連の処理
  *****************************************/
  // カードの作成
  public function createCard(Request $request, $folder_id)
  {
    // dd($request->title, $id);

    $folder = Folder::find($folder_id);

    $folder->cards()->create($request->all());

    $user = Auth::user();

    $user_id = Auth::user()->id;
    
    $allData = User::with(['folders.cards.tasks'])->find($user_id);

    $cardData = $allData->folders->find($folder_id);

    return $cardData;
  }

  // カードの削除
  public function deleteCard($folder_id, $card_id)
  {
    // dd('カード削除の処理です');

    $folder = Folder::find($folder_id);

    $folder->cards()->find($card_id)->delete();

    $user = Auth::user();

    $user_id = Auth::user()->id;

    $allData = User::with(['folders.cards.tasks'])->find($user_id);

    $cardData = $allData->folders->find($folder_id);

    return $allData;
  }

  public function updateCard($folder_id, $card_id)
  {
    dd('カードのアップデート処理です');
  }

  /****************************************
    タスク関連の処理
  *****************************************/
  public function createTask($folder_id, $card_id)
  {
    dd('タスクの新規登録処理です');
  }

  public function deleteTask($folder_id, $card_id, $task_id)
  {
    dd('タスクの削除処理です');
  }

  public function updateTask($folder_id, $card_id, $task_id)
  {
    dd('タスクのアップデート処理です');
  }
}
