<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\AppNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function send(Request $request)
    {
        $user = User::first();
        if (! $user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        $data = [
            'title' => $request->input('title', 'Hello World'),
            'body' => $request->input('body', 'This is a test notification.'),
            'timestamp' => now(),
        ];

        $user->notify(new AppNotification($data));

        return response()->json(['message' => 'Notification sent successfully', 'data' => $data]);
    }

    public function index()
    {
        $user = User::first();

        if (! $user) {
            return response()->json(['message' => 'No user found'], 404);
        }

        return response()->json([
            'unread_count' => $user->unreadNotifications->count(),
            'notifications' => $user->notifications,
        ]);
    }

    public function markAsRead($id)
    {
        $user = User::first();
        if (! $user) {
            return response()->json(['error' => 'No user'], 404);
        }

        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();

            return response()->json(['message' => 'Marked as read']);
        }

        return response()->json(['message' => 'Notification not found'], 404);
    }
}
