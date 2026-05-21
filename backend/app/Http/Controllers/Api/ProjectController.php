<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Project::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'goal' => $request->goal,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'status' => $request->status ?? 'pending',
        ]);

        return response()->json([
            'message' => 'Project berhasil dibuat',
            'data' => $project
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);

        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'goal' => $request->goal,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Project berhasil diupdate',
            'data' => $project
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);

        $project->delete();

        return response()->json([
            'message' => 'Project berhasil dihapus'
        ]);
    }
}