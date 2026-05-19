<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // tampil semua task
   public function index()
{
    $tasks = Task::with([
        'assignedToUser',
        'project',
        'comments'
    ])->latest()->get();

    return response()->json($tasks);
}

    // tambah task
   public function store(Request $request)
{
    $request->validate([
        'project_id' => 'required',
        'assigned_to' => 'required',
        'title' => 'required',
        'status' => 'required'
    ]);

    $task = Task::create([

        'project_id' => $request->project_id,

        'assigned_to' => $request->assigned_to,

        'title' => $request->title,

        'description' => $request->description,

        'priority' => $request->priority,

        'status' => $request->status,

        'progress' => $request->progress ?? 0,

        'deadline' => $request->deadline,
    ]);

    return response()->json([
        'message' => 'Task berhasil dibuat',
        'task' => $task
    ]);
}
    // detail task
    public function show(string $id)
    {
        return response()->json(Task::findOrFail($id));
    }

    // update task
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);

        $task->update($request->all());

        return response()->json([
            'message' => 'Task berhasil diupdate',
            'task' => $task
        ]);
    }

    // hapus task
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);

        $task->delete();

        return response()->json([
            'message' => 'Task berhasil dihapus'
        ]);
    }
}