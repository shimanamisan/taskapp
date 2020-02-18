<?php

namespace App\Http\Controllers;

use App\Folder; // 追加 
use App\User; //追加
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //追加

class TaskController extends Controller
{
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
    public function deleteFolder(Request $id)
    {
      $user = Auth::user();

      $user_id = Auth::user()->id;

      $folderId = $id->id;

      $user->folders()->find($folderId)->delete();

      $allData = User::with(['folders.cards.tasks'])->find($user_id);

      return $allData;

    }

    // カードのデータを取得
    public function selectCrad(Request $id)
    {
     
      $user = Auth::user();

      $user_id = Auth::user()->id;

      $folderId = $id->id;
      
      $allData = User::with(['folders.cards.tasks'])->find($user_id);

      $cardData = $allData->folders->find($folderId);

      return $cardData;
    }

    // カードの作成
    public function createCard(Request $request, $id)
    {
      // dd($request->title, $id);

      $folder = Folder::find($id);

      $folder->cards()->create($request->all());

      $user = Auth::user();

      $user_id = Auth::user()->id;
      
      $allData = User::with(['folders.cards.tasks'])->find($user_id);

      $cardData = $allData->folders->find($id);

      return $cardData;
    }

    // カードの削除
    public function deleteCard(Request $request, $id)
    {
      // dd($request->title, $id);
      $user = Auth::user();

      $user_id = Auth::user()->id;

      $folderId = $id->id;

      $user->folders()->find($folderId)->delete();

      $allData = User::with(['folders.cards.tasks'])->find($user_id);

      return $allData;
    
    }

}
