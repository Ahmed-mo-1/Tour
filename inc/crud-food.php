<?php

add_shortcode("rs_add_food", function() {
    global $wpdb;

    $restaurants = $wpdb->get_results("SELECT restaurant_id, name FROM {$wpdb->prefix}rs_restaurants");

    if (isset($_POST['rs_add_food'])) {
        $wpdb->insert($wpdb->prefix . "rs_food", [
            "restaurant_id" => intval($_POST['restaurant_id']),
            "name" => sanitize_text_field($_POST['name']),
            "image" => sanitize_text_field($_POST['image']),
            "category" => sanitize_text_field($_POST['category']),
            "subcategory" => sanitize_text_field($_POST['subcategory']),
            "price" => floatval($_POST['price'])
        ]);

        echo "<p class='success'>Food Item Added Successfully.</p>";
    }

    ob_start(); ?>

    <form method="post" class="rs-form">

        <select name="restaurant_id" required>
            <option value="">Select Restaurant</option>
            <?php foreach ($restaurants as $r) echo "<option value='$r->restaurant_id'>$r->name</option>"; ?>
        </select>

        <input name="name" placeholder="Food Name" required>
        <input name="image" placeholder="Image URL">
        <input name="category" placeholder="Category">
        <input name="subcategory" placeholder="Subcategory">
        <input name="price" type="number" step="0.01" placeholder="Price" required>

        <button name="rs_add_food">Add Food</button>
    </form>

<?php return ob_get_clean(); });
