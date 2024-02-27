<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ajaxResponse;
use App\Traits\fileUpload;
use App\Traits\handleNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserNotification
{
    use ajaxResponse, handleNotification;

    public function markAsRead()
    {
       try {
            $resp = $this->isRead();
            if ($resp === true) {
                return $this->jsonResponse('success', 200, 'Successfully marked as read',  null);
            }
            return $this->jsonResponse('error', 409, 'Failed to marked as read',  null);
                
       } catch (\Throwable $th) {
            return $this->jsonResponse('error', 500, 'A server error occurred. Please contact admin', $th->getMessage());
       }
    }

}