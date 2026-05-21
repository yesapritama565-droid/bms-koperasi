<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        return ActivityLog::with('user')->latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'activity' => 'required',
        ]);

        $log = ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => $request->activity,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Activity berhasil dicatat',
            'data' => $log
        ]);
    }

    public function destroy(string $id)
    {
        ActivityLog::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Activity dihapus'
        ]);
    }
}