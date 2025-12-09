document.addEventListener("DOMContentLoaded", () => {

    let refreshInterval = null;
    let isEditing = false;
    let timeSlots = window.timeSlots || []; // Injected via PHP: const timeSlots = <?php echo json_encode($times); ?>;

    /* -----------------------------------------
       AUTO REFRESH CONTROL
    ----------------------------------------- */
    function startAutoRefresh() {
        if (!refreshInterval) {
            refreshInterval = setInterval(loadUserReservations, 10000);
        }
    }

    function stopAutoRefresh() {
        clearInterval(refreshInterval);
        refreshInterval = null;
    }

    /* -----------------------------------------
       LOAD RESERVATIONS
    ----------------------------------------- */
    function loadUserReservations() {
        if (isEditing) return;

        const data = new FormData();
        data.append("action", "tour_get_reservations");
        data.append("nonce", tour_ajax.nonce);

        fetch(tour_ajax.ajax_url, { method: "POST", body: data })
            .then(res => res.json())
            .then(res => {
                const container = document.getElementById("user-reservations");
                if (!container) return;

                if (!res.success) {
                    container.innerHTML = `<p>${res.data.message}</p>`;
                    return;
                }

                const reservations = res.data.reservations;
                timeSlots = res.data.time_slots;

                if (!reservations.length) {
                    container.innerHTML = "<p>No reservations found.</p>";
                    return;
                }

                let html = '<ul class="reservation-list">';
                reservations.forEach(r => {
                    html += `
                        <li class="reservation" data-id="${r.id}">
                            <strong>Date:</strong> <span class="date-text">${r.reservation_date}</span>,
                            <strong>Time:</strong> <span class="time-text">${r.reservation_time}</span>,
                            <strong>Members:</strong> <span class="members-text">${r.member_count}</span>,
                            <strong>Status:</strong> <span class="status-text">${r.status}</span>
                            <button class="edit-res">Edit</button>
                            <button class="cancel-reservation">Cancel</button>
                        </li>
                    `;
                });
                html += "</ul>";
                container.innerHTML = html;
            });
    }

    window.loadUserReservations = loadUserReservations;

    /* -----------------------------------------
       LOGIN / REGISTER
    ----------------------------------------- */
    const loginForm = document.getElementById("tour-login-register-form");
    if (loginForm) {
        loginForm.addEventListener("submit", function(e){
            e.preventDefault();

            const data = new FormData();
            data.append("action", "tour_register_login");
            data.append("nonce", tour_ajax.nonce);
            data.append("email", document.getElementById("email").value);
            data.append("password", document.getElementById("password").value);

            fetch(tour_ajax.ajax_url, { method: "POST", body: data })
                .then(res => res.json())
                .then(response => {
                    if(response.success){
                        alert(response.data.message);

                        // Remove login form
                        loginForm.remove();

                        // Inject reservation form
                        injectReservationForm();

                        // Load reservations
                        loadUserReservations();
                        startAutoRefresh();
                    } else {
                        alert(response.data.message);
                    }
                });
        });
    }

    /* -----------------------------------------
       INJECT RESERVATION FORM
    ----------------------------------------- */
    function injectReservationForm() {
        const html = `
<form id="tour-reservation-form" method="post">
    <input type="date" id="reservation_date" name="reservation_date" required>
    <input type="hidden" id="reservation_time" name="reservation_time" required>

    <div id="time-buttons">
        ${timeSlots.map(t => `<button type="button" class="time-btn" data-time="${t}">${t}</button>`).join('')}
    </div>

    <input type="number" id="member_count" name="member_count" min="1" value="1" required>
    <button type="submit">Book Reservation</button>
</form>
<h2>My Reservations</h2>
<div id="user-reservations">
    <p>Loading reservations...</p>
</div>
        `;
        document.body.insertAdjacentHTML('beforeend', html);

        attachReservationFormHandler();
        attachTimeButtonsHandler();
    }

    /* -----------------------------------------
       RESERVATION FORM SUBMIT
    ----------------------------------------- */
    function attachReservationFormHandler() {
        const form = document.getElementById("tour-reservation-form");
        if (!form) return;

        form.addEventListener("submit", function(e){
            e.preventDefault();

            const data = new FormData();
            data.append("action", "tour_reservation");
            data.append("nonce", tour_ajax.nonce);
            data.append("reservation_date", document.getElementById("reservation_date").value);
            data.append("reservation_time", document.getElementById("reservation_time").value);
            data.append("member_count", document.getElementById("member_count").value);

            fetch(tour_ajax.ajax_url, { method: "POST", body: data })
                .then(res => res.json())
                .then(response => {
                    if(response.success){
                        form.reset();
                        loadUserReservations();
                    } else {
                        alert(response.data.message);
                    }
                });
        });
    }

    /* -----------------------------------------
       TIME BUTTONS FOR RESERVATION FORM
    ----------------------------------------- */
    function attachTimeButtonsHandler() {
        document.querySelectorAll("#time-buttons .time-btn").forEach(btn => {
            btn.addEventListener("click", e => {
                document.getElementById("reservation_time").value = btn.dataset.time;
                document.querySelectorAll("#time-buttons .time-btn").forEach(b => b.classList.remove("active"));
                btn.classList.add("active");
            });
        });
    }

    /* -----------------------------------------
       EVENT DELEGATION: EDIT / UPDATE / CANCEL
    ----------------------------------------- */
    document.addEventListener("click", function(e){
        const li = e.target.closest("li.reservation");
        if (!li) return;

        /* ---------- ENTER EDIT MODE ---------- */
        if (e.target.classList.contains("edit-res")) {
            stopAutoRefresh();
            isEditing = true;

            const date = li.querySelector(".date-text").textContent;
            const time = li.querySelector(".time-text").textContent;
            const members = li.querySelector(".members-text").textContent;

            let timeBtns = "";
            timeSlots.forEach(t => {
                timeBtns += `<button type="button" class="edit-time-btn ${t === time ? 'active' : ''}" data-time="${t}">${t}</button>`;
            });

            li.innerHTML = `
                <div class="edit-block">
                    <label>Date:</label>
                    <input type="date" class="edit-date" value="${date}">

                    <label>Time:</label>
                    <div class="edit-time-buttons">${timeBtns}</div>
                    <input type="hidden" class="edit-time" value="${time}">

                    <label>Members:</label>
                    <input type="number" class="edit-members" min="1" value="${members}">

                    <button class="update-reservation">Update</button>
                    <button class="cancel-edit">Cancel Edit</button>
                </div>
            `;
        }

        /* ---------- TIME BUTTON SELECT ---------- */
        if (e.target.classList.contains("edit-time-btn")) {
            const block = e.target.closest(".edit-block");
            block.querySelectorAll(".edit-time-btn").forEach(btn => btn.classList.remove("active"));
            e.target.classList.add("active");
            block.querySelector(".edit-time").value = e.target.dataset.time;
        }

        /* ---------- CANCEL EDIT ---------- */
        if (e.target.classList.contains("cancel-edit")) {
            isEditing = false;
            startAutoRefresh();
            loadUserReservations();
        }

        /* ---------- UPDATE RESERVATION ---------- */
        if (e.target.classList.contains("update-reservation")) {
            const data = new FormData();
            data.append("action", "tour_update_reservation");
            data.append("nonce", tour_ajax.nonce);
            data.append("res_id", li.dataset.id);
            data.append("reservation_date", li.querySelector(".edit-date").value);
            data.append("reservation_time", li.querySelector(".edit-time").value);
            data.append("member_count", li.querySelector(".edit-members").value);

            fetch(tour_ajax.ajax_url, { method: "POST", body: data })
                .then(res => res.json())
                .then(() => {
                    isEditing = false;
                    startAutoRefresh();
                    loadUserReservations();
                });
        }

        /* ---------- CANCEL RESERVATION ---------- */
        if (e.target.classList.contains("cancel-reservation")) {
            if (!confirm("Are you sure?")) return;

            const data = new FormData();
            data.append("action", "tour_cancel_reservation");
            data.append("nonce", tour_ajax.nonce);
            data.append("res_id", li.dataset.id);

            fetch(tour_ajax.ajax_url, { method: "POST", body: data })
                .then(res => res.json())
                .then(() => {
                    loadUserReservations();
                });
        }

    });

    /* -----------------------------------------
       INITIAL LOAD
    ----------------------------------------- */
    if (document.getElementById("tour-reservation-form")) {
        attachReservationFormHandler();
        attachTimeButtonsHandler();
        loadUserReservations();
        startAutoRefresh();
    }

});
