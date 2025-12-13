<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Notification Controller
 * 
 * Handles in-app notifications
 */
class NotificationController extends Controller
{
    /**
     * Get user's notifications
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $notifications = $request->user()
            ->notifications()
            ->paginate(20);

        return $this->successResponse($notifications, __('messages.notification.retrieved_successfully'));
    }

    /**
     * Get unread notifications
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function unread(Request $request): JsonResponse
    {
        $notifications = $request->user()
            ->unreadNotifications()
            ->get();

        return $this->successResponse($notifications, __('messages.notification.retrieved_successfully'));
    }

    /**
     * Mark notification as read
     * 
     * @param string $id
     * @param Request $request
     * @return JsonResponse
     */
    public function markAsRead(string $id, Request $request): JsonResponse
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $id)
            ->first();

        if (!$notification) {
            return $this->notFoundResponse(__('messages.notification.not_found'));
        }

        $notification->markAsRead();

        return $this->successResponse($notification, __('messages.notification.marked_as_read'));
    }

    /**
     * Mark all notifications as read
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        return $this->successResponse(null, __('messages.notification.all_marked_as_read'));
    }

    /**
     * Delete notification
     * 
     * @param string $id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(string $id, Request $request): JsonResponse
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $id)
            ->first();

        if (!$notification) {
            return $this->notFoundResponse(__('messages.notification.not_found'));
        }

        $notification->delete();

        return $this->successResponse(null, __('messages.notification.deleted_successfully'));
    }
}
