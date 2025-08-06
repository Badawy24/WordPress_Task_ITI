
<?php
/*
Plugin Name: Portfolio 
Description: Custom Post Type for Projects with custom fields.
Version: 1.0
Author: Badawy
*/

if (!defined('ABSPATH')) exit;

function pp_register_projects_cpt() {
    $labels = [
        'name' => 'Projects',
        'singular_name' => 'Project',
        'add_new' => 'Add New Project',
        'add_new_item' => 'Add New Project',
        'edit_item' => 'Edit Project',
        'new_item' => 'New Project',
        'view_item' => 'View Project',
        'search_items' => 'Search Projects',
        'not_found' => 'No Projects found',
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => ['title', 'editor', 'thumbnail'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'projects'],
    ];

    register_post_type('projects', $args);
}
add_action('init', 'pp_register_projects_cpt');

function pp_add_project_meta_boxes() {
    add_meta_box('pp_project_details', 'Project Details', 'pp_project_meta_box_callback', 'projects', 'normal', 'high');
}
add_action('add_meta_boxes', 'pp_add_project_meta_boxes');

function pp_project_meta_box_callback($post) {
    $client = get_post_meta($post->ID, '_pp_client', true);
    $url = get_post_meta($post->ID, '_pp_url', true);
    $date = get_post_meta($post->ID, '_pp_date', true);
    $tech = get_post_meta($post->ID, '_pp_tech', true);
    ?>
    <label>Client Name:</label>
    <input type="text" name="pp_client" value="<?php echo esc_attr($client); ?>" style="width:100%;"><br><br>
    <label>Project URL:</label>
    <input type="url" name="pp_url" value="<?php echo esc_attr($url); ?>" style="width:100%;"><br><br>
    <label>Completion Date:</label>
    <input type="date" name="pp_date" value="<?php echo esc_attr($date); ?>" style="width:100%;"><br><br>
    <label>Technology Used:</label>
    <input type="text" name="pp_tech" value="<?php echo esc_attr($tech); ?>" style="width:100%;">
    <?php
}

function pp_save_project_meta($post_id) {
    if (array_key_exists('pp_client', $_POST)) {
        update_post_meta($post_id, '_pp_client', sanitize_text_field($_POST['pp_client']));
    }
    if (array_key_exists('pp_url', $_POST)) {
        update_post_meta($post_id, '_pp_url', esc_url($_POST['pp_url']));
    }
    if (array_key_exists('pp_date', $_POST)) {
        update_post_meta($post_id, '_pp_date', sanitize_text_field($_POST['pp_date']));
    }
    if (array_key_exists('pp_tech', $_POST)) {
        update_post_meta($post_id, '_pp_tech', sanitize_text_field($_POST['pp_tech']));
    }
}
add_action('save_post', 'pp_save_project_meta');
