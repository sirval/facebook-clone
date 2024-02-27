<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ajaxResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserProfile
{
    use ajaxResponse;

    protected $fileUpload;
    public function __construct(FileUpload $fileUpload)
    {
        $this->fileUpload = $fileUpload;
    }

    public function getUser(string $id)
    {
        return User::find($id);
    }

    public function getUserRolesAndPermissions()
    {
        try {
            $userWithRoles = User::with(['roles' => function($roles) {
                $roles->with('permissions');
            }])->find(Auth::id());
            return $this->jsonResponse('success', 200, 'successful', $userWithRoles);
        } catch (\Throwable $th) {
            return $this->jsonResponse('error', 500, 'A server error occurred. Please contact admin', $th->getMessage());
        }
    }

    public function getOtherUsers(string $id)
    {
        return User::whereNot('id', $id)->get();
    }

    public function updateUserProfile($request) {
        try {
            $rules = [
                'fileProfile.*' => 'nullable|file|mimes:jpeg,jpg,png|max:1024', //1 MegaByte file size allowed
                'name' => ['required', 'string','min:2', function ($attribute, $value, $fail) {
                    if (preg_match('/\b(?:https?|ftp):\/\/\S+|\bwww\.\S+/i', $value)) {
                        $fail('The :attribute field should not contain URLs.');
                    }
                }],
    
            ];
            //Gracefully handle errors
            $messages = [
                'fileInput.*.max' => 'Each file shouldn\'t exceed 1MB.',
                'fileInput.*.mimes' => 'Only JPEG, JPG, or PNG files are allowed.',
                'name.*' => 'The name attribute should not contain URLs.',
                'name.*.min' => 'The name attribute should not be less than 2 characters.',
            ];
        
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $errors = implode(' ', $validator->errors()->all());
                return $this->jsonResponse('error', 409, $errors);
            }
            $user = User::find(Auth::id());
            if (! $user) {
                return $this->jsonResponse('error', 404, 'User not found!', null);
            }
            if ($request->hasFile('fileInput')) {
                $response = $this->fileUpload->postMediaUpload($request, 'uploads');
                if ($response == false) {
                    return $this->jsonResponse('error', 500, 'An error occurred while uploading file(s). You my wish to check your internet connectivity!');
                }
                if ($user->profile_pic) {
                    $this->fileUpload->deleteFile([$user->profile_pic]);
                }
                $user->name = $request->name;
                $user->profile_pic = $response[0]['filepath'];
                $user->save();
                return $this->jsonResponse('success', 200, 'Update successful. You may wish to refresh the page to sync your update',  null);
            }
            return $this->jsonResponse('error', 409, 'Something went wrong with your request. Check your input and try again later', null);
        } catch (\Throwable $th) {
            return $this->jsonResponse('error', 500, 'A server error occurred. Please contact admin', $th->getMessage());
        }
    }

    public function userDetail(string $id)
    {
        return User::whereId($id)->with(['posts' => function($query) {
            $query->with('postMedia', 'comments', 'likes');
        }])->first();
       
    }
}