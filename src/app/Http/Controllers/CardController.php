<?php

namespace App\Http\Controllers;

use App\User; //追加
use App\Folder; // 追加
use App\Card; // 追加
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //追加
use App\Http\Requests\TaskRequest; // フォームリクエストクラスを追加

class CardController extends Controller
{
    // カードの作成
    public function createCard(TaskRequest $request, $folder_id)
    {
        try {
            $user = Auth::user();

            $user_id = $user->id;

            $folder = Folder::find($folder_id);

            $folder->cards()->create($request->all());

            $allData = User::with(["folders.cards.tasks"])->find($user_id);

            $cardData = $allData->folders->find($folder_id);

            return $cardData;
        } catch (\Exception $e) {
            \Log::debug("予期せぬエラーが発生しました。" . $e->getMessage());
            \Log::debug("   ");
            return response()->json(
                ["errors", "予期せぬエラーが発生しました。"],
                500
            );
        }
    }

    // カードの削除
    public function deleteCard($folder_id, $card_id)
    {
        try {
            $user = Auth::user();

            $user_id = $user->id;

            $folder = Folder::find($folder_id);

            $folder
                ->cards()
                ->find($card_id)
                ->delete();

            $allData = User::with(["folders.cards.tasks"])->find($user_id);

            $cardData = $allData->folders->find($folder_id);

            return $cardData;
        } catch (\Exception $e) {
            \Log::debug("予期せぬエラーが発生しました。" . $e->getMessage());
            \Log::debug("   ");
            return response()->json(
                ["errors", "予期せぬエラーが発生しました。"],
                500
            );
        }
    }

    public function updateCard(TaskRequest $request, $folder_id, $card_id)
    {
        try {
            $user = Auth::user();

            $user_id = $user->id;

            $folder = Folder::find($folder_id);

            $folder
                ->cards()
                ->find($card_id)
                ->update($request->all());

            $allData = User::with(["folders.cards.tasks"])->find($user_id);

            $cardData = $allData->folders->find($folder_id);

            return $cardData;
        } catch (\Exception $e) {
            \Log::debug("予期せぬエラーが発生しました。" . $e->getMessage());
            \Log::debug("   ");
            return response()->json(
                ["errors", "予期せぬエラーが発生しました。"],
                500
            );
        }
    }

    public function updateCardSort(Request $request)
    {
        try {
            $newCards = $request->cards["newCrads"]; // 配列の形式が他のフォルダーやタスクと違うのでキーを指定（調査する）

            \Log::debug("リクエストされたカードを取得しています：");

            // DBのカードをすべて取得
            $cards = Card::all();

            // DBから取得したカードをループ処理で分解する
            foreach ($cards as $card) {
                // DB内のカードのIDとリクエストされたカードのIDが同じだったらpriorityカラムを更新する
                foreach ($newCards as $newCard) {
                    // dd(print_r($newCards, true));
                    // dd($newCard['id']);
                    if ($newCard["id"] === $card->id) {
                        \Log::debug("priorityを更新しています。");
                        // モデルの$fillableにpriorityを追加することを忘れないように注意
                        // update(['カラム名'] => $更新する値の変数['key']); のように使用することも出来る
                        $card->update(["priority" => $newCard["priority"]]);
                    }
                }
            }
            return response(["success"], 200);
        } catch (\Exception $e) {
            \Log::debug("予期せぬエラーが発生しました。" . $e->getMessage());
            \Log::debug("   ");
            return response()->json(
                ["errors", "予期せぬエラーが発生しました。"],
                500
            );
        }
    }
}
