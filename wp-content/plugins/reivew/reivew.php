<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.linkedin.com/in/ajay-ghaghretiya/
 * @since             1.0.0
 * @package           Reivew
 *
 * @wordpress-plugin
 * Plugin Name:       Review
 * Plugin URI:        store.multidots.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Ajay
 * Author URI:        https://www.linkedin.com/in/ajay-ghaghretiya/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       reivew
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-reivew-activator.php
 */
function activate_reivew() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-reivew-activator.php';
    Reivew_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-reivew-deactivator.php
 */
function deactivate_reivew() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-reivew-deactivator.php';
    Reivew_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_reivew');
register_deactivation_hook(__FILE__, 'deactivate_reivew');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-reivew.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_reivew() {

    $plugin = new Reivew();
    $plugin->run();
}

run_reivew();

function elegance_referal_init() {
    if (is_page('review')) {
        $dir = plugin_dir_path(__FILE__);
        include($dir . "public/partials/reivew-public-display.php");
        die();
    }
}

add_action('wp', 'elegance_referal_init');

add_action('admin_menu', 'my_menu_pages');

function my_menu_pages() {
    add_menu_page('Reviews', 'Reviews Page', 'manage_options', 'my-top-level-slug', 'admin_review_page', plugins_url() . '/reivew/star.png', 45);
    add_submenu_page('my-top-level-slug', 'Pending Reviews', 'Pending Reviews', 'manage_options', 'my-top-level-slug');
    add_submenu_page('my-top-level-slug', 'Reviews Shortcode', 'Reviews Shortcode', 'manage_options', 'my-secondary-slug', 'admin_shortcode_page');
}

function admin_review_page() {
    include_once 'admin/partials/reivew-admin-display.php';
}

function admin_shortcode_page() {
    include_once 'admin/partials/review-shortcode.php';
}

add_action('admin_footer', 'mycss');

function mycss() {
    echo '<style>' . '
    #adminmenu .wp-menu-image img {
    padding: 9px 0 0;
    opacity: .6;
    height: 23px;
    width: 27px;
    filter: alpha(opacity=60)' . '</style>';
}

add_shortcode("review_shortcode", "review_shortcode_func");

function review_shortcode_func($atts) {
    $atts = shortcode_atts(array(
        'author' => 'no author',
            ), $atts, 'review_shortcode');
    
    $author = explode(',', $atts['author']);
    $args = array(
        'post_id' => 1,
        'comment_type' => 'author',
        'user_id' => $author,
    );
    $comments = get_comments($args);
    ?>
    <div class = "comments">
        <h2 class = "woocommerce-Reviews-title">1 review for <span>lenovo G-580</span></h2>
        <ol class = "commentlist" style = "list-style:none;">
            <li class = "comment byuser comment-author-admin bypostauthor even thread-even depth-1" id = "li-comment-33">
                <?php
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
                ?>
            </li>
        </ol>
    </div>
    <?php
}
