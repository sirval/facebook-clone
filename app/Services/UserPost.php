<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use App\Traits\ajaxResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserPost
{
    use ajaxResponse;

    protected $fileUpload;
    public function __construct(FileUpload $fileUpload)
    {
        $this->fileUpload = $fileUpload;
    }
    private function validatePost($request)
    {
        $rules = [
            'fileInput.*' => 'nullable|file|mimes:jpeg,jpg,png,mp4|max:1024', //1 MegaByte file size allowed
            //ALEX will knock down any url type like the Israeli Iron Dome, so bad 😫 but chill ☕ it's just to show validation at work
            'post_content' => ['required', 'string', function ($attribute, $value, $fail) {
                if (preg_match('/\b(?:https?|ftp):\/\/\S+|\bwww\.\S+/i', $value)) {
                    $fail('The :attribute field should not contain URLs.');
                }
            }],

        ];
        //Gracefully handle errors
        $messages = [
            'fileInput.*.max' => 'Each file shouldn\'t exceed 1MB.',
            'fileInput.*.mimes' => 'Only JPEG, JPG, PNG, or MP4 files are allowed.',
            'post_content' => 'The post content should not contain URLs.',
            'post_content.required' => 'Post is required',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = implode(' ', $validator->errors()->all());
            return [
                'response' => 'error',
                'message' => $errors
            ];
        }else {
            return [
                'response' => 'success',
            ];
        }
    }
    public function uploadContent($request)
    {
        try {
            $validator = $this->validatePost($request);
            if($validator['response'] == 'error'){
                return $this->jsonResponse('error', 409, $validator['message']);
            }
    
            $post = Post::create([
                'content' => $request->post_content,
                'user_id' => Auth::id(),
            ]);
           
            $success = 0;
            if ($request->hasFile('fileInput')) {
                $responses = $this->fileUpload->postMediaUpload($request, 'uploads');
                if ($responses == false) {
                    $post->forceDelete();
                    return $this->jsonResponse('error', 500, 'An error occurred while uploading file(s). You my wish to check your internet connectivity!');
                }
                $data = [];
                foreach ($responses as $response) {
                    $data[] = [
                        'filepath' => $response['filepath'],
                        'post_id' => $post->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                //create post with postMedia relationship
                $post->postMedia()->insert($data);
                $success = 1;
            }
            if ($success == 1) {
                return $this->jsonResponse('success', 200, 'Your post was successful',  $responses);
            }
    
            return $this->jsonResponse('success', 200, 'Your post without media file was successful', null);
            
        } catch (\Throwable $th) {
           return $this->jsonResponse('error', 500, 'A server error occurred. Please contact admin', $th->getMessage());
        }
        
    }

    public function getPosts()
    {
        try {
            $userId = request('user-posts');
            
            if ($userId && $userId != "") {
                $posts = Post::with(['comments' => function ($comments) use ($userId){
                    $comments->with('user:id,name,profile_pic')
                            ->where('user_id', $userId);
                }, 'likes' => function($like) {
                    $like->with('user:id,name');
                }, 
                'notifications' => function ($notification) {
                    $notification->with('user:id,name,profile_pic,created_at')
                    ->where('is_read', 0)->take(4);
                },
                'postMedia', 'user'])
                            ->orderBy('created_at', 'desc')
                            ->where('user_id', $userId)
                            ->paginate(3);
            }else{
                $posts = Post::with(['comments' => function ($comments) {
                    $comments->with('user:id,name,profile_pic', 'likers');
                }, 'likes' => function($like) {
                    $like->with('user:id,name');
                }, 
                'notifications' => function ($notification) {
                    $notification->with('user:id,name,profile_pic,created_at')
                    ->where('is_read', 0)->take(4);
                },
                'postMedia', 'user'])
                            ->orderBy('created_at', 'desc')
                            ->paginate(3);
            }
           
            $unreadNotificationsCount = 0;

            foreach ($posts as $post) {
                $unreadNotificationsCount += $post->notifications
                    ->where('is_read', 0)
                    ->count();
            }
           
            return $this->jsonResponse('success', 200, 'Posts retrieved successfully',  ['posts' => $posts, 'notificationCount' => $unreadNotificationsCount, 'user' => Auth::user()]);
        } catch (\Throwable $th) {
           return $this->jsonResponse('error', 500, 'A server error occurred. Please contact admin', $th->getMessage());
        }
        
    }

    public function editPost($request, $id)
    {
        try {
            $validator = $this->validatePost($request);
            if($validator['response'] == 'error'){
                return $this->jsonResponse('error', 409, $validator['message']);
            }
            $post = Post::find($id);
            if (! $post) {
                return $this->jsonResponse('error', 404, 'Post not found!', null);
            }
            $post->content = $request->post_content;
            
            if ($request->hasFile('fileInput')) {
                $responses = $this->fileUpload->postMediaUpload($request, 'uploads');
                if ($responses == false) {
                    return $this->jsonResponse('error', 500, 'An error occurred while uploading file(s). You my wish to check your internet connectivity!');
                }
                $post->save();
                $data = [];
                foreach ($responses as $response) {
                    $data[] = [
                        'filepath' => $response['filepath'],
                        'post_id' => $post->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                $oldPostMedia = $post->postMedia()->pluck('filepath')->toArray();
                $this->fileUpload->deleteFile($oldPostMedia);
                $post->postMedia()->delete();
                //create post with postMedia relationship
                $post->postMedia()->createMany($data);
            }else{
                $post->save();
            }
            return $this->jsonResponse('success', 200, 'Post edited successfully',  null);
        } catch (\Throwable $th) {
            return $this->jsonResponse('error', 500, 'A server error occurred. Please contact admin', $th->getMessage());
        }
    }

    public function deletePost($request, $id)
    {
        try {
            $post = Post::find($id);
            if ($post) {
                $post->delete();
                return $this->jsonResponse('success', 200, 'Post deleted successfully',  null);
            }
            return $this->jsonResponse('success', 404, 'Post not found',  null);
        } catch (\Throwable $th) {
            return $this->jsonResponse('error', 500, 'A server error occurred. Please contact admin', $th->getMessage());
        }
    }

}