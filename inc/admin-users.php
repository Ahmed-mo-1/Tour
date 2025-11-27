<?php

function rs_admin_users() {
    global $wpdb;
    $table = $wpdb->prefix . "rs_users";

    if (isset($_GET['delete'])) {
        $wpdb->delete($table, ["user_id" => intval($_GET['delete'])]);
        echo "<div class='updated'><p>User Deleted.</p></div>";
    }

    if (isset($_POST['rs_add_user'])) {
        $wpdb->insert($table, [
            "name" => $_POST['name'],
            "email" => $_POST['email'],
            "password" => wp_hash_password($_POST['password']),
            "phone_number" => $_POST['phone_number'],
            "user_type" => $_POST['user_type']
        ]);

        echo "<div class='updated'><p>User Added.</p></div>";
    }

    $users = $wpdb->get_results("SELECT * FROM $table");

    echo "<h1>Users</h1>";

    include get_theme_file_path('/inc/forms/add-user-form.php');

    echo "<h2>All Users</h2>";

    echo "<table class='wp-list-table widefat striped'>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Type</th><th>Actions</th></tr>";

    foreach ($users as $u) {
        echo "<tr>
            <td>$u->user_id</td>
            <td>$u->name</td>
            <td>$u->email</td>
            <td>$u->user_type</td>
            <td><a href='?page=rs-users&delete=$u->user_id'>Delete</a></td>
        </tr>";
    }

    echo "</table>";
}
