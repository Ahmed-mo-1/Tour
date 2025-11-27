<?php
function rs_create_tables() {
    global $wpdb;

    $charset = $wpdb->get_charset_collate();

    $t_users = $wpdb->prefix . "rs_users";
    $t_rest  = $wpdb->prefix . "rs_restaurants";
    $t_res   = $wpdb->prefix . "rs_reservations";
    $t_food  = $wpdb->prefix . "rs_food";

    $sql_users = "CREATE TABLE $t_users (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        phone_number VARCHAR(20),
        user_type ENUM('admin','restaurant','customer') NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) $charset;";

    $sql_rest = "CREATE TABLE $t_rest (
        restaurant_id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        category VARCHAR(255),
        description TEXT,
        location TEXT,
        email VARCHAR(255) NOT NULL UNIQUE,
        phone VARCHAR(20),
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        workingfrom TIME,
        workingto TIME,
        slug VARCHAR(255) UNIQUE,
        tour_id VARCHAR(25),
        thumbnail VARCHAR(500),
        reservation TINYINT(1) DEFAULT 0,
        open_now TINYINT(1) DEFAULT 0,
        have_floors TINYINT(1) DEFAULT 0,
        have_highlight TINYINT(1) DEFAULT 0,
        first_floor_name VARCHAR(50),
        second_floor_name VARCHAR(50),
        have_food_menu TINYINT(1),
        whatsapp_reservation TINYINT(1),
        whatsapp_number VARCHAR(20),
        third_floor_name VARCHAR(50)
    ) $charset;";

    $sql_res = "CREATE TABLE $t_res (
        reservation_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        restaurant_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        reservation_date DATE NOT NULL,
        reservation_time TIME NOT NULL,
        status ENUM('pending','confirmed','cancelled','completed') DEFAULT 'pending',
        member_count INT NOT NULL DEFAULT 1,
        FOREIGN KEY (user_id) REFERENCES $t_users(user_id) ON DELETE CASCADE,
        FOREIGN KEY (restaurant_id) REFERENCES $t_rest(restaurant_id) ON DELETE CASCADE
    ) $charset;";

    $sql_food = "CREATE TABLE $t_food (
        food_id INT AUTO_INCREMENT PRIMARY KEY,
        restaurant_id INT NOT NULL,
        name VARCHAR(255) NOT NULL,
        image VARCHAR(255),
        category VARCHAR(255),
        subcategory VARCHAR(255),
        price DECIMAL(10,2) NOT NULL,
        FOREIGN KEY (restaurant_id) REFERENCES $t_rest(restaurant_id) ON DELETE CASCADE
    ) $charset;";

    require_once(ABSPATH . "wp-admin/includes/upgrade.php");
    dbDelta($sql_users);
    dbDelta($sql_rest);
    dbDelta($sql_res);
    dbDelta($sql_food);
}
