<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Woo_Product_Recommendation_Wizard
 * @subpackage Woo_Product_Recommendation_Wizard/admin
 */
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Product_Recommendation_Wizard
 * @subpackage Woo_Product_Recommendation_Wizard/admin
 * @author     Multidots <inquiry@multidots.in>
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

//require plugin_dir_path(__FILE__) . 'includes/constant.php';

class Woo_Product_Recommendation_Wizard_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woo_Product_Recommendation_Wizard_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woo_Product_Recommendation_Wizard_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        if (isset($_GET['page']) && !empty($_GET['page']) && ($_GET['page'] == 'wprw-list' || $_GET['page'] == 'wprw-add-new' || $_GET['page'] == 'wprw-premium' ||
                $_GET['page'] == 'wprw-get-started' || $_GET['page'] == 'wprw-information' || $_GET['page'] == 'wprw-edit-wizard' || $_GET['page'] == 'wprw-add-new-question' ||
                $_GET['page'] == 'wprw-question-list' || $_GET['page'] == 'wprw-edit-question' || $_GET['page'] == 'wprw-add-new-options')) {
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woo-product-recommendation-wizard-admin.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . 'main-style', plugin_dir_url(__FILE__) . 'css/style.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-jquery-ui-css', plugin_dir_url(__FILE__) . 'css/jquery-ui.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . 'font-awesome', plugin_dir_url(__FILE__) . 'css/font-awesome.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-webkit-css', plugin_dir_url(__FILE__) . 'css/webkit.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . 'media-css', plugin_dir_url(__FILE__) . 'css/media.css', array(), $this->version, 'all');
        }
        if (isset($_GET['page']) && !empty($_GET['page']) && ($_GET['page'] == 'wprw-add-new-options' || $_GET['page'] == 'wprw-add-new-question')) {
            wp_enqueue_style($this->plugin_name . 'chosen-css', plugin_dir_url(__FILE__) . 'css/chosen.css', array(), $this->version, 'all');
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woo_Product_Recommendation_Wizard_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woo_Product_Recommendation_Wizard_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        if (isset($_GET['page']) && !empty($_GET['page']) && ($_GET['page'] == 'wprw-list' || $_GET['page'] == 'wprw-add-new' || $_GET['page'] == 'wprw-premium' ||
                $_GET['page'] == 'wprw-get-started' || $_GET['page'] == 'wprw-information' || $_GET['page'] == 'wprw-edit-wizard' || $_GET['page'] == 'wprw-add-new-question' ||
                $_GET['page'] == 'wprw-question-list' || $_GET['page'] == 'wprw-edit-question' || $_GET['page'] == 'wprw-add-new-options')) {
            wp_enqueue_media();
            wp_enqueue_style('wp-jquery-ui-dialog');
            wp_enqueue_script('jquery-ui');
            wp_enqueue_script('jquery-ui-accordion');
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_script('productRecommendationWizard', plugin_dir_url(__FILE__) . 'js/woo-product-recommendation-wizard-admin.js', array('jquery', 'jquery-ui-dialog'), $this->version, false);
            wp_localize_script('productRecommendationWizard', 'adminajax', array('ajaxurl' => admin_url('admin-ajax.php'), 'ajax_icon' => plugin_dir_url(__FILE__) . '/images/ajax-loader.gif'));
            wp_enqueue_script($this->plugin_name . 'tablesorter', plugin_dir_url(__FILE__) . 'js/jquery.tablesorter.js', array('jquery'), $this->version, false);
        }
        if (isset($_GET['page']) && !empty($_GET['page']) && ($_GET['page'] == 'wprw-add-new-options' || $_GET['page'] == 'wprw-add-new-question')) {
            wp_enqueue_script('chosen_custom', plugin_dir_url(__FILE__) . 'js/chosen.jquery.js', array('jquery'), $this->version, false);
        }

        if (isset($_GET['page']) && !empty($_GET['page']) && ($_GET['page'] == 'wprw-add-new-question')) {
            ################ Option ID ######################
            $fetchOptionValueID = $this->get_woocommerce_options_id_from_database();
            $OptionValueIDArray = !empty($fetchOptionValueID) ? json_encode($fetchOptionValueID) : json_encode(array());
            wp_localize_script('chosen_custom', 'option_value_id', array('OptionValueIDArray' => $OptionValueIDArray));

            ################ Attribute Value ######################
            $attributeValueArrayFromDB = $this->get_woocommerce_attribute_value_from_database();
            if (!empty($attributeValueArrayFromDB) && $attributeValueArrayFromDB != '') {
                foreach ($attributeValueArrayFromDB as $key => $value) {
                    $value1 = explode(',', trim($value));
                    $fetchWooCoomerceOption = !empty($value1) ? $value1 : '';
                    wp_localize_script('chosen_custom', 'allAttributeValue' . $key, array(
                        'attribute_option_id' => 'attribute_option_' . $key,
                        'attributeOptionArray' => $fetchWooCoomerceOption
                    ));
                }
            }

            ################ Attribute Name ######################
            $fetchOptionNameFromDB = $this->get_woocommerce_options_name_from_database();
            if (!empty($fetchOptionNameFromDB) && $fetchOptionNameFromDB != '') {
                foreach ($fetchOptionNameFromDB as $key => $value) {
                    $fetchWooCoomerceAttributename = !empty($value) ? $value : '';
                    wp_localize_script('chosen_custom', 'allAttributename' . $key, array(
                        'attribute_name_id' => 'attribute_name_' . $key,
                        'attributeAttributeArray' => $fetchWooCoomerceAttributename
                    ));
                }
            }

            ################ Option Label Name Dynamically When Add New Option ######################
            wp_localize_script('chosen_custom', 'optionLabelDetails', array(
                'option_label' => json_encode(WPRW_WIZARD_OPTIONS),
                'option_lable_description' => json_encode(WPRW_WIZARD_OPTIONS_DESCRIPTION),
                'option_lable_placeholder' => json_encode(WPRW_WIZARD_OPTIONS_PLACEHOLDER),
                'option_image_lable' => json_encode(WPRW_WIZARD_OPTIONS_IMAGE),
                'option_image_select_file' => json_encode(WPRW_WIZARD_OPTIONS_SELECT_FILE),
                'option_image_upload_image' => json_encode(WPRW_WIZARD_OPTIONS_UPLOAD_IMAGE),
                'option_image_remove_image' => json_encode(WPRW_WIZARD_OPTIONS_REMOVE_IMAGE),
                'option_image_description' => json_encode(WPRW_WIZARD_OPTIONS_IMAGE_DESCRIPTION),
                'option_attribute_lable' => json_encode(WPRW_WIZARD_ATTRIBUTE_NAME),
                'option_attribute_description' => json_encode(WPRW_WIZARD_ATTRIBUTE_NAME_DESCRIPTION),
                'option_attribute_placeholder' => json_encode(WPRW_WIZARD_ATTRIBUTE_NAME_PLACEHOLDER),
                'option_value_lable' => json_encode(WPRW_WIZARD_ATTRIBUTE_VALUE),
                'option_value_description' => json_encode(WPRW_WIZARD_ATTRIBUTE_VALUE_DESCRIPTION),
                'option_value_placeholder' => json_encode(WPRW_WIZARD_ATTRIBUTE_VALUE_PLACEHOLDER)
            ));

            ################ All Attribute Name List Disply In Select Dropdwon When Add New Option ######################
            $fetchAttributeName = $this->get_woocommerce_product_attribute_name_list();
            $fetchAttributeNameWithExplode = explode(',', $fetchAttributeName);
            $fetchAllAttributeName = !empty($fetchAttributeNameWithExplode) ? $fetchAttributeNameWithExplode : '';
            $attributeArray = !empty($fetchAllAttributeName) ? json_encode($fetchAllAttributeName) : json_encode(array());
            wp_localize_script('chosen_custom', 'all_attribute_name', array('attributeArray' => $attributeArray));
        }
    }

    public function dot_store_menu_wprw() {
        global $GLOBALS;
        if (empty($GLOBALS['admin_page_hooks']['dots_store'])) {
            add_menu_page(
                    'DotStore Plugins', __('DotStore Plugins'), 'manage_option', 'dots_store', array($this, 'dot_store_menu_page'), WPRW_PLUGIN_URL . 'admin/images/menu-icon.png', 25
            );
        }
        add_submenu_page('dots_store', 'Get Started', 'Get Started', 'manage_options', 'wprw-get-started', array($this, 'wprw_get_started_page'));
        add_submenu_page('dots_store', 'Premium Version', 'Premium Version', 'manage_options', 'wprw-premium', array($this, 'premium_version_wprw_page'));
        add_submenu_page('dots_store', 'Introduction', 'Introduction', 'manage_options', 'wprw-information', array($this, 'wprw_information_page'));
        add_submenu_page('dots_store', 'Woo Product Recommendation Wizard', __('Woo Product Recommendation Wizard'), 'manage_options', 'wprw-list', array($this, 'wprw_wizrd_list_page'));
        add_submenu_page('dots_store', 'Add New', 'Add New', 'manage_options', 'wprw-add-new', array($this, 'wprw_add_new_wizard_page'));
        add_submenu_page('dots_store', 'Edit Wizard', 'Edit Wizard', 'manage_options', 'wprw-edit-wizard', array($this, 'wprw_edit_wizard_page'));
        add_submenu_page('dots_store', 'Add New', 'Add New', 'manage_options', 'wprw-add-new-question', array($this, 'wprw_add_new_question_page'));
        add_submenu_page('dots_store', 'Edit Question', 'Edit Question', 'manage_options', 'wprw-edit-question', array($this, 'wprw_edit_question_page'));
        add_submenu_page('dots_store', 'Manage Qestions', 'Manage Qestions', 'manage_options', 'wprw-question-list', array($this, 'wprw_question_list_page'));
        add_submenu_page('dots_store', 'Add New', 'Add New', 'manage_options', 'wprw-add-new-options', array($this, 'wprw_add_new_options_page'));
    }

    public function dot_store_menu_page() {
        
    }

    public function wprw_information_page() {
        require_once('partials/wprw-information-page.php');
    }

    public function premium_version_wprw_page() {
        require_once('partials/wprw-premium-version-page.php');
    }

    public function wprw_wizrd_list_page() {
        require_once('partials/wprw-list-page.php');
    }

    public function wprw_add_new_wizard_page() {
        require_once('partials/wprw-add-new-page.php');
    }

    public function wprw_edit_wizard_page() {
        require_once('partials/wprw-add-new-page.php');
    }

    public function wprw_get_started_page() {
        require_once('partials/wprw-get-started-page.php');
    }

    public function wprw_add_new_question_page() {
        require_once('partials/wprw-add-new-question-page.php');
    }

    public function wprw_edit_question_page() {
        require_once('partials/wprw-add-new-question-page.php');
    }

    public function wprw_question_list_page() {
        require_once('partials/wprw-question-list-page.php');
    }

    public function wprw_add_new_options_page() {
        require_once('partials/wprw-add-new-options-page.php');
    }

    public function welcome_wprw_screen_do_activation_redirect() {
        // if no activation redirect
        if (!get_transient('_welcome_screen_activation_redirect_wprw')) {
            return;
        }

        // Delete the redirect transient
        delete_transient('_welcome_screen_activation_redirect_wprw');

        // if activating from network, or bulk
        if (is_network_admin() || isset($_GET['activate-multi'])) {
            return;
        }
        // Redirect to extra cost welcome  page

        wp_safe_redirect(add_query_arg(array('page' => 'wprw-get-started'), admin_url('admin.php')));
    }

    public function wprw_remove_admin_submenus() {
        remove_submenu_page('dots_store', 'wprw-information');
        remove_submenu_page('dots_store', 'wprw-premium');
        remove_submenu_page('dots_store', 'wprw-add-new');
        remove_submenu_page('dots_store', 'wprw-edit-wizard');
        remove_submenu_page('dots_store', 'wprw-get-started');
        remove_submenu_page('dots_store', 'wprw-add-new-question');
        remove_submenu_page('dots_store', 'wprw-edit-question');
        remove_submenu_page('dots_store', 'wprw-question-list');
        remove_submenu_page('dots_store', 'wprw-add-new-options');
    }

    public function get_woocommerce_attribute_value_from_database() {
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
        $option_att_arr = array();
        $questions_options_table_name = $wpdb->prefix . 'questions_options';
        $sel_options_qry = "";
        $sel_options_qry .= "SELECT *";
        $sel_options_qry .= " FROM " . $questions_options_table_name;
        $sel_options_qry .= " WHERE  wizard_id=" . "'" . $wizard_id . "'";
        $sel_options_qry .= " AND  question_id=" . "'" . $question_id . "'";
        $sel_options_rows = $wpdb->get_results($sel_options_qry);
        if (!empty($sel_options_rows) && $sel_options_rows != '') {
            foreach ($sel_options_rows as $sel_options_data) {
                $options_id = $sel_options_data->id;
                $option_attribute = $sel_options_data->option_attribute;
                $option_attribute_value = $sel_options_data->option_attribute_value;
                $option_att_arr[$options_id] = $option_attribute_value;
            }
        }
        return $option_att_arr;
    }

    public function get_woocommerce_options_id_from_database() {
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
        $option_id_arr = array();
        $questions_options_table_name = $wpdb->prefix . 'questions_options';
        $sel_options_qry = "";
        $sel_options_qry .= "SELECT *";
        $sel_options_qry .= " FROM " . $questions_options_table_name;
        $sel_options_qry .= " WHERE  wizard_id=" . "'" . $wizard_id . "'";
        $sel_options_qry .= " AND  question_id=" . "'" . $question_id . "'";
        $sel_options_rows = $wpdb->get_results($sel_options_qry);
        if (!empty($sel_options_rows) && $sel_options_rows != '') {
            foreach ($sel_options_rows as $sel_options_data) {
                $options_id = $sel_options_data->id;
                $option_id_arr[] = "attribute_option_" . $options_id;
            }
        }
        return $option_id_arr;
    }

    public function get_woocommerce_options_name_from_database() {
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
        $options_attribute_name = array();
        $questions_options_table_name = $wpdb->prefix . 'questions_options';
        $sel_options_qry = "";
        $sel_options_qry .= "SELECT *";
        $sel_options_qry .= " FROM " . $questions_options_table_name;
        $sel_options_qry .= " WHERE  wizard_id=" . "'" . $wizard_id . "'";
        $sel_options_qry .= " AND  question_id=" . "'" . $question_id . "'";
        $sel_options_rows = $wpdb->get_results($sel_options_qry);
        if (!empty($sel_options_rows) && $sel_options_rows != '') {
            foreach ($sel_options_rows as $sel_options_data) {
                $options_id = $sel_options_data->id;
                $options_attribute_name[$options_id] = $sel_options_data->option_attribute;
            }
        }
        return $options_attribute_name;
    }

    public function get_woocommerce_product_attribute_value_list() {
        global $product;
        $full_product_list = array();
        $loop = new WP_Query(array('post_type' => array('product'), 'post_status' => 'publish', 'posts_per_page' => -1));
        while ($loop->have_posts()) : $loop->the_post();
            $theid = get_the_ID();
            $product = new WC_Product($theid);
            $variation_data = $product->get_attributes();

            foreach ($variation_data as $attribute) {
                $custom_product_attributes[] = explode('|', trim($attribute['value']));
                $custom_product_attributes_arr[$attribute['name']] = trim($attribute['value']);
            }

        endwhile;
        wp_reset_query();

        $attributeValueArray_implode = implode(',', call_user_func_array('array_merge', $custom_product_attributes));
        return $attributeValueArray_implode;
    }

    public function get_woocommerce_product_attribute_name_list() {
        global $product;
        $full_product_list = array();
        $loop = new WP_Query(array('post_type' => array('product'), 'post_status' => 'publish', 'posts_per_page' => -1));
        $custom_product_attributes_name_arr = array();
        while ($loop->have_posts()) : $loop->the_post();
            $theid = get_the_ID();
            $product = new WC_Product($theid);
            $variation_data = $product->get_attributes();
            foreach ($variation_data as $attribute) {
                $custom_product_attributes_name_arr[] = explode('|', $attribute['name']);
            }

        endwhile;
        wp_reset_query();
        $custom_product_attributes_name = array_map("unserialize", array_unique(array_map("serialize", $custom_product_attributes_name_arr)));
        $attributeNameArray_implode = implode(',', call_user_func_array('array_merge', $custom_product_attributes_name));
        return $attributeNameArray_implode;
    }

    public function remove_option_data_from_option_page() {
        global $wpdb;
        if (!empty($_REQUEST['option_id'])) {
            $option_id = $_REQUEST['option_id'];
        } else {
            $option_id = '';
        }
        $questions_options_table_name = $wpdb->prefix . 'questions_options';
        $delete_result = $wpdb->delete($questions_options_table_name, array('id' => $option_id), array('%d'));
        echo $delete_result;
        wp_die();
    }

    public function delete_selected_wizard_using_checkbox() {
        global $wpdb;
        if (!empty($_REQUEST['selected_wizard_id'])) {
            $selected_wizard_id = $_REQUEST['selected_wizard_id'];
        } else {
            $selected_wizard_id = '';
        }
        $wizard_table_name = $wpdb->prefix . 'wizard';
        $questions_table_name = $wpdb->prefix . 'questions';
        $questions_options_table_name = $wpdb->prefix . 'questions_options';
        $success_delete = array();
        foreach ($selected_wizard_id as $key => $value) {
            $delete_wizard_result = $wpdb->delete($wizard_table_name, array('id' => $value), array('%d'));
            $delete_questions_result = $wpdb->delete($questions_table_name, array('wizard_id' => $value), array('%d'));
            $delete_options_result = $wpdb->delete($questions_options_table_name, array('wizard_id' => $value), array('%d'));
            $success_delete[] = $delete_wizard_result;
        }
        if (in_array("1", $success_delete)) {
            echo 'true';
            wp_die();
        }
    }

    public function delete_selected_question_using_checkbox() {
        global $wpdb;
        if (!empty($_REQUEST['selected_question_id'])) {
            $selected_question_id = $_REQUEST['selected_question_id'];
        } else {
            $selected_question_id = '';
        }
        $questions_table_name = $wpdb->prefix . 'questions';
        $questions_options_table_name = $wpdb->prefix . 'questions_options';
        $success_delete = array();
        foreach ($selected_question_id as $key => $value) {
            $delete_questions_result = $wpdb->delete($questions_table_name, array('id' => $value), array('%d'));
            $delete_options_result = $wpdb->delete($questions_options_table_name, array('question_id' => $value), array('%d'));
            $success_delete[] = $delete_questions_result;
        }
        if (in_array("1", $success_delete)) {
            echo 'true';
            wp_die();
        }
    }

    public function get_attributes_value_based_on_attribute_name() {
        global $product;
        //$attribute_name = serialize($_REQUEST['attribute_name']);
        if (!empty($_REQUEST['attribute_name'])) {
            $attribute_name = $_REQUEST['attribute_name'];
        } else {
            $attribute_name = '';
        }
        $loop = new WP_Query(
                array(
            'post_type' => array('product'),
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_product_attributes',
                    'value' => $attribute_name,
                    'compare' => 'LIKE'
                )
            )
                )
        );
        //echo $loop->request;
        while ($loop->have_posts()) : $loop->the_post();
            $theid = get_the_ID();
            $product = new WC_Product($theid);
            $variation_data = $product->get_attributes();
            //$custom_product_attributes = array();
            foreach ($variation_data as $attribute) {
                $custom_product_attributes_name[] = explode('|', $attribute['name']);
                $custom_product_attributes[] = explode('|', trim($attribute['value']));
                $custom_product_attributes_arr[][$attribute['name']] = trim($attribute['value']);
            }

        endwhile;
        wp_reset_query();

        $all_attribute_value = array();
        $all_attribute_value_implode = array();
        foreach ($custom_product_attributes_arr as $arr_items => $arr_values) {
            foreach ($arr_values as $items => $values) {
                if ($attribute_name == $items) {
                    $all_attribute_value[] = explode('|', $values);
                }
            }
        }
        ####### Implode array value #######
        foreach ($all_attribute_value as $innerValue) {
            $all_attribute_value_implode[] = implode(',', $innerValue);
        }
        ####### Join Array value with comma #######
        $result_attribute_value = '';
        foreach ($all_attribute_value_implode as $sub_array) {
            $result_attribute_value .= $sub_array . ',';
        }
        $result_attribute_value = trim($result_attribute_value, ',');
        $result_attribute_value_explode = explode(',', trim($result_attribute_value));
        $dropdwon_list = '';
        $dropdwon_list .= '<option value=""></option>';
        foreach (array_unique(array_map('trim', $result_attribute_value_explode)) as $key => $final_value) {
            $dropdwon_list .= '<option value="' . trim($final_value) . '">' . trim($final_value) . '</option>';
        }
        echo $dropdwon_list;
        wp_die();
    }

    public function wprw_wizard_save($post) {
        global $wpdb;
        if (empty($post)) {
            return false;
        }
        $wizard_table_name = $wpdb->prefix . 'wizard';
        if (isset($post['wizard_status'])) {
            $wizard_status = 'on';
        } else {
            $wizard_status = 'off';
        }
        if (isset($post['wizard_title'])) {
            if ($post['wizard_post_id'] == '') {
                $wizard_data = array(
                    'name' => trim($post['wizard_title']),
                    'shortcode' => '',
                    'status' => trim($wizard_status),
                    'created_date' => date("Y-m-d H:i:s"),
                    'updated_date' => date("Y-m-d H:i:s")
                );
                $wpdb->insert($wizard_table_name, $wizard_data);
                $lastid = $wpdb->insert_id;
                $wizard_updated_data = array(
                    'shortcode' => '[wprw_' . $lastid . ']',
                );
                $wpdb->update($wizard_table_name, $wizard_updated_data, array('id' => $lastid), array('%s'), array('%d'));
//                echo "CALL " . $wpdb->request;
//                exit();
            } else {
                $wizard_data = array(
                    'name' => trim($post['wizard_title']),
                    'shortcode' => trim($post['wizard_shortcode']),
                    'status' => trim($wizard_status),
                    'created_date' => date("Y-m-d H:i:s"),
                    'updated_date' => date("Y-m-d H:i:s")
                );
                $wpdb->update($wizard_table_name, $wizard_data, array('id' => $post['wizard_post_id']), array('%s', '%s', '%s', '%s', '%s'), array('%d'));
            }
        }
        $complete_url = wp_nonce_url(home_url('/wp-admin/admin.php?page=wprw-list&'), '_wpnonce=' . $retrieved_nonce, '_wpnonce');
        wp_redirect($complete_url);
        exit();
    }

    public function wprw_wizard_question_save($post, $wizard_id) {
        global $wpdb;
        if (empty($post)) {
            return false;
        }
        $questions_table_name = $wpdb->prefix . 'questions';
        if (isset($post['question_type'])) {
            $question_type = esc_attr($post['question_type']);
        }
        if (isset($post['question_name'])) {
            if ($post['question_id'] == '') {
                $questions_data = array(
                    'name' => trim($post['question_name']),
                    'wizard_id' => trim($wizard_id),
                    'option_type' => trim($question_type),
                    'created_date' => date("Y-m-d H:i:s"),
                    'updated_date' => date("Y-m-d H:i:s")
                );
                $wpdb->insert($questions_table_name, $questions_data);
                update_option('attribute_value_11', implode(',', $post['attribute_value_11']));
                update_option('attribute_value_12', implode(',', $post['attribute_value_12']));
            } else {
                $questions_data = array(
                    'name' => trim($post['question_name']),
                    'option_type' => trim($question_type),
                    'created_date' => date("Y-m-d H:i:s"),
                    'updated_date' => date("Y-m-d H:i:s")
                );
                $wpdb->update($questions_table_name, $questions_data, array('id' => $post['question_id'], 'wizard_id' => $wizard_id), array('%s', '%s', '%s', '%s'), array('%d', '%d'));
                update_option('attribute_value_11', implode(',', $post['attribute_value_11']));
                update_option('attribute_value_12', implode(',', $post['attribute_value_12']));
            }
        }
        $complete_url = wp_nonce_url(home_url('/wp-admin/admin.php?page=wprw-edit-wizard&wrd_id=' . $wizard_id . '&action=edit'), '_wpnonce');
        wp_redirect($complete_url);
        exit();
    }

    public function wprw_wizard_options_save($post, $wizard_id, $questions_id) {
        global $wpdb;
        if (empty($post)) {
            return false;
        }

        $main_options_id = $post['options_id'];
        $main_options_name = $post['options_name'];
        $main_options_image = $post['hf_option_single_image_src'];
        $main_attribute_name = $post['attribute_name'];
        $main_attributr_value = $post['attribute_value'];

//        echo '<pre>';
//        print_r($main_options_id);
//        echo '</pre>';
//        echo '<pre>';
//        print_r($main_options_name);
//        echo '</pre>';
//        echo '<pre>';
//        print_r($main_options_image);
//        echo '</pre>';
//        echo '<pre>';
//        print_r($main_attribute_name);
//        echo '</pre>';
//        echo '<pre>';
//        print_r($main_attributr_value);
//        echo '</pre>';

        if (!empty($main_options_id)) {
            foreach ($main_options_id as $main_options_id_key => $main_options_id_value) {
                foreach ($main_options_id_value as $options_key => $options_value) {
                    if (!empty($main_options_name)) {
                        foreach ($main_options_name as $main_options_name_key => $main_options_name_value) {
                            foreach ($main_options_name_value as $options_name_key => $options_name_value) {
                                if (!empty($main_options_image)) {
                                    foreach ($main_options_image as $options_image_key => $options_image) {
                                        foreach ($options_image as $oi_key => $oi_value) {
                                            if (!empty($main_attribute_name)) {
                                                foreach ($main_attribute_name as $attribute_name_key => $attribute_name) {
                                                    foreach ($attribute_name as $an_key => $an_value) {
                                                        if (!empty($main_attributr_value)) {
                                                            $original_attributr_value = '';
                                                            foreach ($main_attributr_value as $attributr_value_key => $attributr_value) {
                                                                foreach ($attributr_value as $av_key => $av_value) {
                                                                    if ($options_key == $options_name_key && $options_key == $an_key && $options_key == $av_key && $options_key == $oi_key && $options_name_key == $an_key && $options_name_key == $av_key && $options_name_key == $oi_key && $an_key == $av_key && $an_key == $oi_key && $av_key == $oi_key) {
                                                                        $original_attributr_value .= ', ' . $av_value;
                                                                        $final_results[$options_key][$options_value] = trim($options_name_value) . "||" . trim($oi_value) . "||" . trim($an_value) . "||" . ltrim($original_attributr_value, ',');
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

//        echo '<pre>';
//        print_r($final_results);
//        echo '</pre>';
//        exit();

        $questions_table_name = $wpdb->prefix . 'questions_options';
        if (isset($post['options_name'])) {
            if ($post['options_id'] == '') {
                foreach ($final_results as $key => $value) {
                    foreach ($value as $v_key => $v_value) {
                        $other_option_data = explode('||', $v_value);
                        $questions_data = array(
                            'wizard_id' => trim($wizard_id),
                            'question_id' => trim($questions_id),
                            'option_name' => trim($other_option_data[0]),
                            'option_image' => trim($other_option_data[1]),
                            'option_attribute' => trim($other_option_data[2]),
                            'option_attribute_value' => trim($other_option_data[3]),
                            'created_date' => date("Y-m-d H:i:s"),
                            'updated_date' => date("Y-m-d H:i:s")
                        );
                        $wpdb->insert($questions_table_name, $questions_data);
                        //echo "CALL " . $wpdb->last_query;
                    }
                }
            } else {
                foreach ($final_results as $key => $value) {
                    foreach ($value as $v_key => $v_value) {
                        $check_options_qry = "";
                        $check_options_qry .= "SELECT *";
                        $check_options_qry .= " FROM " . $questions_table_name;
                        $check_options_qry .= " WHERE  wizard_id=" . "'" . $wizard_id . "'";
                        $check_options_qry .= " AND  question_id=" . "'" . $questions_id . "'";
                        $check_options_qry .= " AND  id=" . "'" . $v_key . "'";
                        $check_options_rows = $wpdb->get_row($check_options_qry);
                        $exist_option_id = $check_options_rows->id;
                        if (!empty($exist_option_id) && $exist_option_id != '') {
                            $other_option_data = explode('||', $v_value);
                            $questions_data = array(
                                'option_name' => trim($other_option_data[0]),
                                'option_image' => trim($other_option_data[1]),
                                'option_attribute' => trim($other_option_data[2]),
                                'option_attribute_value' => trim($other_option_data[3]),
                                'created_date' => date("Y-m-d H:i:s"),
                                'updated_date' => date("Y-m-d H:i:s")
                            );
                            $wpdb->update($questions_table_name, $questions_data, array('id' => $v_key, 'wizard_id' => $wizard_id, 'question_id' => $questions_id), array('%s', '%s', '%s', '%s', '%s', '%s'), array('%d', '%d', '%d'));
                        } else {
                            $other_option_data = explode('||', $v_value);
                            $questions_data = array(
                                'wizard_id' => trim($wizard_id),
                                'question_id' => trim($questions_id),
                                'option_name' => trim($other_option_data[0]),
                                'option_image' => trim($other_option_data[1]),
                                'option_attribute' => trim($other_option_data[2]),
                                'option_attribute_value' => trim($other_option_data[3]),
                                'created_date' => date("Y-m-d H:i:s"),
                                'updated_date' => date("Y-m-d H:i:s")
                            );
                            $wpdb->insert($questions_table_name, $questions_data);
                        }
                    }
                }
            }
        }
        $complete_url = wp_nonce_url(home_url('/wp-admin/admin.php?page=wprw-add-new-question&wrd_id=' . $wizard_id . '&que_id=' . $questions_id), '_wpnonce=' . $retrieved_nonce, '_wpnonce');
        wp_redirect($complete_url);
        exit();
    }

    public function get_question_list_with_pagination() {
        global $wpdb;
        $questions_table_name = $wpdb->prefix . 'questions';
        if (isset($_REQUEST["wizard_id"]) && !empty($_REQUEST['wizard_id'])) {
            $wizard_id = $_REQUEST["wizard_id"];
        } else {
            $wizard_id = '';
        }

        if (!(isset($_REQUEST['pagenum']))) {
            $page = 1;
        } else {
            $page = intval($_REQUEST['pagenum']);
        }

        $limit = ($_REQUEST["limit"] <> "" && is_numeric($_REQUEST["limit"]) ) ? intval($_REQUEST["limit"]) : 5;

        $sel_page_qry = "";
        $sel_page_qry .= "SELECT COUNT(id) AS total_id";
        $sel_page_qry .= " FROM " . $questions_table_name;
        $sel_page_qry .= " WHERE  wizard_id=" . "'" . $wizard_id . "'";
        $page_result = $wpdb->get_row($sel_page_qry);
        $total_records = $page_result->total_id;

        $last = ceil($total_records / $limit);

        if ($page < 1) {
            $page = 1;
        } elseif ($page > $last) {
            $page = $last;
        }
        $lower_limit = ($page - 1) * $limit;

        $sel_qry = "";
        $sel_qry .= "SELECT *";
        $sel_qry .= " FROM " . $questions_table_name;
        $sel_qry .= " WHERE  wizard_id=" . "'" . $wizard_id . "'";
        $sel_qry .= " ORDER BY id ASC";
        $sel_qry .= " LIMIT " . $lower_limit . "," . $limit;
        $sel_rows = $wpdb->get_results($sel_qry);
        $pagination_question_list = '';
        $pagination_question_list .='<table class="table-outer form-table conditional-fee-listing tablesorter">';
        $pagination_question_list .='<thead>';
        $pagination_question_list .='<tr class="wprw-head">';
        $pagination_question_list .='<th><input type="checkbox" name="check_all" class="chk_all_question_class" id="chk_all_question"></th>';
        $pagination_question_list .='<th>' . __('Name', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN) . '</th>';
        $pagination_question_list .='<th>' . __('Type', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN) . '</th>';
        $pagination_question_list .='<th>' . __('Action', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN) . '</th>';
        $pagination_question_list .='</tr>';
        $pagination_question_list .='</thead>';
        $pagination_question_list .='<tbody>';
        if (!empty($sel_rows)) {
            $i = 1;
            foreach ($sel_rows as $sel_data) {
                $question_id = $sel_data->id;
                $wizard_id = $sel_data->wizard_id;
                $question_name = $sel_data->name;
                $question_type = ucfirst($sel_data->option_type);
                $wprwnonce = wp_create_nonce('wppfcnonce');
                $pagination_question_list .='<tr id="after_updated_question_' . $question_id . '">';
                $pagination_question_list .='<td width="10%">';
                $pagination_question_list .='<input type="checkbox" name="chk_single_question_name" class="chk_single_question" value="' . $question_id . '">';
                $pagination_question_list .='</td>';
                $pagination_question_list .='<td>';
                $pagination_question_list .='<a href="' . home_url('/wp-admin/admin.php?page=wprw-edit-question&wrd_id=' . $wizard_id . '&que_id=' . $question_id . '&action=edit' . '&_wpnonce=' . $wprwnonce) . '">' . __($question_name, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN) . '</a>';
                $pagination_question_list .='</td>';
                $pagination_question_list .='<td>' . $question_type . '</td>';
                $pagination_question_list .='<td>';
                $pagination_question_list .='<a class="fee-action-button button-primary" href="' . home_url('/wp-admin/admin.php?page=wprw-add-new-question&wrd_id=' . $wizard_id . '&que_id=' . $question_id . '&action=edit' . '&_wpnonce=' . $wprwnonce) . '" id="questions_edit_' . $question_id . '">' . __('Edit', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN) . '</a>';
                $pagination_question_list .='<a class="fee-action-button button-primary" href="' . home_url('/wp-admin/admin.php?page=wprw-edit-wizard&wrd_id=' . $wizard_id . '&id=' . $question_id . '&action=delete' . '&_wpnonce=' . $wprwnonce) . '">' . __('Delete', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN) . '</a>';
                $pagination_question_list .='</td>';
                $pagination_question_list .='</tr>';
                $i++;
            }
        } else {
            $pagination_question_list .='<tr>';
            $pagination_question_list .='<td colspan="4">No List Available</td>';
            $pagination_question_list .='</tr>';
        }
        $pagination_question_list .= '</tbody>';
        $pagination_question_list .= '</table>';
        $pagination_question_list .=$this->ajax_pagination($wizard_id, $limit, $page, $last, $total_records);
        echo $pagination_question_list;
        wp_die();
    }

    public function ajax_pagination($wizard_id, $limit, $page, $last, $total_records) {
        $pagination_list = '';
        $pagination_list .='<div class="tablenav">';
        $pagination_list .='<div class="tablenav-pages" id="custom_pagination">';
        $pagination_list .='<span class="displaying-num">' . $total_records . ' items</span>';
        $pagination_list .='<span class="pagination-links">';
        $page_minus = $page - 1;
        $page_plus = $page + 1;
        if (($page_minus) > 0) {
            $pagination_list .='<a class="first-page" href="javascript:void(0);" class="links" id="wd_' . $wizard_id . '_lmt_' . $limit . '_que_1">';
            $pagination_list .='<span class="screen-reader-text">First page</span><span aria-hidden="true" id="wd_' . $wizard_id . '_lmt_' . $limit . '_que_1" class="pagination_span">«</span></a>';
            $pagination_list .='<a class="prev-page" href="javascript:void(0);" class="links" id="wd_' . $wizard_id . '_lmt_' . $limit . '_que_' . $page_minus . '">';
            $pagination_list .='<span class="screen-reader-text">Previous page</span><span aria-hidden="true" id="wd_' . $wizard_id . '_lmt_' . $limit . '_que_' . $page_minus . '" class="pagination_span">‹</span></a>';
        }
//        for ($i = 1; $i <= $last; $i++) {
//            if ($i == $page) {
//                $pagination_list .='<a href="javascript:void(0);" class="selected" id="wd_' . $wizard_id . '_lmt_' . $limit . '_que_' . $i . '">' . $i . '</a>';
//            } else {
//                $pagination_list .='<a href="javascript:void(0);" class="links"  id="wd_' . $wizard_id . '_lmt_' . $limit . '_que_' . $i . '">' . $i . '</a>';
//            }
//        }
        $pagination_list .='<span class="screen-reader-text">Current Page</span>';
        $pagination_list .='<span id="table-paging" class="paging-input"><span class="tablenav-paging-text">' . $page . ' of <span class="total-pages">' . $last . '</span></span></span>';
        if (($page_plus) <= $last) {
            $pagination_list .='<a class="next-page" href="javascript:void(0);" id="wd_' . $wizard_id . '_lmt_' . $limit . '_que_' . $page_plus . '" class="links">';
            $pagination_list .='<span class="screen-reader-text">Next page</span><span aria-hidden="true" id="wd_' . $wizard_id . '_lmt_' . $limit . '_que_' . $page_plus . '" class="pagination_span">›</span>';
            $pagination_list .='</a>';
        } if (($page) != $last) {
            $pagination_list .='<a class="last-page"href="javascript:void(0);" id="wd_' . $wizard_id . '_lmt_' . $limit . '_que_' . $last . '" class="links">';
            $pagination_list .='<span class="screen-reader-text">Last page</span><span aria-hidden="true" id="wd_' . $wizard_id . '_lmt_' . $limit . '_que_' . $last . '" class="pagination_span">»</span>';
            $pagination_list .='</a>';
        }
        $pagination_list .='</span>';
        $pagination_list .='</div>';
        $pagination_list .='</div>';
        return $pagination_list;
    }

}
