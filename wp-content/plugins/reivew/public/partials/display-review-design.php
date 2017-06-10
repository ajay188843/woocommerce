<div class = "comments">
    <h3 class = "woocommerce-Reviews-title1"><span>Average Ratings</span>
        <div class = "star-rating" style = "float:right;">
            <span style = "width:80%">
                <fieldset class = "rating" style="margin-bottom: 0px;padding: 0px;">
                    <input type = "radio" id = "star5" name = "avg_rating" value = "<?php echo $avg_ratings; ?>" <?php if ($avg_ratings == 5) echo checked; ?>  /><label class = "full" for = "star5" title = "Awesome - 5 stars"></label>
                    <input type = "radio" id = "star4" name = "avg_rating" value = "<?php echo $avg_ratings; ?>" <?php if ($avg_ratings == 4) echo checked; ?> /><label class = "full" for = "star4" title = "Pretty good - 4 stars"></label>
                    <input type = "radio" id = "star3" name = "avg_rating" value = "<?php echo $avg_ratings; ?>" <?php if ($avg_ratings == 3) echo checked; ?> /><label class = "full" for = "star3" title = "Meh - 3 stars"></label>
                    <input type = "radio" id = "star2" name = "avg_rating" value = "<?php echo $avg_ratings; ?>" <?php if ($avg_ratings == 2) echo checked; ?> /><label class = "full" for = "star2" title = "Kinda bad - 2 stars"></label>
                    <input type = "radio" id = "star1" name = "avg_rating" value = "<?php echo $avg_ratings; ?>" <?php if ($avg_ratings == 1) echo checked; ?> /><label class = "full" for = "star1" title = "Sucks big time - 1 star"></label>
                </fieldset>
            </span>
        </div>
    </h3>
    <ol class = "commentlist" style = "list-style:none;">
        <li class = "comment byuser comment-author-admin bypostauthor even thread-even depth-1" id = "li-comment-33">
            <?php
            if (isset($user_id)) {
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
            $count = 0;
            foreach ($comments as $comment) :
                $ratings = get_comment_meta($comment->comment_ID, 'rating', TRUE);
                $total_ratings += $ratings;
                ?>
                <div id = "comment-33" class = "comment_container" style="width: 100%; float: left; margin: 5px;">
                    <?php echo get_avatar($comment->comment_author_email, 50); ?>
                    <div class = "comment-text" style = "width: 95%; float: right; padding:8px; border: 1px solid;  border: 1px solid #00aadc; border-radius: 10px">
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
     $avg_ratings = round($total_ratings / $count);
            //echo $avg_ratings;
            ?>
        </li>
    </ol>
</div>