 //Get all post 
 function fetchData(paginationUrl) {
    uri = `{{ route('fetch.posts') }}?user-posts=${idFromUrl}`;
    $.ajax({
        url: paginationUrl || `{{ route('fetch.posts') }}?user-posts=${idFromUrl}`,
        method: "GET",
        success: function(data) {
            const userProfilePic = data.data.user.profile_pic;
            $(".user-profile").attr("src", userProfilePic !== null ? `${userProfilePic}` : "assets/images/user/user-default.png");

            const posts = data.data.posts;
            console.log(data);
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

            const url =  window.location.href;
            const parts = url.split("/");
            const idFromUrl = parts[parts.length - 1];