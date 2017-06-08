<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
require_once('header/plugin-header.php');
global $wpdb;
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete') {
    $wizard_post_id = $_REQUEST['wrd_id'];
    $retrieved_nonce = $_REQUEST['_wpnonce'];
    if (!wp_verify_nonce($retrieved_nonce, 'wppfcnonce')) {
        die('Failed security check');
    }
    $wizard_table_name = $wpdb->prefix . 'wizard';
    $delete_sql = $wpdb->delete($wizard_table_name, array('id' => $wizard_post_id), array('%d'));
    if ($delete_sql = '1') {
        wp_redirect(home_url('/wp-admin/admin.php?page=wprw-list'));
        exit;
    } else {
        echo 'Error Happens.Please try again';
        wp_redirect(home_url('/wp-admin/admin.php?page=wprw-list'));
    }
}
$wizard_table_name = $wpdb->prefix . 'wizard';
$sel_qry = "";
$sel_qry .= "SELECT *";
$sel_qry .= " FROM " . $wizard_table_name;
$sel_rows = $wpdb->get_results($sel_qry);

wp_nonce_field('delete');
?>
<div class="wprw-main-table res-cl">
    <div class="product_header_title">
        <h2>
            <?php _e(WPRW_LIST_PAGE_TITLE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
            <a class="add-new-btn"  href="<?php echo home_url('/wp-admin/admin.php?page=wprw-add-new'); ?>"><?php _e(WPRW_ADD_NEW_WIZARD, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
            <a id="detete_all_selected_wizard" class="detete_all_select_wizard_list button-primary" href="javascript:void(0);"><?php _e(WPRW_DELETE_LIST_NAME, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
        </h2>
    </div>
    <table id="conditional-fee-listing" class="table-outer form-table conditional-fee-listing tablesorter">
        <thead>
            <tr class="wprw-head">
                <th><input type="checkbox" name="check_all" class="chk_all_wizard_class" id="chk_all_wizard"></th>
                <th><?php _e('Name', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></th>
                <th><?php _e('Shortcode', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></th>
                <th><?php _e('Status', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></th>
                <th><?php _e('Action', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($sel_rows)) {
                $i = 1;
                foreach ($sel_rows as $sel_data) {
                    $wizard_id = $sel_data->id;
                    $wizard_title = $sel_data->name;
                    $wizard_shortcode = $sel_data->shortcode;
                    $wizard_status = $sel_data->status;
                    $wprwnonce = wp_create_nonce('wppfcnonce');
                    ?>
                    <tr id="wizard_row_<?php echo $wizard_id; ?>">
                        <td width="10%">
                            <input type="checkbox" class="chk_single_wizard" name="chk_single_wizard_chk" value="<?php echo $wizard_id; ?>">
                        </td>
                        <td>
                            <a href="<?php echo home_url('/wp-admin/admin.php?page=wprw-edit-wizard&wrd_id=' . $wizard_id . '&action=edit' . '&_wpnonce=' . $wprwnonce); ?>"><?php _e($wizard_title, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                        </td>
                        <td>
                            <?php echo $wizard_shortcode; ?>
                        </td>
                        <td>
                            <?php echo (isset($wizard_status) && $wizard_status == 'on') ? '<span class="active-status">' . _e('Enabled', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN) . '</span>' : '<span class="inactive-status">' . _e('Disabled', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN) . '</span>'; ?>
                        </td>
                        <td>
                            <a class="fee-action-button button-primary" href="<?php echo home_url('/wp-admin/admin.php?page=wprw-edit-wizard&wrd_id=' . $wizard_id . '&action=edit' . '&_wpnonce=' . $wprwnonce); ?>"><?php _e('Edit', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                            <a class="fee-action-button button-primary" href="<?php echo home_url('/wp-admin/admin.php?page=wprw-list&wrd_id=' . $wizard_id . '&action=delete' . '&_wpnonce=' . $wprwnonce); ?>"><?php _e('Delete', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
            } else {
                ?>
                <tr>
                    <td colspan="5">
                        <?php echo 'No List Available'; ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
<?php require_once('header/plugin-sidebar.php'); ?>