<?php

add_shortcode("rs_add_restaurant", function() {
    if (isset($_POST['rs_add_rest'])) {
        global $wpdb;
        $table = $wpdb->prefix . "rs_restaurants";

        $wpdb->insert($table, [
            "name" => sanitize_text_field($_POST['name']),
            "category" => sanitize_text_field($_POST['category']),
            "description" => sanitize_textarea_field($_POST['description']),
            "location" => sanitize_textarea_field($_POST['location']),
            "email" => sanitize_email($_POST['email']),
            "phone" => sanitize_text_field($_POST['phone']),
            "password" => wp_hash_password($_POST['password']),
            "workingfrom" => sanitize_text_field($_POST['workingfrom']),
            "workingto" => sanitize_text_field($_POST['workingto']),
            "slug" => sanitize_title($_POST['slug']),
            "tour_id" => sanitize_text_field($_POST['tour_id']),
            "thumbnail" => sanitize_text_field($_POST['thumbnail']),
            "reservation" => intval($_POST['reservation']),
            "open_now" => intval($_POST['open_now']),
            "have_floors" => intval($_POST['have_floors']),
            "have_highlight" => intval($_POST['have_highlight']),
            "first_floor_name" => sanitize_text_field($_POST['first_floor_name']),
            "second_floor_name" => sanitize_text_field($_POST['second_floor_name']),
            "third_floor_name" => sanitize_text_field($_POST['third_floor_name']),
            "have_food_menu" => intval($_POST['have_food_menu']),
            "whatsapp_reservation" => intval($_POST['whatsapp_reservation']),
            "whatsapp_number" => sanitize_text_field($_POST['whatsapp_number'])
        ]);

        echo "<p class='success'>Restaurant Added Successfully.</p>";
    }

    ob_start(); ?>

    <form method="post" class="rs-form">

        <h3>Basic Information</h3>
        <input name="name" placeholder="Restaurant Name" required>
        <input name="category" placeholder="Category">
        <textarea name="description" placeholder="Description"></textarea>
        <textarea name="location" placeholder="Location"></textarea>

        <h3>Contact</h3>
        <input name="email" type="email" placeholder="Email" required>
        <input name="phone" placeholder="Phone">
        <input name="password" type="password" placeholder="Password" required>

        <h3>Working Hours</h3>
        <input name="workingfrom" type="time">
        <input name="workingto" type="time">

        <h3>Settings</h3>
        <input name="slug" placeholder="Slug">
        <input name="tour_id" placeholder="Tour ID">
        <input name="thumbnail" placeholder="Thumbnail URL">

        <h3>Options</h3>
        <label>Reservation <input type="checkbox" name="reservation" value="1"></label>
        <label>Open Now <input type="checkbox" name="open_now" value="1"></label>
        <label>Have Floors <input type="checkbox" name="have_floors" value="1"></label>
        <label>Have Highlight <input type="checkbox" name="have_highlight" value="1"></label>
        <label>Have Food Menu <input type="checkbox" name="have_food_menu" value="1"></label>

        <h3>Floors</h3>
        <input name="first_floor_name" placeholder="First Floor Name">
        <input name="second_floor_name" placeholder="Second Floor Name">
        <input name="third_floor_name" placeholder="Third Floor Name">

        <h3>WhatsApp Reservation</h3>
        <label>Enable <input type="checkbox" name="whatsapp_reservation" value="1"></label>
        <input name="whatsapp_number" placeholder="WhatsApp Number">

        <button name="rs_add_rest">Add Restaurant</button>
    </form>

<?php return ob_get_clean(); });
