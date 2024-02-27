<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Notifications\UserPostReactionNotification;
use App\Traits\ajaxResponse;
use App\Traits\handleNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserLike
{
    use ajaxResponse, handleNotification;

    public function likeUnlikePost($request, $postId)
    {
        try {
            $post = Post::find($postId);
            if (! $post) {
                return $this->jsonResponse('error', 404, 'The post was not found!',  null);
            }
    
            $like =  $post->likes()->where('user_id', Auth::id())->first();
            
            if ($like) {
                $type = 'unliked';
                $content = "👎🏾👎🏾";
                $like->delete();
            }else{
                $type = 'liked';
                $content = "👍🏾👍🏾";
                
                $result = new Like([
                    'user_id' => Auth::id(),
                    'post_id' => $post->id
                ]);
                $result->likeable()->associate($post);
                $result->save();
            }
            $data = [
                'user_id' => $post->user_id,
                'post_id' => $post->id
            ];
            $this->storeNotification($data);
            $likedAt = Carbon::parse($result->created_at ?? Carbon::now())->diffForHumans();
            $user = User::find($post->user_id);
            $user->notify(new UserPostReactionNotification(Auth::user()->name, $user->email, $type, $likedAt , $content, $post->user_id));
            return $this->jsonResponse('success', 200, 'Post liked',  null);
        } catch (\Throwable $th) {
            return $this->jsonResponse('error', 500, 'A server error occurred. Please contact admin', $th->getMessage());
        }
    }

    public function likeUnlikeComment($commentId)
    {
        try {
            $comment = Comment::find($commentId);
            $user = User::find(Auth::id());
            if ((! $comment) || (! $user)) {
                return $this->jsonResponse('error', 404, 'The comment or user was not found!',  null);
            }
    
            if ($user->likedComments()->wherePivot('comment_id', $commentId)->exists()) {
               $user->likedComments()->detach($comment);

                return $this->jsonResponse('success', 200, 'Comment unliked',  null);
            }else{
                $user->likedComments()->attach($comment);
                return $this->jsonResponse('success', 200, 'Comment liked', null);
            }
            return $this->jsonResponse('error', 409, 'Failed to like or unlike comment',  null);
            
        } catch (\Throwable $th) {
            return $this->jsonResponse('error', 500, 'A server error occurred. Please contact admin', $th->getMessage());
        }
    }
}