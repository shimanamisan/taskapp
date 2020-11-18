<?php

namespace App\Http\Controllers;

use App\User; //追加
use App\Folder; // 追加
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //追加
use App\Http\Requests\TaskRequest; // フォームリクエストクラスを追加

class FolderController extends Controller
{
    // フォルダーやタスクデータの一覧を取得
    public function index()
    {
        $user = Auth::user();

        $user_id = $user->id;

        $folderData = User::with([
            "folders" => function ($query) {
                $query->orderBy("priority", "asc");
            },
        ])->find($user_id);

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
        $allData = User::with("folders")->find($user_id);

        return $allData;
    }

    // フォルダーを削除
    public function deleteFolder($folder_id)
    {
        $user = Auth::user();

        $user_id = $user->id;

        $user
            ->folders()
            ->find($folder_id)
            ->delete();

        $allData = User::with("folders")->find($user_id);

        return $allData;
    }
    // フォルダーのタイトル更新
    public function updateFolder(TaskRequest $request, $folder_id)
    {
        $user = Auth::user();

        $user_id = $user->id;

        $user
            ->folders()
            ->find($folder_id)
            ->update($request->all());

        $folderData = User::with([
            "folders" => function ($query) {
                $query->orderBy("priority", "asc");
            },
        ])->find($user_id);

        return $folderData;
    }

    // フォルダーのソート更新
    public function updateFolderSort(Request $request)
    {
        // フロント側から送られてきたフォルダー情報を取得
        $newFolders = $request->folders;

        // DBないに保存されているフォルダー情報を全て取得
        $folders = Folder::all();

        // DBから取得してきた情報をループで回す
        foreach ($folders as $folder) {
            // DB内のデータの１回分解している中で、フロント側から渡ってきたフォルダー情報を全てループで分解する
            foreach ($newFolders as $newFolder) {
                // 渡ってきたデータのidとDB内のidが同じだったらカラムのsort情報である priorityカラムの情報を書き換える
                if ($newFolder["id"] == $folder->id) {
                    // update(['カラム名'] => $更新する値の変数['key']); のように仕様することも出来る
                    $folder->update(["priority" => $newFolder["priority"]]);
                }
            }
        }

        $user = Auth::user();

        $user_id = $user->id;

        $folderData = User::with([
            "folders" => function ($query) {
                $query->orderBy("priority", "asc");
            },
        ])->find($user_id);

        return $folderData;
    }

    // フォルダー配下のカードのデータを取得
    public function selectCrad($folder_id)
    {
        $user = Auth::user();

        $user_id = $user->id;

        $allData = User::with([
            "folders.cards.tasks" => function ($query) {
                $query->orderBy("priority", "asc");
            },
        ])->find($user_id);

        $cardData = $allData->folders->find($folder_id);

        return $cardData;
    }
}
