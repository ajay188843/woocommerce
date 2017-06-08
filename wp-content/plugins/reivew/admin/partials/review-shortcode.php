<h1> Reviews Shortcode </h1>
<?php
$args = array(
    'post_id' => 1,
    'comment_type' => 'author'
);
$comments = get_comments($args);
?>
<br>
Select Author : <select name="author[]">
    <?php    foreach ($comments as $comment): ?>
    <option value=""><?php echo $comment->comment_author; ?></option>
  <?php  endforeach; ?>
</select>