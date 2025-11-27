<?php
/* Template Name: Restaurant Dashboard */
get_header();
?>

<div class="dashboard-container">

    <h2>Restaurant System Dashboard</h2>

    <div class="tabs">
        <a href="?tab=restaurants">Restaurants</a>
        <a href="?tab=users">Users</a>
        <a href="?tab=reservations">Reservations</a>
        <a href="?tab=food">Food</a>
    </div>

    <div class="tab-content">
        <?php
            $tab = $_GET['tab'] ?? 'restaurants';

if ($tab == "restaurants") {
    echo do_shortcode("[rs_add_restaurant]");
    echo do_shortcode("[rs_list_restaurants]");
}

if ($tab == "users") {
    echo do_shortcode("[rs_add_user]");
    echo do_shortcode("[rs_list_users]");
}

if ($tab == "reservations") {
    echo do_shortcode("[rs_add_reservation]");
    echo do_shortcode("[rs_list_reservations]");
}

if ($tab == "food") {
    echo do_shortcode("[rs_add_food]");
    echo do_shortcode("[rs_list_food]");
}

        ?>
    </div>

</div>

<?php get_footer(); ?>
