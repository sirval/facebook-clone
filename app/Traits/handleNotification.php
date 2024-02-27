<?php

namespace App\Traits;

use App\Models\Notification;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

trait handleNotification
{
    protected function storeNotification(array $data) : void
    {
        Notification::create([
            'user_id' => $data['user_id'],
            'post_id' => $data['post_id'],
        ]);
    }

    protected function getNotifications()
    {
        return Notification::where('user_id', Auth::id())
                            ->where('is_read', 0)->take(4);
    }

    protected function isRead(): bool
    {
        $resp = Notification::where('user_id', Auth::id())->update([
            'is_read' => 1
        ]);
        return $resp ? true : false;
    }
}
