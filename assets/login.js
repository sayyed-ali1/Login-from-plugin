jQuery(document).ready(function($){

    $('#loginForm').on('submit', function(e){
        e.preventDefault();

        var form = $(this);
        var btn = form.find('#loginBtn');

        var username = form.find('input[name="username"]').val().trim();
        var password = form.find('input[name="password"]').val().trim();

        var error = "";

        // VALIDATION
        if(username === "") error += "Username required<br>";
        if(password === "") error += "Password required<br>";

        if(error !== ""){
            form.find('.login-result').html("<div style='color:red;'>"+error+"</div>");
            return;
        }

        // LOADER
        btn.text("Logging in...");
        btn.prop("disabled", true);

        // AJAX
        $.post(login_obj.ajax_url, {
            action: 'my_login',
            username: username,
            password: password,
            security: login_obj.nonce
        }, function(response){

            if(response.includes("successful")) {

                form.find('.login-result').html("<div style='color:green;'>"+response+"</div>");

                // 🔥 REDIRECT
                if(response === "success") {
    window.location.href = "http://localhost/Fresh%20Wordpress/?page_id=94";
}

            } else {
                form.find('.login-result').html("<div style='color:red;'>"+response+"</div>");
            }

            btn.text("Login");
            btn.prop("disabled", false);

        });

    });

});


// PROFILE UPDATE
$('#profileForm').on('submit', function(e){
    e.preventDefault();

    var form = $(this);

    var name = form.find('input[name="name"]').val().trim();
    var email = form.find('input[name="email"]').val().trim();

    if(name === "" || email === ""){
        form.find('.profile-result').html("<div style='color:red;'>All fields required</div>");
        return;
    }

    $.post(login_obj.ajax_url, {
        action: 'update_profile',
        name: name,
        email: email,
        security: login_obj.nonce
    }, function(response){

        form.find('.profile-result').html("<div style='color:green;'>"+response+"</div>");

    });

});


