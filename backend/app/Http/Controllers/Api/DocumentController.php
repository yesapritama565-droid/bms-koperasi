<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');

        $path = $file->store('documents', 'public');

        $document = Document::create([
            'user_id' => auth()->id(),
            'project_id' => $request->project_id,
            'task_id' => $request->task_id,
            'file' => $path,
            'original_name' => $file->getClientOriginalName(),
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Upload berhasil',
            'data' => $document
        ]);
    }
}