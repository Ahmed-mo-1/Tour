<?php

function rs_admin_restaurants() {
    global $wpdb;
    $table = $wpdb->prefix . "rs_restaurants";

    /* ===========================
       DELETE RESTAURANT
    =========================== */
    if (isset($_GET['delete'])) {
        $wpdb->delete($table, ["restaurant_id" => intval($_GET['delete'])]);
        echo "<div class='updated'><p>Restaurant Deleted.</p></div>";
    }

    /* ===========================
       ADD RESTAURANT
    =========================== */
    if (isset($_POST['rs_add_rest'])) {
        $wpdb->insert($table, [
            "name" => $_POST['name'],
            "category" => $_POST['category'],
            "description" => $_POST['description'],
            "location" => $_POST['location'],
            "email" => $_POST['email'],
            "phone" => $_POST['phone'],
            "password" => wp_hash_password($_POST['password']),
            "workingfrom" => $_POST['workingfrom'],
            "workingto" => $_POST['workingto'],
            "slug" => $_POST['slug'],
            "tour_id" => $_POST['tour_id'],
            "thumbnail" => $_POST['thumbnail'],
            "reservation" => isset($_POST['reservation']) ? 1 : 0,
            "open_now" => isset($_POST['open_now']) ? 1 : 0,
            "have_floors" => isset($_POST['have_floors']) ? 1 : 0,
            "have_highlight" => isset($_POST['have_highlight']) ? 1 : 0,
            "first_floor_name" => $_POST['first_floor_name'],
            "second_floor_name" => $_POST['second_floor_name'],
            "third_floor_name" => $_POST['third_floor_name'],
            "have_food_menu" => isset($_POST['have_food_menu']) ? 1 : 0,
            "whatsapp_reservation" => isset($_POST['whatsapp_reservation']) ? 1 : 0,
            "whatsapp_number" => $_POST['whatsapp_number']
        ]);

        echo "<div class='updated'><p>Restaurant Added.</p></div>";
    }

    /* ===========================
       GET ALL RESTAURANTS
    =========================== */
    $restaurants = $wpdb->get_results("SELECT * FROM $table");

    echo "<h1>Restaurants</h1>";

    echo "<h2>Add Restaurant</h2>";

    include get_theme_file_path('/inc/forms/add-restaurant-form.php');

    echo "<h2>All Restaurants</h2>";

    echo "<table class='wp-list-table widefat striped'>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Category</th><th>Actions</th>
            </tr>";

    foreach ($restaurants as $r) {
        echo "<tr>
            <td>$r->restaurant_id</td>
            <td>$r->name</td>
            <td>$r->email</td>
            <td>$r->category</td>
            <td>
                <a href='?page=rs-restaurants&edit=$r->restaurant_id'>Edit</a> |
                <a href='?page=rs-restaurants&delete=$r->restaurant_id' onclick='return confirm(\"Delete?\")'>Delete</a>
            </td>
        </tr>";
    }

    echo "</table>";
}
