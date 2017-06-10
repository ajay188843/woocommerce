<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id = "reviews" class = "woocommerce-Reviews">
    <div class = "review_form_wrapper">
        <div id = "review_form">
            <div id = "respond" class = "comment-respond">
                <span id = "reply-title" class = "comment-reply-title">Add a review
                    <small><a href = "" rel = "nofollow" id = "cancel-comment-reply-link" style = "display:none;">Cancel reply</a></small>
                </span>
                <form class = "comment-form" action="" method = "POST" id = "commentform">
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
    </div>
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
