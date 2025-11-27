<?php

add_shortcode("rs_add_user", function() {
    if (isset($_POST['rs_add_user'])) {
        global $wpdb;

        $wpdb->insert($wpdb->prefix . "rs_users", [
            "name" => sanitize_text_field($_POST['name']),
            "email" => sanitize_email($_POST['email']),
            "password" => wp_hash_password($_POST['password']),
            "phone_number" => sanitize_text_field($_POST['phone_number']),
            "user_type" => sanitize_text_field($_POST['user_type'])
        ]);

        echo "<p class='success'>User Added Successfully.</p>";
    }

    ob_start(); ?>

    <form method="post" class="rs-form">
        <input name="name" placeholder="Name" required>
        <input name="email" type="email" placeholder="Email" required>
        <input name="password" type="password" placeholder="Password" required>
        <input name="phone_number" placeholder="Phone Number">
        <select name="user_type">
            <option value="customer">Customer</option>
            <option value="restaurant">Restaurant</option>
            <option value="admin">Admin</option>
        </select>
        <button name="rs_add_user">Add User</button>
    </form>

<?php return ob_get_clean(); });
