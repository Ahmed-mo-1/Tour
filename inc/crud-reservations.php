<?php

add_shortcode("rs_add_reservation", function() {
    global $wpdb;

    $users = $wpdb->get_results("SELECT user_id, name FROM {$wpdb->prefix}rs_users");
    $restaurants = $wpdb->get_results("SELECT restaurant_id, name FROM {$wpdb->prefix}rs_restaurants");

    if (isset($_POST['rs_add_res'])) {
        $wpdb->insert($wpdb->prefix . "rs_reservations", [
            "user_id" => intval($_POST['user_id']),
            "restaurant_id" => intval($_POST['restaurant_id']),
            "reservation_date" => sanitize_text_field($_POST['reservation_date']),
            "reservation_time" => sanitize_text_field($_POST['reservation_time']),
            "status" => sanitize_text_field($_POST['status']),
            "member_count" => intval($_POST['member_count'])
        ]);

        echo "<p class='success'>Reservation Added Successfully.</p>";
    }

    ob_start(); ?>

    <form method="post" class="rs-form">

        <select name="user_id" required>
            <option value="">Select User</option>
            <?php foreach ($users as $u) echo "<option value='$u->user_id'>$u->name</option>"; ?>
        </select>

        <select name="restaurant_id" required>
            <option value="">Select Restaurant</option>
            <?php foreach ($restaurants as $r) echo "<option value='$r->restaurant_id'>$r->name</option>"; ?>
        </select>

        <input name="reservation_date" type="date" required>
        <input name="reservation_time" type="time" required>

        <select name="status">
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="cancelled">Cancelled</option>
            <option value="completed">Completed</option>
        </select>

        <input name="member_count" type="number" min="1" value="1" required>

        <button name="rs_add_res">Add Reservation</button>

    </form>

<?php return ob_get_clean(); });
