<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Score;
use Illuminate\Http\Request;

class ScoreApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scores = Score::all();
        return response()->json($scores, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $existingScore = Score::where('user_id', $request->get('user_id'))
            ->where('task_id', $request->get('task_id'))
            ->first();

        if ($existingScore) {
            return response()->json(['error' => 'Ya existe una puntuación para este usuario y tarea'], 400);
        }

        $score = new Score();
        $score->points = $request->get('points');
        $score->user_id = $request->get('user_id');
        $score->task_id = $request->get('task_id');
        $score->save();

        return response()->json($score, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $score = Score::find($id);

        if (!$score) {
            return response()->json(['error' => 'Instancia de puntuación no encontrada'], 404);
        }

        return response()->json($score, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $score = Score::find($id);

        if (!$score) {
            return response()->json(['error' => 'Instancia de puntuación no encontrada'], 404);
        }

        $score->points = $request->get('points');
        $score->save();

        return response()->json($score, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Score $score)
    {
        //
    }

    /**
     * Get scores by user ID.
     */
    public function getScoresByUserId($userId)
    {
        $scores = Score::where('user_id', $userId)->get();

        if ($scores->isEmpty()) {
            return response()->json(['error' => 'No se encontraron puntuaciones para este usuario'], 404);
        }

        return response()->json($scores, 200);
    }

    /**
     * Get scores by task ID.
     */
    public function getScoresByTaskId($taskId)
    {
        $scores = Score::where('task_id', $taskId)->with('user')->get();

        if ($scores->isEmpty()) {
            return [];
        }

        return response()->json($scores, 200);
    }


    public function getScoreByUserIdAndTaskId($userId, $taskId)
    {
        $score = Score::where('user_id', $userId)
            ->where('task_id', $taskId)
            ->first();

        if (!$score) {
            return response()->json(['error' => 'Puntuación no encontrada.'], 404);
        }

        return response()->json($score, 200);
    }

    public function updateByUserIdAndTaskId(Request $request, $userId, $taskId)
    {
        $score = Score::where('user_id', $userId)->where('task_id', $taskId)->first();

        if ($score) {
            $score->update([
                'points' => $request->input('points')
            ]);
        } else {
            $score = Score::create([
                'user_id' => $userId,
                'task_id' => $taskId,
                'points' => $request->input('points')
            ]);
        }

        return response()->json($score, 200);
    }

    public function updateScore(Request $request, $userId, $taskId)
    {
        // Lógica para actualizar la puntuación
        $score = Score::where('user_id', $userId)->where('task_id', $taskId)->first();
        if ($score) {
            $score->points = $request->points;
            $score->save();
            return response()->json($score);
        }

        return response()->json(['error' => 'Score not found.'], 404);
    }

    public function createScore(Request $request, $userId, $taskId)
    {
        // Lógica para crear una nueva puntuación
        $score = new Score;
        $score->user_id = $userId;
        $score->task_id = $taskId;
        $score->points = $request->points;
        $score->save();
        return response()->json($score);
    }

}
