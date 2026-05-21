<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskComment;

class TaskCommentController extends Controller
{
    public function index()
    {
        return TaskComment::with('user','task')->latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required',
            'comment' => 'required',
        ]);

        $comment = TaskComment::create([
            'task_id' => $request->task_id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'is_decision' => $request->is_decision ?? false,
        ]);

        return response()->json([
            'message' => 'Komentar berhasil dibuat',
            'data' => $comment
        ]);
    }

    public function update(Request $request, string $id)
    {
        $comment = TaskComment::findOrFail($id);

        $comment->update([
            'comment' => $request->comment,
            'is_decision' => $request->is_decision ?? false,
        ]);

        return response()->json([
            'message' => 'Komentar berhasil diupdate',
            'data' => $comment
        ]);
    }

    public function destroy(string $id)
    {
        TaskComment::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Komentar berhasil dihapus'
        ]);
    }
}