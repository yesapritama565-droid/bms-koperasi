<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskChecklist;

class TaskChecklistController extends Controller
{
    public function index()
    {
        return response()->json(
            TaskChecklist::latest()->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required',
            'title' => 'required',
        ]);

        $checklist = TaskChecklist::create([
            'task_id' => $request->task_id,
            'title' => $request->title,
            'is_done' => false,
        ]);

        return response()->json([
            'message' => 'Checklist berhasil dibuat',
            'data' => $checklist
        ]);
    }

    public function show(string $id)
    {
        return response()->json(
            TaskChecklist::findOrFail($id)
        );
    }

    public function update(Request $request, string $id)
    {
        $checklist = TaskChecklist::findOrFail($id);

        $checklist->update([
            'title' => $request->title,
            'is_done' => $request->is_done,
        ]);

        return response()->json([
            'message' => 'Checklist berhasil diupdate',
            'data' => $checklist
        ]);
    }

    public function destroy(string $id)
    {
        $checklist = TaskChecklist::findOrFail($id);

        $checklist->delete();

        return response()->json([
            'message' => 'Checklist berhasil dihapus'
        ]);
    }
}