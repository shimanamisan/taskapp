<?php

namespace App\Http\Controllers;

use App\User; //追加
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //追加

class TaskController extends Controller
{
    // フォルダーを追加する処理を組んでいく
    public function index()
    {   
      $user_id = Auth::user()->id;

      $AllLists = User::with(['folders.cards.tasks'])->find($user_id);

      return $AllLists;
    }    
}
