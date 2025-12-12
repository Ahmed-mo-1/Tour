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
				<label class="openReservationPage" for="popup-toggle3" onclick="openReservationPage()">Reserve</label>
            </div>

            <div id="message"></div>



</div>
