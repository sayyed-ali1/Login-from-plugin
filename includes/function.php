<?php

function my_login_form() {

    if (is_user_logged_in()) {
        return "<p style='margin-bottom: 0px; text-align: center; align-items: start;'>You are logged in ✅</p>";
    }

    return '
    <form id="loginForm" style="background-color: #ecece9; padding: 40px 25px; border-radius: 15px;">
    <label for="username">Username or Email:</label><br>  
    <input type="text" name="username" placeholder="Username or Email" required><br><br>
    <label for="password">Password:</label><br>
    <input type="password" name="password" placeholder="Password" required><br><br>

        <button type="submit" id="loginBtn">Login</button>

        <div class="login-result" style="margin-top:15px;"></div>
    </form>
    ';
}
add_shortcode('mylogin', 'my_login_form');


function my_logout_button() {

    if (!is_user_logged_in()) return '';

    return '<a style="background-color: #05599d; color: white; text-decoration: none;  border-radius: 10px; padding: 14px 29px;  cursor: pointer;" href="'. wp_logout_url(home_url()) .'">Logout</a>';
}
add_shortcode('mylogout', 'my_logout_button');


function handle_ajax_login() {

    // 🔐 NONCE CHECK
    check_ajax_referer('login_nonce', 'security');

    $creds = array();
    $creds['user_login'] = $_POST['username'];
    $creds['user_password'] = $_POST['password'];
    $creds['remember'] = true;

    // 🔥 LOGIN FUNCTION
    $user = wp_signon($creds, false);

    if (is_wp_error($user)) {
        echo "Invalid login details ❌";
    } else {
        echo "Login successful ✅";
    }

    wp_die();
}

add_action('wp_ajax_my_login', 'handle_ajax_login');
add_action('wp_ajax_nopriv_my_login', 'handle_ajax_login');


function my_login_scripts() {

    wp_enqueue_script(
        'login-js',
        plugin_dir_url(__FILE__) . '../assets/login.js',
        array('jquery'),
        false,
        true
    );

    wp_localize_script('login-js', 'login_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('login_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'my_login_scripts');


function my_dashboard() {

    if (!is_user_logged_in()) {
        return "<p style=''>Please login first ❌</p>";
    }

    $current_user = wp_get_current_user();

    ob_start();
    ?>

    <div class="dashboard">

        <h2 style="margin-bottom: 14px;">Welcome, <?php echo $current_user->display_name; ?> 👋</h2>

        <p style="margin-bottom: 10px;"><strong>Username:</strong> <?php echo $current_user->user_login; ?></p>
        <p style="margin-bottom: 20px;"><strong>Email:</strong> <?php echo $current_user->user_email; ?></p>

        <h3>Edit Profile</h3>

        <form id="profileForm">
            <input style="width:30%;  border: 1px solid #cec9c9;" type="text"  name="name" value="<?php echo $current_user->display_name; ?>" required><br><br>
            <input style="width:30%;  border: 1px solid #cec9c9;" type="email" name="email" value="<?php echo $current_user->user_email; ?>" required><br><br>

            <button type="submit">Update Profile</button>

            <div class="profile-result"></div>
        </form>

        <br>
<br>
<?php

global $wpdb;

$table_name = $wpdb->prefix . 'my_form_data';
$user_id = get_current_user_id();

$results = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM $table_name WHERE user_id = %d", $user_id)
);
?>

<h3>Your Entries 📋</h3>

<?php
if (!$results) {
    echo "<p>No entries found</p>";
} else {

    echo "<table border='1' cellpadding='10'>";
    echo "<tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Message</th>
          </tr>";

    foreach ($results as $row) {
        echo "<tr>
                <td>{$row->id}</td>
                <td>{$row->name}</td>
                <td>{$row->email}</td>
                <td>{$row->phone}</td>
                <td>{$row->message}</td>
              </tr>";
    }

    echo "</table>";
}
?>
        <?php echo do_shortcode('[mylogout]'); ?>

    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('mydashboard', 'my_dashboard');

function handle_profile_update() {

    check_ajax_referer('login_nonce', 'security');

    if (!is_user_logged_in()) {
        echo "Not logged in ❌";
        wp_die();
    }

    $user_id = get_current_user_id();
    

    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);

    if (empty($name) || empty($email)) {
        echo "All fields required ❌";
        wp_die();
    }

    wp_update_user(array(
        'ID' => $user_id,
        'display_name' => $name,
        'user_email' => $email
    ));

    echo "Profile updated successfully ✅";

    wp_die();
}

add_action('wp_ajax_update_profile', 'handle_profile_update');


