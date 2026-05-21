<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MeetingNote;

class MeetingNoteController extends Controller
{
    public function index()
    {
        return MeetingNote::with('user')->latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'notes' => 'required',
        ]);

        $data = MeetingNote::create([
            'title' => $request->title,
            'notes' => $request->notes,
            'attachment' => $request->attachment,
            'meeting_date' => $request->meeting_date,
            'user_id' => auth()->id(),
        ]);

        return response()->json($data);
    }

    public function show($id)
    {
        return MeetingNote::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $data = MeetingNote::findOrFail($id);

        $data->update([
            'title' => $request->title,
            'notes' => $request->notes,
            'attachment' => $request->attachment,
            'meeting_date' => $request->meeting_date,
        ]);

        return response()->json($data);
    }

    public function destroy($id)
    {
        MeetingNote::findOrFail($id)->delete();

        return response()->json(['message' => 'Deleted']);
    }
}