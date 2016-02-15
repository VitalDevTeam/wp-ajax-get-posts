jQuery(document).ready(function ($) {

    /**
     * Get posts
     * @param  {object} args    Object of get_post arguments
     */
    function ajaxGetPosts() {

        $.ajax({
            url: SiteInfo.ajax_url,
            type: 'post',
            data: {
                action: 'vital_ajax_get_posts',
                args: args
            },
            beforeSend: function() {
                console.log('Loading...');
            },
            success: function(posts) {
                console.log(posts);
            },
            error: function(response) {
                console.log(response);
            }

        });

    }

    // Example usage
    ajaxGetPosts({
        post_type: 'post',
        posts_per_page: -1,
        return_meta: true
    });
});