<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        return Announcement::with('user')->latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required',
        ]);

        $data = Announcement::create([
            'title' => $request->title,
            'message' => $request->message,
            'user_id' => auth()->id(),
            'is_active' => true,
        ]);

        return response()->json($data);
    }

    public function show($id)
    {
        return Announcement::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $data = Announcement::findOrFail($id);

        $data->update([
            'title' => $request->title,
            'message' => $request->message,
            'is_active' => $request->is_active,
        ]);

        return response()->json($data);
    }

    public function destroy($id)
    {
        Announcement::findOrFail($id)->delete();

        return response()->json(['message' => 'Deleted']);
    }
}