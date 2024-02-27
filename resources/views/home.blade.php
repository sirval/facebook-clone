@extends('layouts.app')
@section('css')
     <!-- Links of CSS files -->
     <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/simplebar.min.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/metismenu.min.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
@endsection
@include('includes.preloader')
@section('content')
    <div class="main-content-wrapper d-flex flex-column">
        @include('includes.navbar')
        @include('includes.leftsidebar')
        @include('includes.modals')
        @include('includes.page-content')
        @include('includes.rightsidebar')
        {{-- @include('includes.footer') --}}
        @include('includes.scroll-to-top')
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/metismenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            const userProfileRoute = "{{ route('user.profile', '') }}";
            const editPostRoute = "{{ route('edit.post', '') }}";
            const deletePostRoute = "{{ route('delete.post', '') }}";

            const editCommentRoute = "{{ route('edit.comment', '') }}";
            const deleteCommentRoute = "{{ route('delete.comment', '') }}";

            const likeUnlikeRoute = "{{ route('like.unlike', '', '') }}";
            const likeUnlikeComment = "{{ route('like.comment', '', '') }}";
            const authId = '{{auth()->user()->id }}'
            const userRole = $('#user-role').text();
            

            $('#fileInput').on('change', function() {
                const files = this.files;
                const preview = $('#preview');
                preview.empty();
                
                if (files.length > 6) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops ...',
                        text: 'You can select a maximum of 6 files.'
                    }); 
                    return;
                }
    
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();
    
                    reader.onload = function(e) {
                        const fileType = file.type.split('/')[0]; // get image or video
                        const mediaElement = $('<' + (fileType === 'image' ? 'img' : 'video') + '>');
                        mediaElement.attr('src', e.target.result);
                        mediaElement.attr('controls', ''); // Add control attribute to video element
                        mediaElement.addClass('file-preview');
    
                        // Remove icon
                        const removeIcon = $('<span>❌</span>');
                        removeIcon.addClass('remove-icon');
                        removeIcon.on('click', function() {
                            $(this).parent().remove();
                        });
    
                        // align preview and remove icon in a div container
                        const fileContainer = $('<div></div>');
                        fileContainer.addClass('file-container');
                        fileContainer.append(mediaElement);
                        fileContainer.append(removeIcon);
    
                        preview.append(fileContainer);
                    };
    
                    reader.readAsDataURL(file);
                }
            });

            $('#fileProfile').on('change', function() {
                const files = this.files;
                const preview = $('#preview-profile');
                preview.empty();
                
                if (files.length != 1) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops ...',
                        text: 'Select only one file.'
                    }); 
                    return;
                }
    
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();
    
                    reader.onload = function(e) {
                        const fileType = file.type.split('/')[0]; // get image or video
                        if (fileType !== 'image') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops ...',
                                text: 'Please select a valid image'
                            }); 
                            return; 
                        }
                        const mediaElement = $('<img>');
                        mediaElement.attr('src', e.target.result);
                        mediaElement.addClass('file-preview');
    
                        // Remove icon
                        const removeIcon = $('<span>❌</span>');
                        removeIcon.addClass('remove-icon');
                        removeIcon.on('click', function() {
                            $(this).parent().remove();
                        });
    
                        // align preview and remove icon in a div container
                        const fileContainer = $('<div></div>');
                        fileContainer.addClass('file-container');
                        fileContainer.append(mediaElement);
                        fileContainer.append(removeIcon);
    
                        preview.append(fileContainer);
                    };
    
                    reader.readAsDataURL(file);
                }
            });

            $('#fileEditPost').on('change', function() {
                const files = this.files;
                const preview = $('#preview-edit-post');
                preview.empty();
                
                if (files.length > 6) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops ...',
                        text: 'Select only six files.'
                    }); 
                    return;
                }
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();
    
                    reader.onload = function(e) {
                        const fileType = file.type.split('/')[0]; // get image or video
                        const mediaElement = $('<' + (fileType === 'image' ? 'img' : 'video') + '>');
                        mediaElement.attr('src', e.target.result);
                        mediaElement.attr('controls', ''); // Add control attribute to video element
                        mediaElement.addClass('file-preview');
    
                        // Remove icon
                        const removeIcon = $('<span>❌</span>');
                        removeIcon.addClass('remove-icon');
                        removeIcon.on('click', function() {
                            $(this).parent().remove();
                        });
    
                        // align preview and remove icon in a div container
                        const fileContainer = $('<div></div>');
                        fileContainer.addClass('file-container');
                        fileContainer.append(mediaElement);
                        fileContainer.append(removeIcon);
    
                        preview.append(fileContainer);
                    };
    
                    reader.readAsDataURL(file);
                }
                
            });

            function showAlert(text = 'Error', icon = 'error', title = 'Oops ...')
            {
                Swal.fire({
                    icon: icon,
                    title: title,
                    text: text
                });
            }
    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer ' + '{{ auth()->user()->api_token }}'
                }
            });

            $('#postForm').on('submit', function(event) {
                event.preventDefault();
                $('.progress').show();
                const formData = new FormData($(this)[0]);

                $.ajax({
                    //Handle post progress bar
                    xhr: function() {
                        const xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(event) {
                            if (event.lengthComputable) {
                                const progressCompletion = (event.loaded / event.total) * 100;
                                const reducedProgressCompletion = progressCompletion / 5;
                                $('.progress-bar').css('width', reducedProgressCompletion + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    url: "{{ route('publish.post') }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 'success') {
                            $('.progress').hide();
                            $('#post_content').val('');
                            $('#preview').empty();
                            showAlert(data.message, 'success', 'Success');
                            fetchData();
                        }else {
                            $('.progress').hide();
                            showAlert(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('.progress').hide();
                        $('#post_content').val('');
                        $('#preview').empty();
                        if (xhr.status === 413) {
                            showAlert('The content size is too large! 1MB expected');
                        }else {
                            showAlert('We couldn\t handle your request at the moment. Try again later!');
                        }
                       
                    }
                });
            });

            //comment event handler
            $(document).on('submit', 'form[id^="commentForm-"]', function(event) {
                event.preventDefault();
                const formData = new FormData($(this)[0]);

                $.ajax({
                    url: "{{ route('comment.post') }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 'success') {
                            $('.progress').hide();
                            $('#comment').val('');
                            showAlert(data.message, 'success', 'Success');
                            fetchData();
                        }else {
                            showAlert(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#comment').val('');
                        showAlert('We couldn\t handle your request at the moment. Try again later!');
                    }
                });
            });

            //Like and Unlike post
            $(document).on('click', '.post-like', function() {
                let postId = $(this).data('post-id');
                $.ajax({
                    url: `${likeUnlikeRoute}/${postId}`,
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 'success') {
                            fetchData();
                        }else {
                            showAlert(data.message)
                        }
                    },
                    error: function(xhr, status, error) {
                        showAlert('We couldn\t handle your request at the moment. Try again later!')
                    }
                });
            });

            //update user profile
            $('#editUserForm').on('submit', function(event) {
                event.preventDefault();
                // $('.progress').hide();
                const formData = new FormData($(this)[0]);

                $.ajax({
                    url: "{{ route('edit.user') }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 'success') {
                            $('#name').val('');
                            $('#preview-profile').empty();
                            showAlert(data.message, 'success', 'Success');
                            $('#editUserModal').modal('hide');
                            fetchData();
                        }else {
                            showAlert(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#name').val('');
                        $('#preview-profile').empty();
                        if (xhr.status === 413) {
                            showAlert('The content size is too large! 1MB expected');
                        }else {
                            showAlert('We couldn\t handle your request at the moment. Try again later!');
                        }
                       
                    }
                });
            });

            //update post
            $('#editPostForm').on('submit', function(event) {
                event.preventDefault();
                $('#editProgress').show();
                let formData = new FormData($(this)[0]);
                formData.append('_method', 'PATCH');
                let post_id = $('#edit-post-id').val();
               
                $.ajax({
                    url: `${editPostRoute}/${post_id}`,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 'success') {
                            $('#editProgress').hide();
                            $('#editPostModal').modal('hide');
                            showAlert(data.message, 'success', 'Update Successful');
                            fetchData();
                        }else {
                            $('#editProgress').hide();
                            showAlert(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#editProgress').hide();
                        $('#edit_post_content').val('');
                        $('#preview-edit-post').empty();
                        if (xhr.status === 413) {
                            showAlert('The content size is too large! 1MB expected');
                        }else {
                            showAlert('We couldn\t handle your request at the moment. Try again later!');
                        }
                       
                    }
                });
            });

            //delete post
            $('#deletePostForm').on('submit', function(event) {
                event.preventDefault();
                let formData = new FormData($(this)[0]);
                formData.append('_method', 'DELETE');
                let post_id = $('#delete-post-id').val();
               
                $.ajax({
                    url: `${deletePostRoute}/${post_id}`,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 'success') {
                            $('#deletePostModal').modal('hide');
                            $('#fileInput').val('');
                            showAlert(data.message, 'success', 'success');
                            fetchData();
                        }else {
                            showAlert(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        showAlert('Action not allowed', 'error', 'error');
                        console.error(error);
                    }
                });
            });

             //update post
             $('#editCommentForm').on('submit', function(event) {
                event.preventDefault();
                let formData = new FormData($(this)[0]);
                formData.append('_method', 'PATCH');
                let comment_id = $('#edit-comment-id').val();
               
                $.ajax({
                    url: `${editCommentRoute}/${comment_id}`,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 'success') {
                            $('#editCommentModal').modal('hide');
                            showAlert(data.message, 'success', 'Update Successful');
                            fetchData();
                        }else {
                            showAlert(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#edit_comment_content').val('');
                        if (xhr.status === 413) {
                            showAlert('The content size is too large! 1MB expected');
                        }else {
                            showAlert('We couldn\t handle your request at the moment. Try again later!');
                        }
                       
                    }
                });
            });

            //delete comment
            $('#deleteCommentForm').on('submit', function(event) {
                event.preventDefault();
                let formData = new FormData($(this)[0]);
                formData.append('_method', 'DELETE');
                let comment_id = $('#delete-comment-id').val();
               
                $.ajax({
                    url: `${deleteCommentRoute}/${comment_id}`,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 'success') {
                            $('#deleteCommentModal').modal('hide');
                            showAlert(data.message, 'success', 'success');
                            fetchData();
                        }else {
                            showAlert(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        showAlert('Action not allowed', 'error', 'error');
                        console.error(error);
                    }
                });
            });

            //Like and Unlike comment
            $(document).on('click', '.comment-like', function() {
                let commentId = $(this).data('comment-id');
                $.ajax({
                    url: `${likeUnlikeComment}/${commentId}`,
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 'success') {
                            fetchData();
                        }else {
                            showAlert(data.message)
                        }
                    },
                    error: function(xhr, status, error) {
                        showAlert('We couldn\t handle your request at the moment. Try again later!')
                    }
                });
            });


            //mark notification as read
            $('#mark-read').on('click', function() {
                $.ajax({
                    url: "{{ route('notification.read') }}",
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 'success') {
                            fetchData();
                        }else {
                            showAlert(data.message)
                        }
                    },
                    error: function(xhr, status, error) {
                        showAlert('We couldn\t handle your request at the moment. Try again later!')
                    }
                });
            });

            //popup edit post modal with each post id
            $('#news-feed-content').on('click', '.post-edit-button', function() {
                let postId = $(this).data('post-id');
                let postContent = $(this).data('post-content');
                $('#edit-post-id').val(postId);
                $('#edit_post_content').val(postContent);
                $('#editPostModal').modal('show');
            });

            //popup delete post modal with each post id
            $('#news-feed-content').on('click', '.post-delete-button', function() {
                let postId = $(this).data('post-id');
                $('#delete-post-id').val(postId);
                $('#deletePostModal').modal('show');
            });

            //popup edit post modal with each post id
            $('#news-feed-content').on('click', '.comment-edit-button', function() {
                let postId = $(this).data('post-id');
                let commmentId = $(this).data('comment-id');
                let commentContent = $(this).data('comment-content');
                $('#edit-post-comment-id').val(postId);
                $('#edit-comment-id').val(commmentId);
                $('#edit_comment_content').val(commentContent);
                $('#editCommentModal').modal('show');
            });

            //popup delete post modal with each post id
            $('#news-feed-content').on('click', '.comment-delete-button', function() {
                let postId = $(this).data('post-id');
                let commentId = $(this).data('comment-id');
                $('#delete-post-comment-id').val(postId);
                $('#delete-comment-id').val(commentId);
                $('#deleteCommentModal').modal('show');
            });


            //Get all post 
            function fetchData(url) {
                $.ajax({
                    url: url || "{{ route('fetch.posts') }}",
                    method: "GET",
                    success: function(data) {
                        const userProfilePic = data.data.user.profile_pic;
                       
                        const posts = data.data.posts;
                        const notification = data.data.notificationCount;
                       
                        if (posts.data.length > 0) {
                            displayView(posts, notification);
                        }else {
                            $('#news-feed-content').html('No Post Available');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching posts:', xhr.status, error);
                    }
                });
            }

            //display posts 
            function displayView(postsData, notificationCounter)
            {
                $('#news-feed-content').empty();
                $('#paginate').empty();
                const postsContainer = $('#news-feed-content');
                const posts = postsData.data;
                posts.forEach(post => {
                    if (authId == post.user_id) {
                        $('#notification-counter').text(notificationCounter);
                    }else{
                        $('#notification-counter').text(0);

                    }
                    let postView = `
                        <div class="post-header d-flex justify-content-between align-items-center mb-4">
                            <div class="image">
                                <a href="${userProfileRoute}/${post.user.id}"><img src="${post.user.profile_pic ? post.user.profile_pic : 'assets/images/user/user-post-default.png'}" class="rounded-circle" alt="image"></a>
                            </div>
                            <div class="info ms-3">
                                <span class="name"><a href="${userProfileRoute}/${post.user.id}">${post.user.name}</a></span>
                                <span class="small-text"><a href="#">${post.created_at}</a></span>
                            </div>
                            ${authId == post.user_id || userRole == 'admin' ? `
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flaticon-menu"></i></button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center post-edit-button" data-bs-toggle="modal" data-post-id="${post.id}" data-post-content="${post.content}" href="#editPostModal">
                                            <i class="flaticon-edit"></i> Edit Post
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center post-delete-button" data-bs-toggle="modal" data-post-id="${post.id}" data-post-content="${post.content}" href="#deletePostModal">
                                            <i class="flaticon-trash"></i> Delete Post
                                        </a>
                                    </li>
                                </ul>
                            </div>` : ''}
                        </div>

                        <div class="post-body">
                            <p>${post.content == null ? '...' : post.content}</p>
                            <div class="post-image">
                                ${post.post_media.map(media => 
                                    media.filepath.toLowerCase().endsWith('.mp4') 
                                        ? `<video src="${media.filepath}" controls style="padding: 5px;"></video>`
                                        : `<img src="${media.filepath}" alt="image" style="padding: 5px;">`
                                ).join('')}
                            </div>
                        
                            <ul class="post-meta-wrap d-flex justify-content-between align-items-center mb-4">
                                <li class="post-react post-like" data-post-id="${post.id}">
                                    <i style="cursor: pointer;" class="flaticon-like"></i><span>Like</span> <span class="number">${post.likes.length} </span>
                                </li>
                                <li class="post-comment" id="post-comment-${post.id}">
                                    <i style="cursor: pointer;" class="flaticon-comment"></i><span>Comment</span> <span class="number">${post.comments.length} </span>
                                </li>
                               
                            </ul>
                        
                        `;
                        post.comments.forEach(comment => {
                       postView += `
                        <div class="post-comment-list" id="post-comment-list-${post.id}">
                            <div class="comment-list" style="display:none">
                                <div class="comment-image">
                                    <a href="${userProfileRoute}/${comment.user.id}"><img src="${comment.user.profile_pic ? comment.user.profile_pic : 'assets/images/user/user-default.png'}" class="rounded-circle" alt="${comment.user.name +'image'}"></a>
                                </div>
                                <div class="comment-info">
                                    <div class="d-flex justify-content-between">
                                        <h3>
                                            <a href="${userProfileRoute}/${comment.user.id}">${comment.user.name}</a>
                                        </h3>
                                        ${authId == comment.user.id || userRole == 'admin' ? `
                                        <div class="dropdown">
                                            <button class="dropdown-toggle btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="flaticon-menu"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end border-0" style="background: transparent;">
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center comment-edit-button" data-bs-toggle="modal" data-post-id="${post.id}"  data-comment-id="${comment.id}" data-comment-content="${comment.content}" href="#editCommentModal">
                                                        <i class="flaticon-edit"> </i> Edit Comment
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center comment-delete-button" data-bs-toggle="modal" data-post-id="${post.id}" data-comment-id="${comment.id}" href="#deleteCommentModal">
                                                        <i class="flaticon-trash"> </i> Delete Comment
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>` : ''}
                                    </div>
                                    <span>${comment.created_at}</span>
                                    <p>${comment.content}</p>
                                    <ul class="comment-react">
                                        <li><span style="cursor: pointer" class="like comment-like" data-comment-id="${comment.id}">Like (${comment.likers.length})</span></li>
                                    </ul> 
                                </div>

                            </div> 
                        
                            `;
                      
                            });
                            postView += ` 
                            <form id="commentForm-${post.id}" class="post-footer" style="display:none">
                                <div class="footer-image">
                                    <a href="#"><img src="${post.user.profile_pic ? post.user.profile_pic : 'assets/images/user/user-post-default.png'}" class="rounded-circle" alt="image"></a>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" value="${post.id}" name="post_id" />
                                    <textarea name="comment" class="form-control" placeholder="Write a comment..."></textarea>
                                    <label><button style="background-color: #2E3AB9; border-radius: 5px; border: none; color: #F4F7FC" type="submit">Send</button></label>
                                </div>
                            </form>
                        </div>
                    </div>
                    `;
                    
                    post.notifications.forEach(notification => {
                       
                        if (post.notifications.length > 0) {
                            if (authId == post.user_id) {
                                $('#notification-dropdown').css('display', 'block');
                                
                                const notificationView = `
                                    <div class="item d-flex justify-content-between align-items-center">
                                        <div class="figure">
                                            <a href="#"><img src="${notification.user.profile_pic ? notification.user.profile_pic : 'assets/images/user/user-11.jpg'}" class="rounded-circle" alt="image"></a>
                                        </div>
                                        <div class="text">
                                            <h4><a href="#">${notification.user.name}</a></h4>
                                            <span>Reacted on your post</span>
                                            <span class="main-color">${notification.created_at}</span>
                                        </div>
                                    </div>
                                `;
                                $('#notifications-body').append(notificationView);
                            }
                           
                        }
                });    
                       
                   
                    postsContainer.append(postView);
                });
              
                //toggle each comment component
                posts.forEach(post => {
                    $(`#post-comment-${post.id}`).on('click', function(event) {
                        event.preventDefault();
                        const commentList = $(`#post-comment-list-${post.id} .comment-list`);
                        const commentForm = $(`#commentForm-${post.id}`);

                        // Check if there are comments
                        if (commentList.length > 0) {
                            commentList.toggle();
                            commentForm.toggle();
                        } else {
                            commentForm.toggle();
                        }
                    });
                });
                //Pagination view
                const paginationView = `
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            ${generatePaginationLinks(postsData)}
                        </ul>
                    </nav>
                `;
                $('#paginate').append(paginationView);
            }

            function generatePaginationLinks(postsData) {
                let linksHTML = '';

                if (postsData.links) {
                    postsData.links.forEach(link => {
                        if (link.url) {
                            linksHTML += `<li class="page-item ${link.active ? 'active' : ''}">
                                <a class="page-link" href="${link.url}">${link.label}</a>
                            </li>`;
                        } else {
                            linksHTML += `<li class="page-item disabled">
                                <span class="page-link">${link.label}</span>
                            </li>`;
                        }
                    });
                }

                return linksHTML;
            }

            function handlePaginationClick() {
                $('#paginate').on('click', '.page-link', function(event) {
                    event.preventDefault();
                    const url = $(this).attr('href');
                    fetchData(url);
                });
            }

           
            $('#news-feed-content').on('click', '.reply', function() {
                let $comment = $(this).closest('.comment-list');
                let $existingForm = $comment.find('.reply-form');
                  $existingForm.empty();

                if ($existingForm.length === 0) { 
                    let commentId = $comment.data('comment-id');
                    let postId = $comment.closest('.post-comment-list').attr('id').split('-')[3];
                    $(`#commentForm-${postId}`).hide();

                    let $replyForm = $('.reply-form').clone().show();
                    $replyForm.find('.comment-id').val(commentId);
                    $replyForm.find('.post-id').val(postId);

                    $comment.append($replyForm);
                }else{
                    $existingForm.toggle();
                }
            });


            fetchData();
            handlePaginationClick()

        });

        
    </script>
    
@endsection
