<?php
get_header();

        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $userinfo = get_userdata($user_id);
            $author = $userinfo->user_login;
            $author_email = $userinfo->user_email;
            include_once 'add-reivew-design.php';
        } else {
?>
<div class="review-msg"><h3>You Must Login To Give Review... </h3> <a href="http://localhost/woocommerce/my-account" class="button" id="login">Login</a></div><br><br>
<?php
        }
        
        include_once 'display-review-design.php';
        
get_footer();
