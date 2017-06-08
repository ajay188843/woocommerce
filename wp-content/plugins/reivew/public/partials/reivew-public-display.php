<?php
get_header();
?>
<style>

</style>
<?php
if (is_user_logged_in()) {
    $user_id = get_current_user_id();
    $userinfo = get_userdata($user_id);
    $author = $userinfo->user_login;
    $author_email = $userinfo->user_email;
}
?>
<body>
    <div id = "reviews" class = "woocommerce-Reviews">
        <div class = "review_form_wrapper">
            <div id = "review_form">
                <div id = "respond" class = "comment-respond">
                    <span id = "reply-title" class = "comment-reply-title">Add a review
                        <small><a href = "" rel = "nofollow" id = "cancel-comment-reply-link" style = "display:none;">Cancel reply</a></small>
                    </span>
                    <form class = "comment-form" action="<?php echo home_url('review'); ?>" method = "POST" id = "commentform">
                        <p class = "comment-notes">
                            <span class = "email-notes">Your email address will not be published.</span>
                            Required fields are marked
                            <span class = "required">*</span>
                        </p>
                        <label>username:</label><input type = "text" <?php if (isset($author)) echo "readonly"; ?>  value="<?php if (isset($author)) echo $author; ?>" name = "username"><br>
                        <label>Email:</label><input type = "text" <?php if (isset($author_email)) echo "readonly"; ?> value="<?php if (isset($author_email)) echo $author_email; ?>" name = "email"><br>
                        <label>Content Review:</label><textarea name = "content_review"></textarea><br>
                        <label>Rating:</label>
                        <fieldset class = "rating">
                            <input type = "radio" id = "star5" name = "rating" value = "5" /><label class = "full" for = "star5" title = "Awesome - 5 stars"></label>
                            <input type = "radio" id = "star4half" name = "rating" value = "4 and a half" /><label class = "half" for = "star4half" title = "Pretty good - 4.5 stars"></label>
                            <input type = "radio" id = "star4" name = "rating" value = "4" /><label class = "full" for = "star4" title = "Pretty good - 4 stars"></label>
                            <input type = "radio" id = "star3half" name = "rating" value = "3 and a half" /><label class = "half" for = "star3half" title = "Meh - 3.5 stars"></label>
                            <input type = "radio" id = "star3" name = "rating" value = "3" /><label class = "full" for = "star3" title = "Meh - 3 stars"></label>
                            <input type = "radio" id = "star2half" name = "rating" value = "2 and a half" /><label class = "half" for = "star2half" title = "Kinda bad - 2.5 stars"></label>
                            <input type = "radio" id = "star2" name = "rating" value = "2" /><label class = "full" for = "star2" title = "Kinda bad - 2 stars"></label>
                            <input type = "radio" id = "star1half" name = "rating" value = "1 and a half" /><label class = "half" for = "star1half" title = "Meh - 1.5 stars"></label>
                            <input type = "radio" id = "star1" name = "rating" value = "1" /><label class = "full" for = "star1" title = "Sucks big time - 1 star"></label>
                            <input type = "radio" id = "starhalf" name = "rating" value = "half" /><label class = "half" for = "starhalf" title = "Sucks big time - 0.5 stars"></label>
                        </fieldset>
                        <div id = "review-button">
                            <input type="submit" name="submit" value="Rating" id = "button-review">
                        </div>
                    </form>
                </div>
            </div>
        </div><br /><br />
        <div class = "comments">
            <h2 class = "woocommerce-Reviews-title">1 review for <span>lenovo G-580</span></h2>
            <ol class = "commentlist" style = "list-style:none;">
                <li class = "comment byuser comment-author-admin bypostauthor even thread-even depth-1" id = "li-comment-33">
                    <?php
                    display_review();

                    function display_review() {
                        if (is_user_logged_in()) {
                            $user_id = get_current_user_id();
                            $args = array(
                                'post_id' => 1,
                                'comment_type' => 'author',
                                'user_id' => $user_id,
                            );
                        } else {
                            $args = array(
                                'post_id' => 1,
                                'comment_type' => 'author',
                                'user_id' => '',
                            );
                        }
                        $comments = get_comments($args);
                        $count = 1;
                        foreach ($comments as $comment) :
                            $ratings = get_comment_meta($comment->comment_ID, 'rating', TRUE);
                            ?>
                            <div id = "comment-33" class = "comment_container" style="width: 100%; float: left; margin: 5px;">
        <?php echo get_avatar($comment->comment_author_email, 50); ?>
                                <div class = "comment-text" style = "width: 90%; float: right; padding:8px; border: 1px solid;  border: 1px solid #00aadc; border-radius: 10px">
                                    <div class = "star-rating" style = "float:right;">
                                        <span style = "width:80%">
                                            <fieldset class = "rating">
                                                <input type = "radio" id = "star5" name = "rating<?php echo $count; ?>" value = "<?php echo $ratings; ?>" <?php if ($ratings == 5) echo checked; ?>  /><label class = "full" for = "star5" title = "Awesome - 5 stars"></label>
                                                <input type = "radio" id = "star4" name = "rating<?php echo $count; ?>" value = "<?php echo $ratings; ?>" <?php if ($ratings == 4) echo checked; ?> /><label class = "full" for = "star4" title = "Pretty good - 4 stars"></label>
                                                <input type = "radio" id = "star3" name = "rating<?php echo $count; ?>" value = "<?php echo $ratings; ?>" <?php if ($ratings == 3) echo checked; ?> /><label class = "full" for = "star3" title = "Meh - 3 stars"></label>
                                                <input type = "radio" id = "star2" name = "rating<?php echo $count; ?>" value = "<?php echo $ratings; ?>" <?php if ($ratings == 2) echo checked; ?> /><label class = "full" for = "star2" title = "Kinda bad - 2 stars"></label>
                                                <input type = "radio" id = "star1" name = "rating<?php echo $count; ?>" value = "<?php echo $ratings; ?>" <?php if ($ratings == 1) echo checked; ?> /><label class = "full" for = "star1" title = "Sucks big time - 1 star"></label>
                                            </fieldset>
                                            <strong></strong>
                                        </span>
                                    </div>
                                    <p class = "meta">
                                        <strong style = "flot:left;" class = "woocommerce-review__author" itemprop = "author" ><?php echo $comment->comment_author; ?></strong>
                                        <span class = "woocommerce-review__dash">-</span>
                                        <time class = "woocommerce-review__published-date" itemprop = "datePublished" datetime = "2017-05-26T06:54:02+00:00"><?php echo $comment->post_date; ?></time>
                                    </p>
                                    <div class = "description">
                                        <p><?php echo $comment->comment_content; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $count++;
                        endforeach;
                        ?> <?php } ?>
                </li>
            </ol>
        </div>
    </div>
</body>
<?php
if (isset($_POST["submit"])) {

    if (!empty($_POST["email"]) && !empty($_POST["username"]) && !empty($_POST["content_review"])) {
        $author_name = $_POST["username"];
        $author_email = $_POST["email"];
        $author_review = $_POST["content_review"];
        $author_rating = $_POST["rating"];

        $time = current_time('mysql');

        $data = array(
            'comment_post_ID' => 1,
            'comment_author' => $author_name,
            'comment_author_email' => $author_email,
            'comment_author_url' => $author_email,
            'comment_content' => $author_review,
            'comment_type' => '',
            'comment_parent' => 0,
            'user_id' => $user_id,
            'comment_author_IP' => '127.0.0.1',
            'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
            'comment_date' => $time,
            'comment_approved' => 1,
            'comment_type' => 'author'
        );

        $id = wp_insert_comment($data);
        if (isset($id)) {
            update_comment_meta($id, 'rating', $author_rating);
            update_comment_meta($id, 'verified', 0);
        }
    }
}
?>

<?php
get_footer();
