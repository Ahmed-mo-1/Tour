jQuery(document).ready(function($) {

    console.log("RS AJAX JS loaded"); // check if JS is running

    // LOGIN
    $("#rs_login_btn").click(function() {
        console.log("Login clicked");
        $.post(RS_AJAX_OBJ.ajaxurl, {
            action: "rs_login",
            email: $("#rs_login_email").val(),
            password: $("#rs_login_password").val()
        }, function(res) {
            $("#rs-message").html(res.message);
            if (res.success) location.reload();
        }, "json");
    });

    // REGISTER
    $("#rs_register_btn").click(function() {
        console.log("Register clicked");
        $.post(RS_AJAX_OBJ.ajaxurl, {
            action: "rs_register",
            name: $("#rs_reg_name").val(),
            email: $("#rs_reg_email").val(),
            password: $("#rs_reg_password").val()
        }, function(res) {
            $("#rs-message").html(res.message);
            if (res.success) location.reload();
        }, "json");
    });

    // RESERVATION
    $("#rs_reserve_btn").click(function() {
        console.log("Reserve clicked");
        $.post(RS_AJAX_OBJ.ajaxurl, {
            action: "rs_reservation",
            res_date: $("#rs_res_date").val(),
            res_time: $("#rs_res_time").val(),
            members: $("#rs_res_members").val()
        }, function(res) {
            $("#rs-message").html(res.message);
        }, "json");
    });

});
