<form method="post" style="background:#fff;padding:20px;margin-bottom:30px;">
    <h3>Add Restaurant</h3>

    <label>Name</label>
    <input type="text" name="name" required class="regular-text">

    <label>Email</label>
    <input type="email" name="email" required class="regular-text">

    <label>Password</label>
    <input type="password" name="password" required class="regular-text">

    <label>Phone</label>
    <input type="text" name="phone" class="regular-text">

    <label>Category</label>
    <input type="text" name="category" class="regular-text">

    <label>Description</label>
    <textarea name="description" class="large-text"></textarea>

    <label>Location</label>
    <textarea name="location" class="large-text"></textarea>

    <label>Working From</label>
    <input type="time" name="workingfrom">

    <label>Working To</label>
    <input type="time" name="workingto">

    <label>Slug</label>
    <input type="text" name="slug" class="regular-text">

    <label>Tour ID</label>
    <input type="text" name="tour_id" class="regular-text">

    <label>Thumbnail URL</label>
    <input type="text" name="thumbnail" class="regular-text">

    <h4>Options</h4>
    <label><input type="checkbox" name="reservation"> Reservation Enabled</label><br>
    <label><input type="checkbox" name="open_now"> Open Now</label><br>
    <label><input type="checkbox" name="have_floors"> Have Floors</label><br>
    <label><input type="checkbox" name="have_highlight"> Have Highlight</label><br>
    <label><input type="checkbox" name="have_food_menu"> Have Food Menu</label><br>
    <label><input type="checkbox" name="whatsapp_reservation"> WhatsApp Reservation</label><br>

    <label>WhatsApp Number</label>
    <input type="text" name="whatsapp_number" class="regular-text">

    <label>First Floor Name</label>
    <input type="text" name="first_floor_name" class="regular-text">

    <label>Second Floor Name</label>
    <input type="text" name="second_floor_name" class="regular-text">

    <label>Third Floor Name</label>
    <input type="text" name="third_floor_name" class="regular-text">

    <br><br>
    <button type="submit" name="rs_add_rest" class="button button-primary">Add Restaurant</button>
</form>
