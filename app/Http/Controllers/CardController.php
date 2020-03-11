<?php

namespace App\Http\Controllers;

use App\User; //追加
use App\Folder; // 追加 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //追加
use App\Http\Requests\TaskRequest; // フォームリクエストクラスを追加

class CardController extends Controller
{
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
}