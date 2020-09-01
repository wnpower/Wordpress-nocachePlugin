<?php
/**
 * Plugin Name: Add nocache
 * Description: Plugin para agregar ?nocache en el backend de Wordpress. Se utiliza en conjunto con Cloudflare Cache Everything para excluir del caché cuando un usuario está logueado.
 * Version:           1.0
 * Requires at least: 5.2
 * Author:            WNPower
 * Author URI:        https://www.wnpower.com/
 */

// https://wordpress.stackexchange.com/questions/4618/preserve-custom-url-parameter-on-more-pages

// Agregar nocache
function add_nocache($link) {
    $link = add_query_arg('nocache', '', $link);
    return $link;
}

// Sacar nocache
function remove_nocache($link) {
    $link = remove_query_arg('nocache/', $link);
    $link = remove_query_arg('nocache', $link);
    return $link;
}

add_action('init','do_redirect');
function do_redirect(){
    if(is_user_logged_in()) {
        
        /*
        // https://wordpress.stackexchange.com/questions/298965/change-admin-bar-visit-site-url
        add_action( 'admin_bar_menu', 'customize_my_wp_admin_bar', 80 );
        function customize_my_wp_admin_bar($wp_admin_bar) {
            $node = $wp_admin_bar->get_node('view-site');
            $node->href = add_nocache(get_home_url());
            $wp_admin_bar->add_node($node);
        }
        */
        
        // ADD QUERY STRING -->
        
        add_filter('home_url','add_nocache');
        //add_filter('site_url','add_my_query_var'); // Rompe el backend
        add_filter('admin_url','add_nocache');
        //add_filter('network_site_url','add_my_query_var');
        add_filter('network_home_url','add_nocache');
        add_filter('network_admin_url','add_nocache');
        
        /*
        // DISABLE QUERY STRING -->
        
        add_filter('page_link','remove_nocache');
        add_filter('post_link','remove_nocache');
        add_filter('term_link','remove_nocache');
        add_filter('tag_link','remove_nocache');
        add_filter('category_link','remove_nocache');
        add_filter('post_type_link','remove_nocache');
        add_filter('attachment_link','remove_nocache');
        add_filter('year_link','remove_nocache');
        add_filter('month_link','remove_nocache');
        add_filter('day_link','remove_nocache');
        add_filter('search_link','remove_nocache');
        
        add_filter('feed_link','remove_nocache');
        add_filter('post_comments_feed_link','remove_nocache');
        add_filter('author_feed_link','remove_nocache');
        add_filter('category_feed_link','remove_nocache');
        add_filter('taxonomy_feed_link','remove_nocache');
        add_filter('search_feed_link','remove_nocache');
        
        add_filter('get_edit_tag_link','remove_nocache');
        add_filter('get_edit_post_link','remove_nocache');
        add_filter('get_delete_post_link','remove_nocache');
        add_filter('get_edit_comment_link','remove_nocache');
        add_filter('get_edit_bookmark_link','remove_nocache');
        
        add_filter('index_rel_link','remove_nocache');
        add_filter('parent_post_rel_link','remove_nocache');
        add_filter('previous_post_rel_link','remove_nocache');
        add_filter('next_post_rel_link','remove_nocache');
        add_filter('start_post_rel_link','remove_nocache');
        add_filter('end_post_rel_link','remove_nocache');
        
        add_filter('previous_post_link','remove_nocache');
        add_filter('next_post_link','remove_nocache');
        
        add_filter('get_pagenum_link','remove_nocache');
        add_filter('get_comments_pagenum_link','remove_nocache');
        add_filter('shortcut_link','remove_nocache');
        add_filter('get_shortlink','remove_nocache');
        
        */


    } else if (isset($_GET['nocache']) || isset($_GET['nocache/'])) {
        $link = remove_query_arg('nocache/');
        $link = remove_query_arg('nocache', $link);
        wp_redirect($link, 301);
        exit();
    }
}

?>
