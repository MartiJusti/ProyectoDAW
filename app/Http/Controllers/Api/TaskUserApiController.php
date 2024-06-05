<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskUserApiController extends Controller
{
    public function getTasksUser(User $user)
    {
        $tasks = $user->tasks()->get();

        return response()->json($tasks);
    }

    public function getUsersTask(Task $task)
    {
        $users = $task->users()->get();

        return response()->json($users);
    }

    public function assignUserToTask(Request $request, Task $task)
    {
        $userId = $request->get('user_id');

        if (!$userId) {
            return response()->json(['error' => 'User ID is required'], 400);
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $task->users()->attach($userId);

        return response()->json(['message' => 'User assigned to task successfully'], 200);
    }

    public function removeUserFromTask($taskId, $userId)
    {
        $task = Task::find($taskId);
        $user = User::find($userId);

        if (!$task || !$user) {
            return response()->json(['error' => 'Task or User not found'], 404);
        }

        $task->users()->detach($userId);

        return response()->json(['message' => 'User removed from task successfully'], 200);
    }

    //Estas tareas son para el calendario, ya que para que las muestre las fechas han de tener esos nombres
    public function calendarTasks(User $user)
    {
        $tasks = $user->tasks()->get(['id', 'name as title', 'date_start as start', 'date_end as end']);
        return response()->json($tasks, 200);
    }


}
