







<input type="checkbox" id="popup-toggle2" />
<label for="popup-toggle2" class="sidebar-overlay2"></label>

<div class="sidebar2">


            <div id="auth-section">
                <form id="custom-auth-form">
                    <h2>Login or Register</h2>
                    <input type="text" name="auth_username" placeholder="Username or Email" required>
                    <input type="password" name="auth_password" placeholder="Password" required>
                    <?php wp_nonce_field('custom_auth_nonce_action', 'custom_auth_nonce'); ?>
                    <button type="submit">Submit</button>
                </form>
            </div>

            <div id="user-section" style="display:none;">

                <h2>Welcome <span id="user-display-name"></span>!</h2>
                <button id="custom-logout-button">Logout</button>
                <?php wp_nonce_field('custom_logout_nonce_action', 'custom_logout_nonce'); ?>
                <h3>My Reservations</h3>
                <ul id="reservations-list"></ul>
				<label for="popup-toggle3" onclick="openReservationPage()">Reserve</label>
            </div>

            <div id="message"></div>



</div>


<style>
/* Hide the checkbox */
#popup-toggle2 {
  display: none;
}

/* Sidebar */
.sidebar2 {
  position: fixed;
  top: 0;
  left: -350px;
  width: 350px;
  height: 100%;
  background: #222;
  color: white;
  padding: 20px;
  box-shadow: 2px 0 10px rgba(0,0,0,0.3);
  transition: left 0.3s ease;
  z-index: 1001;
}

/* Overlay (label that acts as backdrop) */
.sidebar-overlay2 {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.4);
  display: none;
  z-index: 1000;
  cursor: pointer;
}

/* Open button */
.sidebar-open-btn {
  cursor: pointer;
  padding: 10px 20px;
  background: #333;
  color: white;
  font-size: 18px;
  display: inline-block;
  position: relative;
  z-index: 999;
}

/* Show sidebar and overlay when checkbox is checked */
#popup-toggle2:checked ~ .sidebar2 {
  left: 0;
}

#popup-toggle2:checked ~ .sidebar-overlay2 {
  display: block;
}


ul#reservations-list {
    list-style: none;
    height: 500px;
    overflow: auto;
}

</style>