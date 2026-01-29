<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/send-notification', [NotificationController::class, 'send']);
Route::get('/notifications', [NotificationController::class, 'index']);
Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
