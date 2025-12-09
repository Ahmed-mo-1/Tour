<?php
// --- GET FRESH CONTENT ---
add_action('wp_ajax_get_fresh_content', 'get_fresh_content_callback');
add_action('wp_ajax_nopriv_get_fresh_content', 'get_fresh_content_callback');

function get_fresh_content_callback() {
    $is_logged_in = is_user_logged_in();
    $user_name = $is_logged_in ? wp_get_current_user()->display_name : '';
    
    wp_send_json_success([
        'is_logged_in' => $is_logged_in,
        'user_name' => $user_name,
        'nonces' => [
            'auth' => wp_create_nonce('custom_auth_nonce_action'),
            'logout' => wp_create_nonce('custom_logout_nonce_action'),
            'reservation' => wp_create_nonce('tour_reservation_nonce_action')
        ]
    ]);
}

// --- AUTH HANDLERS ---
add_action('wp_ajax_custom_auth_process', 'custom_auth_process_callback');
add_action('wp_ajax_nopriv_custom_auth_process', 'custom_auth_process_callback');

function custom_auth_process_callback() {
    if (!wp_verify_nonce($_POST['custom_auth_nonce'], 'custom_auth_nonce_action')) {
        wp_send_json_error(['message' => 'Security check failed']);
    }

    $username_or_email = sanitize_text_field($_POST['auth_username']);
    $password = $_POST['auth_password'];

    $user = get_user_by('login', $username_or_email);
    if (!$user && is_email($username_or_email)) {
        $user = get_user_by('email', $username_or_email);
    }

    if ($user) {
        // LOGIN
        $signon = wp_signon(['user_login' => $user->user_login, 'user_password' => $password, 'remember' => true], false);
        if (is_wp_error($signon)) {
            wp_send_json_error(['message' => 'Invalid password']);
        }
        wp_set_current_user($signon->ID);
        wp_set_auth_cookie($signon->ID, true);
        wp_send_json_success([
            'message' => 'Login successful!', 
            'logged_in' => true, 
            'user_name' => $user->display_name,
            'nonces' => [
                'logout' => wp_create_nonce('custom_logout_nonce_action'),
                'reservation' => wp_create_nonce('tour_reservation_nonce_action')
            ]
        ]);
    } else {
        // REGISTER
        $new_login = is_email($username_or_email) ? sanitize_user(explode('@', $username_or_email)[0], true) : sanitize_user($username_or_email, true);
        
        $user_id = wp_insert_user([
            'user_login' => $new_login,
            'user_pass' => $password,
            'user_email' => is_email($username_or_email) ? $username_or_email : '',
            'role' => 'subscriber'
        ]);

        if (is_wp_error($user_id)) {
            wp_send_json_error(['message' => $user_id->get_error_message()]);
        }

        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id, true);
        $new_user = get_user_by('id', $user_id);
        wp_send_json_success([
            'message' => 'Account created!', 
            'logged_in' => true, 
            'user_name' => $new_user->display_name,
            'nonces' => [
                'logout' => wp_create_nonce('custom_logout_nonce_action'),
                'reservation' => wp_create_nonce('tour_reservation_nonce_action')
            ]
        ]);
    }
}

add_action('wp_ajax_custom_logout_process', 'custom_logout_process_callback');

function custom_logout_process_callback() {
    if (!wp_verify_nonce($_POST['custom_logout_nonce'], 'custom_logout_nonce_action')) {
        wp_send_json_error(['message' => 'Security check failed']);
    }
    wp_logout();
    wp_clear_auth_cookie();
    wp_send_json_success([
        'message' => 'Logged out', 
        'logged_out' => true,
        'nonce' => wp_create_nonce('custom_auth_nonce_action')
    ]);
}

// --- RESERVATION HANDLERS ---
add_action('wp_ajax_tour_new_reservation', 'tour_handle_reservation');
add_action('wp_ajax_tour_edit_reservation', 'tour_handle_reservation');

function tour_handle_reservation() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Must be logged in']);
    }
    if (!wp_verify_nonce($_POST['tour_reservation_nonce'], 'tour_reservation_nonce_action')) {
        wp_send_json_error(['message' => 'Security check failed']);
    }

    global $wpdb;
    $table = $wpdb->prefix . "tour_reservations";
    $data = [
        'user_id' => get_current_user_id(),
        'reservation_date' => sanitize_text_field($_POST['res_date']),
        'reservation_time' => sanitize_text_field($_POST['res_time']),
        'member_count' => intval($_POST['member_count'])
    ];

    if ($_POST['action'] === 'tour_new_reservation') {
        $data['status'] = 'pending';
        $wpdb->insert($table, $data);
        wp_send_json_success(['message' => 'Reservation booked!']);
    } else {
        $wpdb->update($table, $data, ['id' => intval($_POST['reservation_id']), 'user_id' => $data['user_id']]);
        wp_send_json_success(['message' => 'Reservation updated!']);
    }
}

add_action('wp_ajax_tour_cancel_reservation', 'tour_cancel_reservation_callback');

function tour_cancel_reservation_callback() {
    if (!wp_verify_nonce($_POST['tour_reservation_nonce'], 'tour_reservation_nonce_action')) {
        wp_send_json_error(['message' => 'Security check failed']);
    }
    global $wpdb;
    $wpdb->update($wpdb->prefix . "tour_reservations", ['status' => 'cancelled'], 
        ['id' => intval($_POST['reservation_id']), 'user_id' => get_current_user_id()]);
    wp_send_json_success(['message' => 'Reservation cancelled']);
}

add_action('wp_ajax_get_reservations', 'get_reservations_callback');

function get_reservations_callback() {
    global $wpdb;
    $reservations = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}tour_reservations WHERE user_id = %d ORDER BY reservation_date DESC",
        get_current_user_id()
    ));
    wp_send_json_success(['reservations' => $reservations]);
}

// --- ENQUEUE SCRIPTS ---
add_action('wp_enqueue_scripts', 'custom_auth_enqueue_scripts');

function custom_auth_enqueue_scripts() {
    wp_enqueue_script('custom-auth-script', get_template_directory_uri() . '/js/custom-auth.js', ['jquery'], '1.0', true);
    wp_localize_script('custom-auth-script', 'CustomAuth', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'is_logged_in' => is_user_logged_in(),
        'user_name' => is_user_logged_in() ? wp_get_current_user()->display_name : ''
    ]);
}



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



require_once get_theme_file_path('/inc/tables.php');




























// Add admin menu for reservations
add_action('admin_menu', function(){
    add_menu_page(
        'Tour Reservations',
        'Reservations',
        'manage_options',
        'tour-reservations',
        'tour_admin_reservations_page',
        'dashicons-calendar-alt',
        6
    );
});

// Admin page HTML
function tour_admin_reservations_page(){
    ?>
    <div class="wrap">
        <h1>All Reservations</h1>
        <div id="tour-admin-reservations">
            <p>Loading reservations...</p>
        </div>
    </div>
    <?php
}




add_action('admin_enqueue_scripts', function($hook){
    if ($hook != 'toplevel_page_tour-reservations') return;

    wp_enqueue_script('tour-admin-ajax', get_template_directory_uri().'/assets/js/tour-admin-ajax.js', ['jquery'], null, true);
    wp_localize_script('tour-admin-ajax', 'tour_admin_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('tour_ajax_nonce')
    ]);
});



// Get all reservations for admin
add_action('wp_ajax_tour_admin_get_reservations', function(){
    check_ajax_referer('tour_ajax_nonce', 'nonce');
    if(!current_user_can('manage_options')) wp_send_json_error(['message'=>'No permission']);

    global $wpdb;
    $t_res = $wpdb->prefix . "tour_reservations";
    $t_users = $wpdb->prefix . "users";

    $reservations = $wpdb->get_results(
        "SELECT r.id, r.user_id, u.user_email, r.reservation_date, r.reservation_time, r.member_count, r.status 
         FROM $t_res r 
         LEFT JOIN $t_users u ON r.user_id=u.ID
         ORDER BY r.created_at DESC",
        ARRAY_A
    );

    wp_send_json_success($reservations);
});

// Update reservation as admin
add_action('wp_ajax_tour_admin_update_reservation', function(){
    check_ajax_referer('tour_ajax_nonce', 'nonce');
    if(!current_user_can('manage_options')) wp_send_json_error(['message'=>'No permission']);

    $res_id = intval($_POST['res_id'] ?? 0);
    $date = sanitize_text_field($_POST['reservation_date'] ?? '');
    $time = sanitize_text_field($_POST['reservation_time'] ?? '');
    $members = intval($_POST['member_count'] ?? 1);
    $status = sanitize_text_field($_POST['status'] ?? 'pending');

    if(!$res_id || !$date || !$time || $members<1) wp_send_json_error(['message'=>'Invalid data']);

    global $wpdb;
    $t_res = $wpdb->prefix . "tour_reservations";

    $updated = $wpdb->update(
        $t_res,
        [
            'reservation_date'=>$date,
            'reservation_time'=>$time,
            'member_count'=>$members,
            'status'=>$status
        ],
        ['id'=>$res_id],
        ['%s','%s','%d','%s'],
        ['%d']
    );

    if($updated === false) wp_send_json_error(['message'=>'Update failed']);

    wp_send_json_success(['message'=>'Reservation updated']);
});









// Hide admin bar for all users on the front end
add_filter('show_admin_bar', '__return_false');


/*
add_filter('show_admin_bar', function($show) {
    if (!current_user_can('administrator')) {
        return false;
    }
    return $show;
});

*/















add_action('admin_menu', 'tour_restaurant_admin_menu');

function tour_restaurant_admin_menu() {
    add_menu_page(
        'Restaurant Info',          // Page title
        'Restaurant Info',          // Menu title
        'manage_options',           // Capability
        'tour-restaurant-info',     // Menu slug
        'tour_restaurant_admin_page', // Callback function
        'dashicons-store',          // Icon
        25                          // Position
    );
}

function tour_restaurant_admin_page() {
    global $wpdb;
    $t_rest_info = $wpdb->prefix . "tour_restaurant_info";

    // Handle form submission
    if (isset($_POST['submit_restaurant_info'])) {
        $name = sanitize_text_field($_POST['name']);
        $category = sanitize_text_field($_POST['category']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $tour_id = sanitize_text_field($_POST['tour_id']);
        $thumbnail = esc_url_raw($_POST['thumbnail']);
        $description = sanitize_textarea_field($_POST['description']);
        $location = sanitize_textarea_field($_POST['location']);
        $working_from = sanitize_text_field($_POST['working_from']);
        $working_to = sanitize_text_field($_POST['working_to']);

        // Update or insert single row
        $existing = $wpdb->get_row("SELECT * FROM $t_rest_info LIMIT 1");
        if ($existing) {
            $wpdb->update(
                $t_rest_info,
                compact('name','category','email','phone','tour_id','thumbnail','description','location','working_from','working_to'),
                array('email' => $existing->email)
            );
        } else {
            $wpdb->insert(
                $t_rest_info,
                compact('name','category','email','phone','tour_id','thumbnail','description','location','working_from','working_to')
            );
        }

        echo '<div class="updated notice"><p>Restaurant info updated successfully!</p></div>';
    }

    // Get current data
    $rest_info = $wpdb->get_row("SELECT * FROM $t_rest_info LIMIT 1");

    ?>
    <div class="wrap">
        <h1>Restaurant Info</h1>
        <form method="post">
            <table class="form-table">
                <tr>
                    <th>Name</th>
                    <td><input type="text" name="name" value="<?= esc_attr($rest_info->name ?? '') ?>" class="regular-text" required></td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td><input type="text" name="category" value="<?= esc_attr($rest_info->category ?? '') ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><input type="email" name="email" value="<?= esc_attr($rest_info->email ?? '') ?>" class="regular-text" required></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><input type="text" name="phone" value="<?= esc_attr($rest_info->phone ?? '') ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th>Tour ID</th>
                    <td><input type="text" name="tour_id" value="<?= esc_attr($rest_info->tour_id ?? '') ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th>Thumbnail URL</th>
                    <td><input type="url" name="thumbnail" value="<?= esc_attr($rest_info->thumbnail ?? '') ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td><textarea name="description" class="large-text" rows="5"><?= esc_textarea($rest_info->description ?? '') ?></textarea></td>
                </tr>
                <tr>
                    <th>Location</th>
                    <td><textarea name="location" class="large-text" rows="3"><?= esc_textarea($rest_info->location ?? '') ?></textarea></td>
                </tr>
                <tr>
                    <th>Working From</th>
                    <td><input type="time" name="working_from" value="<?= esc_attr($rest_info->working_from ?? '') ?>" required></td>
                </tr>
                <tr>
                    <th>Working To</th>
                    <td><input type="time" name="working_to" value="<?= esc_attr($rest_info->working_to ?? '') ?>" required></td>
                </tr>
            </table>
            <p class="submit">
                <button type="submit" name="submit_restaurant_info" class="button button-primary">Save Changes</button>
            </p>
        </form>
    </div>

    <style>
    .form-table th { width: 150px; padding-right: 20px; }
    .form-table input, .form-table textarea { width: 100%; max-width: 400px; }
    .wrap h1 { margin-bottom: 20px; }
    </style>
    <?php
}





























//foods
add_action('admin_menu', 'tour_food_admin_menu');
function tour_food_admin_menu() {
    add_menu_page(
        'Tour Food',
        'Tour Food',
        'manage_options',
        'tour-food-manager',
        'tour_food_manager_page',
        'dashicons-carrot',
        25
    );
}



function tour_food_manager_page() {
    global $wpdb;
    $table = $wpdb->prefix . "tour_food";

    /* ---------------------- DELETE ---------------------- */
    if (isset($_GET['delete'])) {
        $wpdb->delete($table, ['food_id' => intval($_GET['delete'])]);
        echo "<div class='updated'><p>Item deleted.</p></div>";
    }

    /* ---------------------- INSERT / UPDATE ---------------------- */
    if ($_POST && isset($_POST['name'])) {

        $data = [
            'name'        => sanitize_text_field($_POST['name']),
            'image'       => sanitize_text_field($_POST['image']),
            'category'    => sanitize_text_field($_POST['category']),
            'subcategory' => sanitize_text_field($_POST['subcategory']),
            'price'       => floatval($_POST['price']),
        ];

        if (!empty($_POST['food_id'])) {
            // UPDATE
            $wpdb->update($table, $data, ['food_id' => intval($_POST['food_id'])]);
            echo "<div class='updated'><p>Item updated.</p></div>";
        } else {
            // INSERT
            $wpdb->insert($table, $data);
            echo "<div class='updated'><p>Item added.</p></div>";
        }
    }

    /* ---------------------- EDIT MODE ---------------------- */
    $edit_item = null;
    if (isset($_GET['edit'])) {
        $edit_item = $wpdb->get_row("SELECT * FROM $table WHERE food_id=" . intval($_GET['edit']));
    }

    /* ---------------------- SELECT ALL ---------------------- */
    $rows = $wpdb->get_results("SELECT * FROM $table ORDER BY food_id DESC");
    ?>

    <div class="wrap">
        <h1>Tour Food Manager</h1>

        <h2><?php echo $edit_item ? "Edit Item" : "Add Item"; ?></h2>

        <form method="post">
            <input type="hidden" name="food_id" value="<?php echo $edit_item->food_id ?? ''; ?>">

            <table class="form-table">
                <tr><th>Name</th><td><input type="text" name="name" required value="<?php echo $edit_item->name ?? ''; ?>"></td></tr>
                <tr><th>Image URL</th><td><input type="text" name="image" value="<?php echo $edit_item->image ?? ''; ?>"></td></tr>
                <tr><th>Category</th><td><input type="text" name="category" value="<?php echo $edit_item->category ?? ''; ?>"></td></tr>
                <tr><th>Subcategory</th><td><input type="text" name="subcategory" value="<?php echo $edit_item->subcategory ?? ''; ?>"></td></tr>
                <tr><th>Price</th><td><input type="text" name="price" value="<?php echo $edit_item->price ?? ''; ?>"></td></tr>
            </table>

            <button class="button button-primary">Save</button>
        </form>

        <hr>

        <h2>Food List</h2>

        <table class="widefat striped">
            <thead>
                <tr>
                    <th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?php echo $r->food_id; ?></td>
                    <td><?php echo esc_html($r->name); ?></td>
                    <td><?php echo esc_html($r->category); ?></td>
                    <td><?php echo esc_html($r->price); ?></td>
                    <td>
                        <a href="?page=tour-food-manager&edit=<?php echo $r->food_id; ?>" class="button">Edit</a>
                        <a href="?page=tour-food-manager&delete=<?php echo $r->food_id; ?>" class="button" onclick="return confirm('Delete this item?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>

    <?php
}



add_shortcode('tour_food_grid', function() {
    global $wpdb;
    $table = $wpdb->prefix . "tour_food";
    $rows = $wpdb->get_results("SELECT * FROM $table");

    $html = "<div class='tour-food-grid' style='display:flex;flex-wrap:wrap;gap:20px;'>";

    foreach ($rows as $r) {
        $html .= "
            <div class='tour-food-item' style='width:200px;border:1px solid #ddd;padding:10px;'>
                <img src='{$r->image}' style='width:100%;height:auto;' />
                <h3>{$r->name}</h3>
                <p>{$r->category}</p>
                <strong>{$r->price} USD</strong>
            </div>
        ";
    }

    return $html . "</div>";
});
