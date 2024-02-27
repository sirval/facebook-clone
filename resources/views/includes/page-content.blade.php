<div class="content-page-box-area mt-4">
    <div class="row">
        <div class="col-lg-3 col-md-12">
            <aside class="widget-area">
                <div class="widget widget-view-profile">
                    <div class="profile-box d-flex justify-content-between align-items-center">
                        <a href="#">
                            @if($userDetail->profile_pic)
                                <img src="{{ $userDetail->profile_pic }}" alt="{{ $userDetail->name }}">
                            @else
                                <img src="{{ asset('assets/images/user/user-default.png') }}" alt="{{ $userDetail->name }}">
                            @endif
                        </a>
                        <div class="text ms-2">
                            @if (auth()->id() == $userDetail->id)
                                <div class="dropdown text-end">
                                    <button class="dropdown-toggle btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="flaticon-menu" style="font-size: 20px;"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#editUserModal" href="#"><i class="flaticon-edit me-2"></i>Edit User</a></li>
                                        <li><a class="dropdown-item d-flex align-items-center" href="{{ route('password.request') }}"><i class="flaticon-edit me-2"></i>Change Password</a></li>
                                    </ul>
                                </div> 
                            @endif
                            
                            <h3><a href="#">{{ $userDetail->name }}</a></h3>
                            
                            <span>{{ $userDetail->email }}</span>
                            @foreach ($userDetail->roles as $role)
                            <span style="display: none" id="user-role">{{ $role->name }}</span>
                            @endforeach
                             
                        </div>
                    </div>
                    
                    <div class="profile-btn">
                        <a href="{{ route('user.profile', $userDetail->id) }}" class="default-btn">View Profile</a>
                    </div>
                </div>
               
            </aside>
        </div>
        
        <div class="col-lg-6 col-md-12">
            <div class="news-feed-area">
                @php
                    $route = Route::current()->getName();
                @endphp
                @if ($route !== 'user.profile')
                    <div class="news-feed news-feed-form">
                        <h3 class="news-feed-title">Create New Post</h3>

                        <form id="postForm" enctype="multipart/form-data">
                            <div class="form-group">
                                <textarea name="post_content" id="post_content" class="form-control" placeholder="Write something here..."></textarea>
                            </div>
                            <div id="preview" class="file-previews mt-4"></div>
                            <ul class="button-group d-flex justify-content-between align-items-center">
                                <li class="photo-btn">
                                    <label for="fileInput" class="file-label">
                                        <i class="flaticon-gallery"></i> Photo/Video
                                    </label>
                                    <input type="file" id="fileInput" name="fileInput[]" accept="image/*,video/*" multiple>
                                </li>
                                <li class="post-btn">
                                    <button type="submit" onclick="uploadFiles(event)">Publish</button>
                                </li>
                            </ul>
                        </form>
                        <div class="progress"  style="display: none;">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    
                @endif
                    
                <div class="news-feed news-feed-post">
                    {{-- post header  --}}
                    {{-- This will be loaded by ALEX js chill  --}}
                    <div id="news-feed-content"></div>
                    

                    <form id="reply-form-comment-id" class="post-footer reply-form" style="display:none">
                        <div class="footer-image">
                            <a href="#"><img src="{{ asset('assets/images/user/user-default.png') }}" class="rounded-circle" alt="image"></a>
                        </div>
                        <div class="form-group">
                            
                            <textarea name="comment" class="form-control reply-content" placeholder="Write a comment..."></textarea>
                            <label><button class="submit-reply" style="background-color: #2E3AB9; border-radius: 5px; border: none; color: #F4F7FC" type="submit">Send</button></label>
                        </div>
                    </form>
                </div>
                <div class="load-more-posts-btn" id="paginate">
                    {{-- Pagination  --}}
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-12">
            <aside class="widget-area">
                <div class="widget widget-weather">
                    <div class="weather-image">
                        <a href="#"><img src="{{ asset('assets/images/weather/weather.jpg') }}" alt="image"></a>
                    </div>
                </div>
               
            </aside>
        </div>
    </div>
</div>