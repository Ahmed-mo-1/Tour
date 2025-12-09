<?php
function tour_create_tables() {
    global $wpdb;
    $charset = $wpdb->get_charset_collate();

    $t_rest_info = $wpdb->prefix . "tour_restaurant_info";
    $t_res       = $wpdb->prefix . "tour_reservations";
    $t_food      = $wpdb->prefix . "tour_food";
    $wp_users    = $wpdb->prefix . "users"; // Default WP users table

    // Restaurant info table (single row only)
    $sql_rest_info = "CREATE TABLE $t_rest_info (
        name VARCHAR(255) NOT NULL,
        category VARCHAR(255),
        email VARCHAR(255) NOT NULL UNIQUE,
        phone VARCHAR(20),
        tour_id VARCHAR(25),
        thumbnail VARCHAR(500),
        description TEXT,
        location TEXT,
        working_from TIME,
        working_to TIME
    ) $charset;";

    // Reservations table
    $sql_res = "CREATE TABLE $t_res (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id BIGINT(20) UNSIGNED NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        reservation_date DATE NOT NULL,
        reservation_time TIME NOT NULL,
        status ENUM('pending','confirmed','cancelled','completed') DEFAULT 'pending',
        member_count INT NOT NULL DEFAULT 1,
        PRIMARY KEY (id),
        KEY user_id_idx (user_id),
        FOREIGN KEY (user_id) REFERENCES $wp_users(ID) ON DELETE CASCADE
    ) $charset;";

    // Food table
    $sql_food = "CREATE TABLE $t_food (
        food_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        image VARCHAR(255),
        category VARCHAR(255),
        subcategory VARCHAR(255),
        price DECIMAL(10,2) NOT NULL,
        PRIMARY KEY (food_id)
    ) $charset;";

    require_once(ABSPATH . "wp-admin/includes/upgrade.php");
    dbDelta($sql_rest_info);
    dbDelta($sql_res);
    dbDelta($sql_food);
}

add_action('after_switch_theme', 'tour_create_tables');
