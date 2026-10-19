<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * How many notifications the bell dropdown lists.
     */
    public const LIMIT = 8;

    // GET /admin/notifications — polled by admin.js to refresh the bell without a page reload
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $notifications = $user->notifications()->take(self::LIMIT)->get();
        $latestUnread = $user->unreadNotifications()->first();

        return response()->json([
            'unread' => $user->unreadNotifications()->count(),
            'new_enquiries' => $user->can('view enquiries') ? Enquiry::unread()->count() : 0,
            'latest' => $latestUnread ? [
                'id' => $latestUnread->id,
                'text' => "New enquiry from {$latestUnread->data['name']}",
                'topic' => $latestUnread->data['topic'],
                'url' => route('admin.notifications.show', $latestUnread->id),
            ] : null,
            'html' => view('admin.partials.notifications', ['notifications' => $notifications])->render(),
        ]);
    }

    // GET /admin/notifications/{id} — mark one read and open the enquiry it points to
    public function show(Request $request, string $notification): RedirectResponse
    {
        $notification = $request->user()->notifications()->findOrFail($notification);
        $notification->markAsRead();

        $enquiry = Enquiry::find($notification->data['enquiry_id'] ?? null);

        return $enquiry
            ? redirect()->route('admin.enquiries.show', $enquiry)
            : redirect()->route('admin.enquiries.index')->with('status', 'That enquiry has been deleted.');
    }

    // POST /admin/notifications/read-all
    public function readAll(Request $request): RedirectResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        return back()->with('status', 'All notifications marked as read.');
    }
}
