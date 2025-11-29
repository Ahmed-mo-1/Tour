<?php



session_start();




function styles() {

	wp_enqueue_style(
		"app.css", 
		get_template_directory_uri(). "/assets/css/app.css", 
		array(),
		filemtime( get_template_directory() . "/assets/css/app.css"), 
		"all"
	);

}
add_action('wp_enqueue_scripts', 'styles');





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

























// Register Shortcode for Registration Form
add_shortcode('rs_user_register', 'rs_user_register_form');

function rs_user_register_form() {
if (isset($_POST['rs_register'])) {
        global $wpdb;
        $table = $wpdb->prefix . 'rs_users';

        $name  = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $phone = sanitize_text_field($_POST['phone']);
        $user_type = in_array($_POST['user_type'], ['customer','restaurant']) ? $_POST['user_type'] : 'customer';

        // Check if email exists
        $exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE email=%s", $email));
        if ($exists) {
            echo "<p>Email already exists!</p>";
        } else {
            $wpdb->insert($table, [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'phone_number' => $phone,
                'user_type' => $user_type
            ]);
            echo "<p>Registration successful!</p>";
        }
    }

    return '
    <form method="POST">
        <input type="text" name="name" placeholder="Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="text" name="phone" placeholder="Phone"><br>
        <select name="user_type">
            <option value="customer">Customer</option>
            <option value="restaurant">Restaurant</option>
        </select><br>
        <input type="submit" name="rs_register" value="Register">
    </form>';
}























// Shortcode for Login Form
add_shortcode('rs_user_login', 'rs_user_login_form');

function rs_user_login_form() {
if (isset($_POST['rs_login'])) {
        global $wpdb;
        $table = $wpdb->prefix . 'rs_users';
        $email = sanitize_email($_POST['email']);
        $password = $_POST['password'];

        $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE email=%s", $email));
        if ($user && password_verify($password, $user->password)) {
            // Set session or cookie for logged in user
            session_start();
            $_SESSION['rs_user_id'] = $user->user_id;
            $_SESSION['rs_user_type'] = $user->user_type;
            echo "<p>Login successful! Welcome {$user->name}</p>";
        } else {
            echo "<p>Invalid email or password!</p>";
        }
    }

    return '
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" name="rs_login" value="Login">
    </form>';
}









































add_shortcode('rs_make_reservation', 'rs_reservation_form');

function rs_reservation_form() {
    if (!session_id()) session_start();
    if (!isset($_SESSION['rs_user_id'])) return "<p>Please log in to reserve.</p>";

    global $wpdb;
    $table_res = $wpdb->prefix . 'rs_reservations';
    $table_rest = $wpdb->prefix . 'rs_restaurants';
    $user_id = $_SESSION['rs_user_id'];

    // Handle form submission
if (isset($_POST['rs_reserve'])) {
        $restaurant_id = intval($_POST['restaurant_id']);
        $reservation_date = $_POST['reservation_date'];
        $reservation_time = $_POST['reservation_time'];
        $member_count = intval($_POST['member_count']);

        $wpdb->insert($table_res, [
            'user_id' => $user_id,
            'restaurant_id' => $restaurant_id,
            'reservation_date' => $reservation_date,
            'reservation_time' => $reservation_time,
            'member_count' => $member_count,
        ]);

        echo "<p>Reservation successful!</p>";
    }

    // Fetch restaurants
    $restaurants = $wpdb->get_results("SELECT restaurant_id, name FROM $table_rest");

    $form = '<form method="POST">
        <select name="restaurant_id" required>';
    foreach ($restaurants as $rest) {
        $form .= "<option value='{$rest->restaurant_id}'>{$rest->name}</option>";
    }
    $form .= '</select><br>
        <input type="date" name="reservation_date" required><br>
        <input type="time" name="reservation_time" required><br>
        <input type="number" name="member_count" value="1" min="1" required><br>
        <input type="submit" name="rs_reserve" value="Reserve">
    </form>';

    return $form;
}
