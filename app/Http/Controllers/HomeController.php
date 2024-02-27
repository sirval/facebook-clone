<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Services\PostContent;
use App\Services\UserComment;
use App\Services\UserLike;
use App\Services\UserNotification;
use App\Services\UserPost;
use App\Services\UserProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
    public function index()
    {
        $id = request('id') ?? Auth::id();
        $userDetail = $this->userProfile->getUser($id);
        $connectedUsers = $this->userProfile->getOtherUsers(Auth::id() ?? $id);
        return view('home', compact('userDetail', 'connectedUsers'));
    }

    

    public function publishPost(Request $request): JsonResponse
    {
        $this->authorize('create', Post::class);
        return $this->myPost->uploadContent($request);
    }

    public function getUserWithRolesAndPermissions(): JsonResponse
    {
        return $this->userProfile->getUserRolesAndPermissions();
    }

    public function createComment(Request $request): JsonResponse
    {
        $this->authorize('create', Comment::class);
        return $this->comments->createComment($request);
    }

    public function getPosts(): JsonResponse
    {
        return $this->myPost->getPosts();
    }

    public function editUserProfile(Request $request): JsonResponse
    {
        return $this->userProfile->updateUserProfile($request);
    }

    public function editPost(Request $request, $id): JsonResponse
    {
        $post = Post::findOrFail($id);
        $this->authorize('update', $post);
        return $this->myPost->editPost($request, $id);
    }

    public function editComment(Request $request, $id): JsonResponse
    {
        $comment = Comment::findOrFail($id);
        $this->authorize('update', $comment);
        return $this->comments->updateComment($request, $id);
    }

    public function deleteComment($id): JsonResponse
    {
        $comment = Comment::findOrFail($id);
        $this->authorize('delete', $comment);
        return $this->comments->deleteComment($id);
    }

    public function deletePost(Request $request, $id): JsonResponse
    {
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);
        return $this->myPost->deletePost($request, $id);
    }

    public function likeUnlikePost(Request $request, $id): JsonResponse
    {
        return $this->likes->likeUnlikePost($request, $id);
    }

    public function likeUnlikeComment($id): JsonResponse
    {
        return $this->likes->likeUnlikeComment($id);
    }

    public function markAllRead(): JsonResponse
    {
        return $this->notification->markAsRead();
    }

    public function userDetail(string $id)
    {
        $userDetail = $this->userProfile->userDetail($id);
        $connectedUsers = $this->userProfile->getOtherUsers(Auth::id() ?? $id);
        return view('user-posts', compact('userDetail', 'connectedUsers'));
    }

}
