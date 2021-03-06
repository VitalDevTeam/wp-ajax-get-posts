<?php
/**
 * Enqueue your JS
 */
function vital_enqueuer() {

    wp_enqueue_script(
        'ajax_get_posts',
        get_template_directory_uri() . '/assets/scripts/site/ajax-get-posts.js',
        array('jquery'),
        filemtime(get_template_directory() . '/assets/scripts/site/ajax-get-posts.js'),
        true
    );

    // Localize AJAX URL for use in your script
    $site_info = array(
        'ajax_url' => admin_url('admin-ajax.php')
    );
    wp_localize_script('ajax_get_posts', 'SiteInfo', $site_info);

}

add_action('wp_enqueue_scripts', 'vital_enqueuer');

/**
 * AJAX get posts handler
 * @return object Posts
 */
function vital_ajax_get_posts() {
    $args = $_GET['args'];

    // Get posts
    $posts = get_posts(array(
        'posts_per_page'  => $args['posts_per_page'],
        'post_type'       => $args['post_type'],
    ));

    if ($posts) {

        // Get all post meta and add to the object if
        // the return_meta option is true
        if ($args['return_meta'] === 'true') {
            foreach ($posts as $post) {
                $post_meta = get_post_meta($post->ID);
                $post->post_meta = $post_meta;
            }
        }

        wp_send_json($posts);

    } else {
        return wp_send_json_error('No posts were returned.');
    }

    wp_die();
}
add_action('wp_ajax_nopriv_vital_ajax_get_posts', 'vital_ajax_get_posts');
add_action('wp_ajax_vital_ajax_get_posts', 'vital_ajax_get_posts');
