<?php

namespace App\Http\Controllers;

use App\User; //追加
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //追加

class TaskController extends Controller
{
    // フォルダーやタスクデータの一覧を取得
    public function index()
    {   
      $user_id = Auth::user()->id;

      $allData = User::with(['folders.cards.tasks'])->find($user_id);
     
      return $allData;
    }    

    public function folderAdd(Request $request)
    {   
      
      $user = User::get($request);
      dd($user);

      return $user;
    }    
}
