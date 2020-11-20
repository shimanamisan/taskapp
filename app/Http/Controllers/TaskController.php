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
        try {
            $user = Auth::user();

            $user_id = $user->id;

            $folder = Folder::find($folder_id);

            $folder
                ->cards()
                ->find($card_id)
                ->tasks()
                ->create($request->all());

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

    public function deleteTask($folder_id, $card_id, $task_id)
    {
        try {
            $user = Auth::user();

            $user_id = $user->id;

            $folder = Folder::find($folder_id);

            $folder
                ->cards()
                ->find($card_id)
                ->tasks()
                ->find($task_id)
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

    public function updateTask(
        TaskRequest $request,
        $folder_id,
        $card_id,
        $task_id
    ) {
        try {
            $user = Auth::user();

            $user_id = $user->id;

            $folder = Folder::find($folder_id);

            $folder
                ->cards()
                ->find($card_id)
                ->tasks()
                ->find($task_id)
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

    public function updateTaskDraggable(Request $request, $task_id)
    {
        try {
            $user = Auth::user();

            $user_id = $user->id;

            $task = Task::find($task_id);

            $task->update($request->all());

            return $task;
        } catch (\Exception $e) {
            \Log::debug("予期せぬエラーが発生しました。" . $e->getMessage());
            \Log::debug("   ");
            return response()->json(
                ["errors", "予期せぬエラーが発生しました。"],
                500
            );
        }
    }

    public function updateTaskSort(Request $request)
    {
        $newTasks = $request->tasks;
        \Log::debug(
            "リクエストされたタスクを取得しています：" .
                print_r($newTasks, true)
        );

        try {
            // タスクをすべて取得
            $tasks = Task::all();
            \Log::debug(
                "既存のタスクをすべて取得しています：" . print_r($tasks, true)
            );

            // DBに登録されているタスクをループで分解
            foreach ($tasks as $task) {
                // 既存タスクを分解する中で、ソート順が更新された全てのタスクをループで分解
                foreach ($newTasks as $newTask) {
                    \Log::debug(
                        "リクエストされたタスクを分解しています：" .
                            print_r($newTask, true)
                    );
                    \Log::debug(
                        "既存タスクのIDです：" . print_r($task->id, true)
                    );
                    // 既存のタスクIDと更新後のタスクIDが同じだったら既存タスクのソート順を更新する
                    if ($newTask["id"] === $task->id) {
                        \Log::debug(
                            "既存のタスクのIDと新しいタスクのIDが同じだったらpriorityをUPDATEします：" .
                                print_r($newTask["priority"], true)
                        );
                        // update(['カラム名'] => $更新する値の変数['key']); のように使用することも出来る
                        $task->update(["priority" => $newTask["priority"]]);
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
