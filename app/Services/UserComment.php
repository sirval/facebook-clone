<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\UserPostReactionNotification;
use Illuminate\Support\Facades\Validator;
use App\Traits\ajaxResponse;
use App\Traits\handleNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class UserComment
{
    use ajaxResponse, handleNotification;

    public function createComment($request)
    {
        $rules = [
            'post_id' => ['required'],
            //ALEX will knock down any url type like the Israeli Iron Dome, so bad 😫 but chill ☕ it's just to show validation at work
            'comment' => ['required', 'string', function ($attribute, $value, $fail) {
                if (preg_match('/\b(?:https?|ftp):\/\/\S+|\bwww\.\S+/i', $value)) {
                    $fail('The :attribute field should not contain URLs.');
                }
            }],

        ];
        //Gracefully handle errors
        $messages = [
            'comment' => 'Comment should not contain URLs.',
            'comment.required' => 'Comment is required.',
            'post_id.required' => 'Something went wrong. You should consider a page refresh!',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = implode(' ', $validator->errors()->all());
            return $this->jsonResponse('error', 409, $errors);
        }
        try {
            $post = Post::find($request->post_id);
            if ($post) {
                $comment = new Comment([
                    'content' => $request->comment,
                    'user_id' => Auth::id(),
                    'post_id' => $post->id,
                ]);
                $comment->commentable()->associate($post);
    
                $comment->save();
                $data = [
                    'user_id' => $post->user_id,
                    'post_id' => $post->id
                ];
                $this->storeNotification($data);
                $commentedAt = Carbon::parse($comment->created_at)->diffForHumans();
                $user = User::find($post->user_id);
                $type = 'comment';
                $user->notify(new UserPostReactionNotification(Auth::user()->name, $user->email, $type, $commentedAt ,$request->comment, $post->user_id));
               return $this->jsonResponse('success', 200, 'Comment successful',  null);
            }
            return $this->jsonResponse('error', 404, 'The post was not found!',  null);
        } catch (\Throwable $th) {
            return $this->jsonResponse('error', 500, 'A server error occurred. Please contact admin', $th->getMessage());
        }
    }

    public function updateComment($request, $id)
    {
        $rules = [
            //ALEX will knock down any url type like the Israeli Iron Dome, so bad 😫 but chill ☕ it's just to show validation at work
            'comment' => ['required', 'string', function ($attribute, $value, $fail) {
                if (preg_match('/\b(?:https?|ftp):\/\/\S+|\bwww\.\S+/i', $value)) {
                    $fail('The :attribute field should not contain URLs.');
                }
            }],

        ];
        //Gracefully handle errors
        $messages = [
            'comment' => 'Comment should not contain URLs.',
            'comment.required' => 'Comment is required.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = implode(' ', $validator->errors()->all());
            return $this->jsonResponse('error', 409, $errors);
        }
        try {
            $comment = Comment::find($id);
            if ($comment) {
                $comment->content = $request->comment;
                $comment->save();
               
                return $this->jsonResponse('success', 200, 'Comment update successful',  null);
            }
            return $this->jsonResponse('error', 404, 'The comment was not found!',  null);
        } catch (\Throwable $th) {
            return $this->jsonResponse('error', 500, 'A server error occurred. Please contact admin', $th->getMessage());
        }
    }


    public function deleteComment($id)
    {
        try {
            $comment = Comment::find($id);
            if ($comment) {
                $comment->delete();
                return $this->jsonResponse('success', 200, 'Comment deleted successfully',  null);
            }
            return $this->jsonResponse('success', 404, 'Comment not found',  null);
        } catch (\Throwable $th) {
            return $this->jsonResponse('error', 500, 'A server error occurred. Please contact admin', $th->getMessage());
        }
    }
}