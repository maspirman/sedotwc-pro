<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::forUser(auth()->id());

        // Filter by read status
        if ($request->filled('read_status')) {
            if ($request->read_status === 'read') {
                $query->whereNotNull('read_at');
            } elseif ($request->read_status === 'unread') {
                $query->whereNull('read_at');
            }
        }

        // Filter by type
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        $notifications = $query->latest()->paginate(20);

        // Get notification types for filter
        $notificationTypes = Notification::forUser(auth()->id())
            ->select('type')
            ->distinct()
            ->pluck('type');

        return view('admin.notifications.index', compact('notifications', 'notificationTypes'));
    }

    public function markAllAsRead()
    {
        Notification::forUser(auth()->id())
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json(['success' => true]);
    }

    public function markAsRead(Notification $notification)
    {
        // Check if the notification belongs to the current user or is global
        if ($notification->user_id && $notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }
}
