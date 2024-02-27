
    <!--Edit User Profile Modal-->
    <div class="modal fade" id="editUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editUserForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">Full name</label>
                            <input name="name" type="text" class="form-control" id="formGroupExampleInput" value="{{ auth()->user()->name }}" autofocus>
                        </div>
                        <div id="preview-profile" class="file-previews mt-4 mb-4"></div>
                            <div class="mb-3">
                                <div class="photo-btn">
                                    <label for="fileProfile" class="file-label">
                                        <i class="flaticon-gallery"></i> Profile Photo
                                    </label>
                                    <input type="file" id="fileProfile" name="fileInput" accept="image">
                                </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"  class="btn btn-primary" >
                        Update
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                
                </div>
            </form>
        </div>
        </div>
    </div>

    <!--Edit Post Modal-->
    <div class="modal fade" id="editPostModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editPostForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Post</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                
                    <div class="form-group">
                        <div class="mb-3">
                            <input type="hidden" id="edit-post-id">
                            <textarea name="post_content" id="edit_post_content" class="form-control" placeholder="Write something here..."></textarea>
                        </div>
                        <div id="preview-edit-post" class="file-previews mt-4 mb-4"></div>
                            <div class="mb-3">
                                <div class="photo-btn">
                                    <label for="fileEditPost" class="file-label">
                                        <i class="flaticon-gallery"></i> Profile Photo
                                    </label>
                                    <input type="file" id="fileEditPost" name="fileInput[]" accept="image/*,video/*" multiple>
                                </div>
                        </div>
                    </div>
                    <div id="editProgress" class="progress mt-2" style="display: none">
                        <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"  class="btn btn-primary" >
                        Update Post
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                
                </div>
            </form>
        </div>
        </div>
    </div>

     <!--Delete Post Modal-->
     <div class="modal fade" id="deletePostModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="deletePostForm">
                @csrf
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Post</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <input type="hidden" id="delete-post-id">
                <div class="modal-body">
                
                   <p>Are you sure?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit"  class="btn btn-danger" >
                        Yes
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                
                </div>
            </form>
        </div>
        </div>
    </div>

    {{-- Edit comment --}}
    <div class="modal fade" id="editCommentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editCommentForm">
                @csrf
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Comment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                
                    <div class="form-group">
                        <div class="mb-3">
                            <input type="hidden" id="edit-comment-id">
                            <textarea name="comment" id="edit_comment_content" class="form-control" placeholder="Write something here..."></textarea>
                        </div>
                       
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <button type="submit"  class="btn btn-primary" >
                        Update Comment
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                
                </div>
            </form>
        </div>
        </div>
    </div>

     <!--Delete comment Modal-->
     <div class="modal fade" id="deleteCommentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="deleteCommentForm">
                @csrf
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Comment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <input type="hidden" id="delete-comment-id">
                <div class="modal-body">
                
                   <p>Are you sure?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit"  class="btn btn-danger" >
                        Yes
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                
                </div>
            </form>
        </div>
        </div>
    </div>