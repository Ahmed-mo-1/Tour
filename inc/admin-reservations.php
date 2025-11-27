<?php

function rs_admin_reservations() {
    global $wpdb;

    $table = $wpdb->prefix . "rs_reservations";
    $users = $wpdb->get_results("SELECT user_id, name FROM {$wpdb->prefix}rs_users");
    $restaurants = $wpdb->get_results("SELECT restaurant_id, name FROM {$wpdb->prefix}rs_restaurants");

    if (isset($_GET['delete'])) {
        $wpdb->delete($table, ["reservation_id" => intval($_GET['delete'])]);
        echo "<div class='updated'><p>Reservation Deleted.</p></div>";
    }

    if (isset($_POST['rs_add_res'])) {
        $wpdb->insert($table, [
            "user_id" => $_POST['user_id'],
            "restaurant_id" => $_POST['restaurant_id'],
            "reservation_date" => $_POST['reservation_date'],
            "reservation_time" => $_POST['reservation_time'],
            "status" => $_POST['status'],
            "member_count" => $_POST['member_count']
        ]);
        echo "<div class='updated'><p>Reservation Added.</p></div>";
    }

    $reservations = $wpdb->get_results("
        SELECT r.*, u.name AS user_name, re.name AS restaurant_name
        FROM $table r
        JOIN {$wpdb->prefix}rs_users u ON r.user_id = u.user_id
        JOIN {$wpdb->prefix}rs_restaurants re ON r.restaurant_id = re.restaurant_id
    ");

    echo "<h1>Reservations</h1>";

    include get_theme_file_path('/inc/forms/add-reservation-form.php');

    echo "<h2>All Reservations</h2>";

    echo "<table class='wp-list-table widefat striped'>
        <tr><th>ID</th><th>User</th><th>Restaurant</th><th>Date</th><th>Status</th><th>Actions</th></tr>";

    foreach ($reservations as $r) {
        echo "
        <tr>
            <td>$r->reservation_id</td>
            <td>$r->user_name</td>
            <td>$r->restaurant_name</td>
            <td>$r->reservation_date $r->reservation_time</td>
            <td>$r->status</td>
            <td><a href='?page=rs-reservations&delete=$r->reservation_id'>Delete</a></td>
        </tr>";
    }

    echo "</table>";
}
