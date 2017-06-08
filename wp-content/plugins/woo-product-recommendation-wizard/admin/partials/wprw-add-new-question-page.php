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
if (!empty($_REQUEST['que_id'])) {
    $question_id = $_REQUEST['que_id'];
} else {
    $question_id = '';
}
if (!empty($_REQUEST['opt_id'])) {
    $options_id = $_REQUEST['opt_id'];
} else {
    $options_id = '';
}
if (isset($_POST['submitWizardQuestion']) && $_POST['submitWizardQuestion'] == 'Submit') {
    $post = $_POST;
    $retrieved_nonce = $_REQUEST['_wpnonce'];
    if (!wp_verify_nonce($retrieved_nonce, 'wizardquestionfrm')) {
        die('Failed security check');
    }
    $this->wprw_wizard_question_save($post, $wizard_id);
} elseif (isset($_POST['submitWizardQuestion']) && $_POST['submitWizardQuestion'] == 'Update') {
    $post = $_POST;
    $retrieved_nonce = $_REQUEST['_wpnonce'];
    if (!wp_verify_nonce($retrieved_nonce, 'wizardquestionfrm')) {
        die('Failed security check');
    }
    $this->wprw_wizard_question_save($post, $wizard_id);
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit') {
    $btnValue = __('Update', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN);
    $questions_table_name = $wpdb->prefix . 'questions';
    $get_qry = "";
    $get_qry .= "SELECT *";
    $get_qry .= " FROM " . $questions_table_name;
    $get_qry .= " WHERE id=" . "'" . $question_id . "'";
    $get_qry .= " AND wizard_id=" . "'" . $wizard_id . "'";
    $get_rows = $wpdb->get_row($get_qry);
    if (!empty($get_rows)) {
        $get_wizard_id = $get_rows->id;
        $question_name = $get_rows->name;
        $question_type = $get_rows->option_type;
    }
} else {
    $btnValue = __('Submit', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN);
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete') {
    $retrieved_nonce = $_REQUEST['_wpnonce'];
    if (!wp_verify_nonce($retrieved_nonce, 'wizardquestionfrm')) {
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

################# Options save ######################
if (isset($_POST['submitOptions']) && $_POST['submitOptions'] == 'Submit') {
    $post = $_POST;
    $retrieved_nonce = $_REQUEST['_wpnonce'];
    if (!wp_verify_nonce($retrieved_nonce, 'wizardoptionsfrm')) {
        die('Failed security check');
    }
    $this->wprw_wizard_options_save($post, $wizard_id, $question_id);
} elseif (isset($_POST['submitOptions']) && $_POST['submitOptions'] == 'Update') {
    $post = $_POST;
    $retrieved_nonce = $_REQUEST['_wpnonce'];
    if (!wp_verify_nonce($retrieved_nonce, 'wizardoptionsfrm')) {
        die('Failed security check');
    }
    $this->wprw_wizard_options_save($post, $wizard_id, $question_id);
}

$questions_options_table_name = $wpdb->prefix . 'questions_options';
$sel_options_qry = "";
$sel_options_qry .= "SELECT *";
$sel_options_qry .= " FROM " . $questions_options_table_name;
$sel_options_qry .= " WHERE  wizard_id=" . "'" . $wizard_id . "'";
$sel_options_qry .= " AND  question_id=" . "'" . $question_id . "'";
$sel_options_qry .= " ORDER BY id ASC";
$sel_options_rows = $wpdb->get_results($sel_options_qry);
//$total_options = $sel_options_rows->num_rows;
$total_options_count = count($sel_options_rows);
if ($total_options_count != "0" && $total_options_count != "") {
    $total_options_count = count($total_options_count);
} else {
    $total_options_count = '0';
}

$testObject = new Woo_Product_Recommendation_Wizard_Admin($this->plugin_name, $this->version);
$attributeValueArray = explode(',', $testObject->get_woocommerce_product_attribute_value_list());
$fetchSelecetedAttributeValue = !empty(array_map('trim',$attributeValueArray)) ? array_map('trim',$attributeValueArray) : '';
//echo '<pre>';
//print_r($fetchSelecetedAttributeValue);
//echo '</pre>';
$attributeNameArray = explode(',', $testObject->get_woocommerce_product_attribute_name_list());
$fetchSelecetedAttributeName = !empty($attributeNameArray) ? $attributeNameArray : '';
?>
<div class="wprw-main-table res-cl">
    <h2><?php _e('Question Configuration', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></h2>
    <form method="POST" name="wizardquestionfrm" action="">
        <?php wp_nonce_field('wizardquestionfrm'); ?>
        <input type="hidden" name="question_id" value="<?php echo $question_id ?>">
        <table class="form-table table-outer product-fee-table">
            <tbody>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="question_name"><?php _e(WPRW_WIZARD_QUESTION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?><span class="required-star">*</span></label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="question_name" class="text-class" id="question_name" value="<?php echo isset($question_name) ? $question_name : ''; ?>" required="1" placeholder="<?php _e(WPRW_WIZARD_QUESTION_PLACEHOLDER, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>">
                        <span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php _e(WPRW_WIZARD_QUESTION_DESCRIPTION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="question_type"><?php _e(WPRW_WIZARD_QUESTION_TYPE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></label>
                    </th>
                    <td class="forminp mdtooltip">
                        <div class="product_cost_left_div">
                            <select name="question_type" id="question_type" class="">
                                <option value="radio" <?php echo isset($question_type) && $question_type == 'radio' ? 'selected="selected"' : '' ?>><?php _e(WPRW_WIZARD_QUESTION_TYPE_RADIO, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></option>
                                <option value="checkbox" <?php echo isset($question_type) && $question_type == 'checkbox' ? 'selected="selected"' : '' ?>><?php _e(WPRW_WIZARD_QUESTION_TYPE_CHECKBOX, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></option>
                            </select>
                            <span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                            <p class="description">
                                <?php _e(WPRW_WIZARD_QUESTION_TYPE_DESCRIPTION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                            </p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit"><input type="submit" name="submitWizardQuestion" class="button button-primary button-large" value="<?php echo $btnValue; ?>"></p>
    </form>

    <div class="product_header_title">
        <h2>
            <?php _e(WPRW_OPTIONS_LIST_PAGE_TITLE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
            <a class="add-new-btn"  id="add_new_options" href="javascript:void(0);"><?php _e(WPRW_ADD_NEW_OPTIONS, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
        </h2>
    </div>

    <form method="POST" name="wizardoptionsfrm" action="">
        <div id="accordion" class="accordian_custom_class">
            <?php wp_nonce_field('wizardoptionsfrm'); ?>
            <?php
            if (!empty($sel_options_rows) && $sel_options_rows != '') {
                foreach ($sel_options_rows as $sel_options_data) {
                    $options_id = $sel_options_data->id;
                    $wizard_id = $sel_options_data->wizard_id;
                    $question_id = $sel_options_data->question_id;
                    $option_name = $sel_options_data->option_name;
                    $option_image = $sel_options_data->option_image;
                    $option_attribute = $sel_options_data->option_attribute;
                    $option_attribute_value = explode(',', $sel_options_data->option_attribute_value);
                    $wprwnonce = wp_create_nonce('wppfcnonce');

                    if (!empty($option_image) && $option_image != '') {
                        $image_display_none = 'block';
                    } else {
                        $image_display_none = 'none';
                    }
                    ?>
                    <div class="options_rank_class" id="options_rank_<?php echo $options_id; ?>">
                        <input type="hidden" name="options_id[][<?php echo $options_id; ?>]" value="<?php echo $options_id ?>">
                        <h3><?php _e($option_name, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                            <a href="javascript:void(0);" class="remove_option_row delete" id="remove_option_<?php echo $options_id ?>">Remove</a>
                        </h3>
                        <div>
                            <table class="form-table table-outer product-fee-table" id="option_section">
                                <tbody>
                                    <tr valign="top">
                                        <th class="titledesc" scope="row">
                                            <label for="options_name"><?php _e(WPRW_WIZARD_OPTIONS, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?><span class="required-star">*</span></label>
                                        </th>
                                        <td class="forminp mdtooltip">
                                            <input type="text" name="options_name[][<?php echo $options_id; ?>]" class="text-class" id="options_name_id" value="<?php echo $option_name; ?>" required="1" placeholder="<?php _e(WPRW_WIZARD_OPTIONS_PLACEHOLDER, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>">
                                            <span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                                            <p class="description"><?php _e(WPRW_WIZARD_OPTIONS_DESCRIPTION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></p>
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th class="titledesc" scope="row">
                                            <label for="options_image"><?php _e(WPRW_WIZARD_OPTIONS_IMAGE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></label>
                                        </th>
                                        <td class="forminp mdtooltip option_image_section">
                                            <div class="product_cost_left_div">
                                                <a class="option_single_upload_file button" id="option_single_upload_file_id_<?php echo $options_id; ?>" uploader_title="<?php _e(WPRW_WIZARD_OPTIONS_SELECT_FILE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>" uploader_button_text="Include File"><?php _e(WPRW_WIZARD_OPTIONS_UPLOAD_IMAGE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                                                <a class="option_single_remove_file button" id="option_single_remove_file_id_<?php echo $options_id; ?>"><?php _e(WPRW_WIZARD_OPTIONS_REMOVE_IMAGE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                                                <span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                                                <p class="description"><?php _e(WPRW_WIZARD_OPTIONS_IMAGE_DESCRIPTION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></p>
                                            </div>
                                            <div class="option_image_div">
                                                <img class="option_single_image_src" id="option_single_image_src_id_<?php echo $options_id; ?>" name="option_single_image_name[][<?php echo $options_id; ?>]" style="display:<?php echo $image_display_none; ?>;" src="<?php echo $option_image; ?>" width="250px" height="100px"/>
                                                <input type="hidden" name="hf_option_single_image_src[][<?php echo $options_id; ?>]" id="hf_option_single_image_src_<?php echo $options_id; ?>" value="<?php echo $option_image; ?>">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th class="titledesc" scope="row">
                                            <label for="attribute_name"><?php _e(WPRW_WIZARD_ATTRIBUTE_NAME, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></label>
                                        </th>
                                        <td class="forminp mdtooltip">
                                            <select id="attribute_name_<?php echo $options_id; ?>" data-placeholder="<?php _e(WPRW_WIZARD_ATTRIBUTE_NAME_PLACEHOLDER, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>" name="attribute_name[][<?php echo $options_id; ?>]" class="chosen-select-attribute-value category-select chosen-rtl">
                                                <option value=""></option>
                                                <?php
                                                if (!empty($fetchSelecetedAttributeName) && $fetchSelecetedAttributeName != '') {
                                                    foreach ($fetchSelecetedAttributeName as $key => $values) {
                                                        ?>
                                                        <option value="<?php echo trim($values); ?>"><?php echo trim($values); ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                                            <p class="description"><?php _e(WPRW_WIZARD_ATTRIBUTE_NAME_DESCRIPTION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></p>
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th class="titledesc" scope="row">
                                            <label for="attributr_value"><?php _e(WPRW_WIZARD_ATTRIBUTE_VALUE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></label>
                                        </th>
                                        <td class="forminp mdtooltip">
                                            <select id="attribute_value_<?php echo $options_id; ?>" data-placeholder="<?php _e(WPRW_WIZARD_ATTRIBUTE_VALUE_PLACEHOLDER, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>" name="attribute_value[][<?php echo $options_id; ?>]" multiple="true" class="chosen-select-attribute-value category-select chosen-rtl">
                                                <option value=""></option>
                                                <?php
                                                if (!empty($fetchSelecetedAttributeValue) && $fetchSelecetedAttributeValue != '') {
                                                    foreach (array_unique($fetchSelecetedAttributeValue) as $key => $values) {
                                                        ?>
                                                        <option value="<?php echo trim($values); ?>"><?php echo trim($values); ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                                            <p class="description"><?php _e(WPRW_WIZARD_ATTRIBUTE_VALUE_DESCRIPTION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <p class="submit" id="submit_options"><input type="submit" name="submitOptions" class="button button-primary button-large" value="<?php echo $btnValue; ?>"></p>
        </div>
    </form>
</div>

<?php
require_once('header/plugin-sidebar.php');
?>