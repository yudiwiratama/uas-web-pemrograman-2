<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ApprovalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public API endpoints
Route::prefix('v1')->group(function () {
    // Authentication endpoints
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // Public course and material endpoints (read-only)
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{course}', [CourseController::class, 'show']);
    Route::get('/materials', [MaterialController::class, 'index']);
    Route::get('/materials/{material}', [MaterialController::class, 'show']);
    
    // Protected API endpoints (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        // Authentication
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);
        Route::put('/user', [AuthController::class, 'updateProfile']);
        
        // Course management
        Route::post('/courses', [CourseController::class, 'store']);
        Route::put('/courses/{course}', [CourseController::class, 'update']);
        Route::delete('/courses/{course}', [CourseController::class, 'destroy']);
        
        // Material management
        Route::post('/materials', [MaterialController::class, 'store']);
        Route::put('/materials/{material}', [MaterialController::class, 'update']);
        Route::delete('/materials/{material}', [MaterialController::class, 'destroy']);
        
        // Comments
        Route::get('/materials/{material}/comments', [CommentController::class, 'index']);
        Route::post('/materials/{material}/comments', [CommentController::class, 'store']);
        Route::put('/comments/{comment}', [CommentController::class, 'update']);
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
        
        // Admin only endpoints
        Route::middleware('admin')->prefix('admin')->group(function () {
            Route::get('/approvals', [ApprovalController::class, 'index']);
            Route::get('/approvals/{material}', [ApprovalController::class, 'show']);
            Route::put('/approvals/{material}', [ApprovalController::class, 'update']);
            
            // Admin statistics
            Route::get('/stats', [ApprovalController::class, 'stats']);
        });
    });
});

// Fallback route for API
Route::fallback(function(){
    return response()->json([
        'success' => false,
        'message' => 'API endpoint not found'
    ], 404);
}); 