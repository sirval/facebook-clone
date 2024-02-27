<?php

namespace App\Http\Controllers;

use App\Services\UserComment;
use App\Services\UserLike;
use App\Services\UserNotification;
use App\Services\UserPost;
use App\Services\UserProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDetailController extends Controller
{
    public $userProfile;
    public $myPost;
    public $comments;
    public $likes;
    public $notification;

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        UserProfile $userProfile, 
        UserPost $myPost, 
        UserComment $comments,
        UserLike $likes,
        UserNotification $notification
    )
    {
        $this->middleware('auth');
        $this->userProfile = $userProfile;
        $this->myPost = $myPost;
        $this->comments = $comments;
        $this->likes = $likes;
        $this->notification = $notification;
    }
   
   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userDetail(string $id)
    {
        // $id = request('id');
        $userDetail = $this->userProfile->userDetail($id);
        // dd($userDetail);
        $connectedUsers = $this->userProfile->getOtherUsers(Auth::id() ?? $id);
        return view('user-posts', compact('userDetail', 'connectedUsers'));
    }

}
