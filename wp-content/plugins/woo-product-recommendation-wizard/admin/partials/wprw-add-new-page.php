<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
require_once('header/plugin-header.php');
global $wpdb;

if (!empty($_REQUEST['wrd_id'])) {
    $wizard_id = $_REQUEST['wrd_id'];
} else {
    $wizard_id = '';
}
if (isset($_POST['submitWizard']) && $_POST['submitWizard'] == 'Submit') {
    $post = $_POST;

    $retrieved_nonce = $_REQUEST['_wpnonce'];
    if (!wp_verify_nonce($retrieved_nonce, 'wizardfrm')) {
        die('Failed security check');
    }

    $this->wprw_wizard_save($post);
} elseif (isset($_POST['submitWizard']) && $_POST['submitWizard'] == 'Update') {
    $post = $_POST;
    $retrieved_nonce = $_REQUEST['_wpnonce'];
    if (!wp_verify_nonce($retrieved_nonce, 'wizardfrm')) {
        die('Failed security check');
    }
    $this->wprw_wizard_save($post);
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit') {
    $btnValue = __('Update', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN);
    $wizard_table_name = $wpdb->prefix . 'wizard';
    $retrieved_nonce = $_REQUEST['_wpnonce'];
    $get_qry = "";
    $get_qry .= "SELECT *";
    $get_qry .= " FROM " . $wizard_table_name;
    $get_qry .= " WHERE id=" . "'" . $wizard_id . "'";
    $get_rows = $wpdb->get_row($get_qry);
    if (!empty($get_rows)) {
        $wizard_id = $get_rows->id;
        $wizard_title = $get_rows->name;
        $wizard_shortcode = $get_rows->shortcode;
        $wizard_status = $get_rows->status;
    }
} else {
    $btnValue = __('Submit', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN);
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete') {
    $question_id = $_REQUEST['id'];
    $retrieved_nonce = $_REQUEST['_wpnonce'];
    if (!wp_verify_nonce($retrieved_nonce, 'wppfcnonce')) {
        die('Failed security check');
    }
    $questions_table_name = $wpdb->prefix . 'questions';
    $delete_sql = $wpdb->delete($questions_table_name, array('id' => $question_id, 'wizard_id' => $wizard_id), array('%d', '%d'));
    if ($delete_sql == '1') {
        wp_redirect(home_url('/wp-admin/admin.php?page=wprw-edit-wizard&id=' . $wizard_id . '&action=edit&_wpnonce=' . $retrieved_nonce));
        exit;
    } else {
        echo 'Error Happens.Please try again';
        wp_redirect(home_url('/wp-admin/admin.php?page=wprw-question-list&wrd_id=' . $wizard_id . ''));
    }
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit') {
    $retrieved_nonce = $_REQUEST['_wpnonce'];
    $questions_table_name = $wpdb->prefix . 'questions';
    $sel_qry = "";
    $sel_qry .= "SELECT *";
    $sel_qry .= " FROM " . $questions_table_name;
    $sel_qry .= " WHERE  wizard_id=" . "'" . $wizard_id . "'";
    $sel_qry .= " ORDER BY id ASC";
    $sel_qry .= " LIMIT  0,2";
    $sel_rows = $wpdb->get_results($sel_qry);

    $limit = 2;
    /* Find the start depending on $_GET['page'] (declared if it's null) */

    $sel_page_qry = "";
    $sel_page_qry .= "SELECT COUNT(id) AS total_id";
    $sel_page_qry .= " FROM " . $questions_table_name;
    $sel_page_qry .= " WHERE  wizard_id=" . "'" . $wizard_id . "'";
    $page_result = $wpdb->get_row($sel_page_qry);
    $total_records = $page_result->total_id;
    $total_pages = ceil($total_records / $limit);

//    $page = 1;
//    $recordsPerPage = 2;
//    $start = ($page - 1) * $recordsPerPage;
//    $adjacents = "2";
//
//    $prev = $page - 1;
//    $next = $page + 1;
//    $lastpage = ceil($total_records / $recordsPerPage);
//    $lpm1 = $lastpage - 1;
//    $pagination = "";
}
?>
<div class="wprw-main-table res-cl">
    <h2><?php _e('Wizard Configuration', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></h2>
    <form method="POST" name="wizardfrm" action="">
        <?php wp_nonce_field('wizardfrm'); ?>
        <input type="hidden" name="wizard_post_id" value="<?php echo $wizard_id ?>">
        <table class="form-table table-outer product-fee-table">
            <tbody>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="wizard_title"><?php _e(WPRW_WIZARD_TITLE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?><span class="required-star">*</span></label></th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wizard_title" class="text-class" id="wizard_title" value="<?php echo isset($wizard_title) ? $wizard_title : ''; ?>" required="1" placeholder="<?php _e(WPRW_WIZARD_TITLE_PLACEHOLDER, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>">
                        <span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php _e(WPRW_WIZARD_TITLE_DESCRIPTION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="wizard_shortcode"><?php _e(WPRW_WIZARD_SHORTCODE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></label>
                    </th>
                    <td class="forminp mdtooltip">
                        <div class="product_cost_left_div">
                            <input type="text" name="wizard_shortcode" required="1" class="text-class" id="wizard_shortcode" value="<?php echo isset($wizard_shortcode) ? $wizard_shortcode : ''; ?>" readonly>
                            <span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                            <p class="description">
                                <?php _e(WPRW_WIZARD_SHORTCODE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                            </p>
                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="wizard_status"><?php _e(WPRW_WIZARD_STATUS, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></label></th>
                    <td class="forminp mdtooltip">
                        <label class="switch">
                            <input type="checkbox" name="wizard_status" value="on" <?php echo (isset($wizard_status) && $wizard_status == 'off') ? '' : 'checked'; ?>>
                            <div class="slider round"></div>
                        </label>
                    </td>
                </tr>	
            </tbody>
        </table>
        <p class="submit"><input type="submit" name="submitWizard" class="button button-primary button-large" value="<?php echo $btnValue; ?>"></p>
    </form>

    <?php
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit') {
        ?>
        <div class="product_header_title">
            <h2>
                <?php _e(WPRW_QUESTION_LIST_PAGE_TITLE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                <a class="add-new-btn"  href="<?php echo home_url('/wp-admin/admin.php?page=wprw-add-new-question&wrd_id=' . $wizard_id . '&_wpnonce=' . $retrieved_nonce); ?>"><?php _e(WPRW_ADD_NEW_QUESTION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                <a id="detete_all_selected_question" class="detete-conditional-fee button-primary"><?php _e(WPRW_DELETE_QUESTION_LIST_NAME, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
            </h2>
        </div>
        <div id="using_ajax">

        </div>
        <?php
    }
    ?>
</div>

<?php
require_once('header/plugin-sidebar.php');
?>