<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\DocumentController;

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskChecklistController;
use App\Http\Controllers\Api\TaskCommentController;
use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\Api\MeetingNoteController;
use App\Http\Controllers\Api\ActivityLogController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // TASK
    Route::apiResource('tasks', TaskController::class);

    // PROJECT
    Route::apiResource('projects', ProjectController::class);

    // CHECKLIST
    Route::apiResource('task-checklists', TaskChecklistController::class);

    // COMMENT
    Route::apiResource('task-comments', TaskCommentController::class);

    // ANNOUNCEMENT
    Route::apiResource('announcements', AnnouncementController::class);

    // MEETING NOTES
    Route::apiResource('meeting-notes', MeetingNoteController::class);

    // ACTIVITY LOG
    Route::apiResource('activity-logs', ActivityLogController::class);

    // DOCUMENT
    Route::post('/documents', [DocumentController::class, 'store']);
});