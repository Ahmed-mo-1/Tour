<?php

function rs_admin_food() {
    global $wpdb;

    $table = $wpdb->prefix . "rs_food";
    $restaurants = $wpdb->get_results("SELECT restaurant_id, name FROM {$wpdb->prefix}rs_restaurants");

    if (isset($_GET['delete'])) {
        $wpdb->delete($table, ["food_id" => intval($_GET['delete'])]);
        echo "<div class='updated'><p>Food Deleted.</p></div>";
    }

    if (isset($_POST['rs_add_food'])) {
        $wpdb->insert($table, [
            "restaurant_id" => $_POST['restaurant_id'],
            "name" => $_POST['name'],
            "image" => $_POST['image'],
            "category" => $_POST['category'],
            "subcategory" => $_POST['subcategory'],
            "price" => $_POST['price']
        ]);
        echo "<div class='updated'><p>Food Added.</p></div>";
    }

    $food = $wpdb->get_results("
        SELECT f.*, r.name AS restaurant
        FROM $table f
        JOIN {$wpdb->prefix}rs_restaurants r ON r.restaurant_id = f.restaurant_id
    ");

    echo "<h1>Food Menu</h1>";

    include get_theme_file_path('/inc/forms/add-food-form.php');

    echo "<h2>All Food Items</h2>";

    echo "<table class='wp-list-table widefat striped'>
        <tr><th>ID</th><th>Name</th><th>Restaurant</th><th>Category</th><th>Price</th><th>Actions</th></tr>";

    foreach ($food as $f) {
        echo "<tr>
            <td>$f->food_id</td>
            <td>$f->name</td>
            <td>$f->restaurant</td>
            <td>$f->category</td>
            <td>$f->price</td>
            <td><a href='?page=rs-food&delete=$f->food_id'>Delete</a></td>
        </tr>";
    }

    echo "</table>";
}
