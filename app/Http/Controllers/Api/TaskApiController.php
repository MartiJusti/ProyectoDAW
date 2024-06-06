<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TaskApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks, 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $user = Auth::user();

        $task = new Task();
        $task->name = $request->get('name');
        $task->description = $request->get('description');
        $task->date_start = $request->get('date_start');
        $task->date_end = $request->get('date_end');
        $task->save();

        $task->users()->attach($user->id);

        return response()->json($task, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }

        return response()->json($task, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);

        if ($request->has('name')) {
            $task->name = $request->input('name');
        }
        if ($request->has('description')) {
            $task->description = $request->input('description');
        }
        if ($request->has('date_start')) {
            $task->date_start = $request->input('date_start');
        }
        if ($request->has('date_end')) {
            $task->date_end = $request->input('date_end');
        }
        $task->save();

        return response()->json($task, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json($task, 204);
    }

    public function calendarAdminTasks()
    {
        $tasks = Task::get(['id', 'name as title', 'date_start as start', 'date_end as end']);
        return response()->json($tasks, 200);

    }

}
