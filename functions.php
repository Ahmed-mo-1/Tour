<?php















if (!defined('ABSPATH')) exit;

/* Load modules */
require_once get_theme_file_path('/inc/tables.php');
require_once get_theme_file_path('/inc/crud-users.php');
require_once get_theme_file_path('/inc/crud-restaurants.php');
require_once get_theme_file_path('/inc/crud-reservations.php');
require_once get_theme_file_path('/inc/crud-food.php');

/* Create tables on theme activation */
add_action("after_switch_theme", "rs_create_tables");

/* Enable shortcodes inside widgets and theme */
add_filter('widget_text', 'do_shortcode');







add_action('admin_menu', 'rs_admin_menu');

function rs_admin_menu() {

    add_menu_page(
        'Restaurant System',
        'Restaurant System',
        'manage_options',
        'rs-dashboard',
        'rs_dashboard_home',
        'dashicons-store',
        6
    );

    add_submenu_page(
        'rs-dashboard',
        'Restaurants',
        'Restaurants',
        'manage_options',
        'rs-restaurants',
        'rs_admin_restaurants'
    );

    add_submenu_page(
        'rs-dashboard',
        'Users',
        'Users',
        'manage_options',
        'rs-users',
        'rs_admin_users'
    );

    add_submenu_page(
        'rs-dashboard',
        'Reservations',
        'Reservations',
        'manage_options',
        'rs-reservations',
        'rs_admin_reservations'
    );

    add_submenu_page(
        'rs-dashboard',
        'Food Menu',
        'Food Menu',
        'manage_options',
        'rs-food',
        'rs_admin_food'
    );
}


require_once get_theme_file_path('/inc/admin-restaurants.php');
require_once get_theme_file_path('/inc/admin-users.php');
require_once get_theme_file_path('/inc/admin-reservations.php');
require_once get_theme_file_path('/inc/admin-food.php');





