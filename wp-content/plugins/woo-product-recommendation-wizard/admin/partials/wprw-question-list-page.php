<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
require_once('header/plugin-header.php');
global $wpdb;

$wizard_id = $_REQUEST['wrd_id'];
$question_id = $_REQUEST['que_id'];
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete') {
    $retrieved_nonce = $_REQUEST['_wpnonce'];
    if (!wp_verify_nonce($retrieved_nonce, 'wppfcnonce')) {
        die('Failed security check');
    }
    $questions_table_name = $wpdb->prefix . 'questions';
    $delete_sql = $wpdb->delete($questions_table_name, array('id' => $question_id, 'wizard_id' => $wizard_id), array('%d', '%d'));
    if ($delete_sql = '1') {
        wp_redirect(home_url('/wp-admin/admin.php?page=wprw-question-list&wrd_id=' . $wizard_id . ''));
        exit;
    } else {
        echo 'Error Happens.Please try again';
        wp_redirect(home_url('/wp-admin/admin.php?page=wprw-question-list&wrd_id=' . $wizard_id . ''));
    }
}
$questions_table_name = $wpdb->prefix . 'questions';
$sel_qry = "";
$sel_qry .= "SELECT *";
$sel_qry .= " FROM " . $questions_table_name;
$sel_qry .= " WHERE  wizard_id=" . "'" . $wizard_id . "'";
$sel_rows = $wpdb->get_results($sel_qry);

wp_nonce_field('delete');
?>
<div class="wprw-main-table res-cl">
    <div class="product_header_title">
        <h2>
            <?php _e(WPRW_QUESTION_LIST_PAGE_TITLE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
            <a class="add-new-btn"  href="<?php echo home_url('/wp-admin/admin.php?page=wprw-add-new-question&wrd_id=' . $wizard_id . ''); ?>"><?php _e(WPRW_ADD_NEW_QUESTION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
            <a id="detete-conditional-fee" class="detete-conditional-fee button-primary"><?php _e(WPRW_DELETE_QUESTION_LIST_NAME, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
        </h2>
    </div>
    <table id="conditional-fee-listing" class="table-outer form-table conditional-fee-listing tablesorter">
        <thead>
            <tr class="wprw-head">
                <th><input type="checkbox" name="check_all" class="condition-check-all" id="delete_all_record"></th>
                <th><?php _e('Name', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></th>
                <th><?php _e('Type', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></th>
                <th><?php _e('Action', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($sel_rows)) {
                $i = 1;
                foreach ($sel_rows as $sel_data) {
                    $question_id = $sel_data->id;
                    $wizard_id = $sel_data->wizard_id;
                    $question_name = $sel_data->name;
                    $question_type = ucfirst($sel_data->option_type);
                    $wprwnonce = wp_create_nonce('wppfcnonce');
                    ?>
                    <tr>
                        <td width="10%">
                            <input type="checkbox" class="multiple_delete_option" name="multiple_delete_option[]" value="<?php echo $question_id; ?>">
                        </td>
                        <td>
                            <a href="<?php echo home_url('/wp-admin/admin.php?page=wprw-edit-question&wrd_id=' . $wizard_id . '&id=' . $question_id . '&action=edit' . '&_wpnonce=' . $wprwnonce); ?>"><?php _e($question_name, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                        </td>
                        <td>
                            <?php echo $question_type; ?>
                        </td>
                        <td>
                            <a class="fee-action-button button-primary" href="<?php echo home_url('/wp-admin/admin.php?page=wprw-options-list&wrd_id=' . $wizard_id . '&id=' . $question_id . '&action=edit' . '&_wpnonce=' . $wprwnonce); ?>"><?php _e('Manage Options', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                            <a class="fee-action-button button-primary" href="<?php echo home_url('/wp-admin/admin.php?page=wprw-edit-question&wrd_id=' . $wizard_id . '&id=' . $question_id . '&action=edit' . '&_wpnonce=' . $wprwnonce); ?>"><?php _e('Edit', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                            <a class="fee-action-button button-primary" href="<?php echo home_url('/wp-admin/admin.php?page=wprw-question-list&wrd_id=' . $wizard_id . '&id=' . $question_id . '&action=delete' . '&_wpnonce=' . $wprwnonce); ?>"><?php _e('Delete', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
            }
            ?>
        </tbody>
    </table>
</div>
<?php require_once('header/plugin-sidebar.php'); ?>