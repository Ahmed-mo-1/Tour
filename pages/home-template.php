<!-- USER REGISTRATION FORM -->
<div id="rs-register">
    <h3>Register</h3>
    <form id="rs_register_form">
        <input type="text" name="name" placeholder="Full Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="text" name="phone" placeholder="Phone"><br>

        <select name="user_type">
            <option value="customer">Customer</option>
            <option value="restaurant">Restaurant</option>
        </select>

        <button type="submit">Register</button>
    </form>
    <div id="rs_register_msg"></div>
</div>

<!-- LOGIN FORM -->
<div id="rs-login" style="margin-top:30px;">
    <h3>Login</h3>
    <form id="rs_login_form">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <div id="rs_login_msg"></div>
</div>

<!-- RESERVATION FORM -->
<div id="rs-reservation" style="margin-top:30px;">
    <h3>Create Reservation</h3>
    <form id="rs_reservation_form">
        <input type="number" name="user_id" placeholder="User ID" required><br>
        <input type="number" name="restaurant_id" placeholder="Restaurant ID" required><br>
        <input type="date" name="reservation_date" required><br>
        <input type="time" name="reservation_time" required><br>
        <input type="number" name="member_count" value="1" required><br>
        <button type="submit">Reserve</button>
    </form>
    <div id="rs_reservation_msg"></div>
</div>