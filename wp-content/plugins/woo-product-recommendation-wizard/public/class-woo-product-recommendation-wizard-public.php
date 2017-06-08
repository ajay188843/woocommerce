<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Woo_Product_Recommendation_Wizard
 * @subpackage Woo_Product_Recommendation_Wizard/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Product_Recommendation_Wizard
 * @subpackage Woo_Product_Recommendation_Wizard/public
 * @author     Multidots <inquiry@multidots.in>
 */
class Woo_Product_Recommendation_Wizard_Public {

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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woo-product-recommendation-wizard-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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
        wp_enqueue_script('productFrontRecommendationWizard', plugin_dir_url(__FILE__) . 'js/woo-product-recommendation-wizard-public.js', array('jquery'), $this->version, false);
        wp_localize_script('productFrontRecommendationWizard', 'MyAjax', array('ajaxurl' => admin_url('admin-ajax.php'), 'ajax_icon' => plugin_dir_url(__FILE__) . '/images/ajax-loader.gif'));
    }

    public function get_next_questions_front_side() {
        global $wpdb;
        if (!empty($_REQUEST['current_wizard_id']) && isset($_REQUEST['current_wizard_id'])) {
            $wizard_id = $_REQUEST['current_wizard_id'];
        } else {
            $wizard_id = '';
        }
        if (!empty($_REQUEST['current_question_id']) && isset($_REQUEST['current_question_id'])) {
            $current_question_id = $_REQUEST['current_question_id'];
        } else {
            $current_question_id = '';
        }
        ############ Question Result ############
        $question_result = $this->get_all_question_list($wizard_id);
        $question_id_array = array();
        if (!empty($question_result)) {
            foreach ($question_result as $question_result_data) {
                $question_id_array[] = $question_result_data->id;
            }
        }

        ############ All Selected Value ############
        if (!empty($_REQUEST['all_selected_value_id']) && isset($_REQUEST['all_selected_value_id'])) {
            $all_selected_value_id = $_REQUEST['all_selected_value_id'];
        } else {
            $all_selected_value_id = '';
        }

        ############ Get Next Questions ID ############
        $next_question_html = $this->get_next_button_front_side($wizard_id, $current_question_id, $all_selected_value_id);

        ############ Get Previous Questions ID ############
        $previous_question_html = $this->get_previous_button_front_side($wizard_id, $current_question_id, $all_selected_value_id);

        ############ Get Next Record ############
        $next_html = '';
        $next_html .= $this->ajax_get_question_list_based_on_next_and_previous($wizard_id, $current_question_id, $all_selected_value_id);
        $next_html .= '<div class="wprw-page-nav-buttons">';
        $next_html .= $previous_question_html;
        $next_html .= $next_question_html;
        $next_html .= '</div>';
        echo "true" . "||" . $next_html . "||" . json_encode($question_id_array);
        wp_die();
    }

    public function get_previous_questions_front_side() {
        global $wpdb;
        if (!empty($_REQUEST['current_wizard_id']) && isset($_REQUEST['current_wizard_id'])) {
            $wizard_id = $_REQUEST['current_wizard_id'];
        } else {
            $wizard_id = '';
        }
        if (!empty($_REQUEST['current_question_id']) && isset($_REQUEST['current_question_id'])) {
            $current_question_id = $_REQUEST['current_question_id'];
        } else {
            $current_question_id = '';
        }
        ############ Question Result ############
        $question_result = $this->get_all_question_list($wizard_id);
        $question_id_array = array();
        if (!empty($question_result)) {
            foreach ($question_result as $question_result_data) {
                $question_id_array[] = $question_result_data->id;
            }
        }

        ############ All Selected Value ############
        if (!empty($_REQUEST['all_selected_value_id']) && isset($_REQUEST['all_selected_value_id'])) {
            $all_selected_value_id = $_REQUEST['all_selected_value_id'];
        } else {
            $all_selected_value_id = '';
        }

        ############ Get Next Questions ID ############
        $next_question_html = $this->get_next_button_front_side($wizard_id, $current_question_id, $all_selected_value_id);

        ############ Get Previous Questions ID ############
        $previous_question_html = $this->get_previous_button_front_side($wizard_id, $current_question_id, $all_selected_value_id);

        ############ Get Previous Record ############
        $previous_html = '';
        $previous_html .= $this->ajax_get_question_list_based_on_next_and_previous($wizard_id, $current_question_id, $all_selected_value_id);
        $previous_html .= '<div class="wprw-page-nav-buttons">';
        $previous_html .= $previous_question_html;
        $previous_html .= $next_question_html;
        $previous_html .= '</div>';
        echo "true" . "||" . $previous_html . "||" . json_encode($question_id_array);
        wp_die();
    }

     public function get_previous_button_front_side($wizard_id, $current_question_id, $all_selected_value_id) {
        ############ Get Previous Questions ID ############
        global $wpdb;
        $questions_table_name = $wpdb->prefix . 'questions';
//        $get_previous_id_qry = "";
//        $get_previous_id_qry .= "SELECT *";
//        $get_previous_id_qry .= " FROM " . $questions_table_name;
//        $get_previous_id_qry .= " WHERE id =" . "(select max(id) from " . $questions_table_name . " where id < " . $current_question_id . ")";
//        $get_previous_id_qry .= " AND wizard_id='" . $wizard_id . "'";
        $get_previous_id_qry = "";
        $get_previous_id_qry .= "SELECT *";
        $get_previous_id_qry .= " FROM " . $questions_table_name;
        $get_previous_id_qry .= " WHERE id <'" . $current_question_id . "'";
        $get_previous_id_qry .= " AND wizard_id='" . $wizard_id . "'";
        $get_previous_id_qry .= " ORDER BY id DESC LIMIT 1";

        $get_previous_id_rows = $wpdb->get_row($get_previous_id_qry);
        $previous_question_html = '';
        //$previous_question_html .= $get_previous_id_qry;
        if (!empty($get_previous_id_rows) && $get_previous_id_rows != '0') {
            $get_previous_question_id = $get_previous_id_rows->id;
            $previous_question_html .= '<a class="wprw-button wprw-button-previous" id="wd_' . $wizard_id . '_que_' . $get_previous_question_id . '_cur_' . $get_previous_question_id . '" href="javascript:void(0);">';
            $previous_question_html .= '<span class="wprw-back-advisor-label">Back</span>' . $get_previous_question_id; // . $get_previous_question_id;
            $previous_question_html .= '</a>';
        } else {
            $get_previous_question_id = '';
            $previous_question_html .='';
        }
        return $previous_question_html;
    }

    public function get_next_button_front_side($wizard_id, $current_question_id, $all_selected_value_id) {
        ############ Get Next Questions ID ############
        global $wpdb;
        $questions_table_name = $wpdb->prefix . 'questions';
//        $get_next_id_qry = "";
//        $get_next_id_qry .= "SELECT *";
//        $get_next_id_qry .= " FROM " . $questions_table_name;
//        $get_next_id_qry .= " WHERE id=" . "(select min(id) from " . $questions_table_name . " where id > " . $current_question_id . ")";
//        $get_next_id_qry .= " AND wizard_id='" . $wizard_id . "'";
        $get_next_id_qry = "";
        $get_next_id_qry .= "SELECT *";
        $get_next_id_qry .= " FROM " . $questions_table_name;
        $get_next_id_qry .= " WHERE id >'" . $current_question_id . "'";
        $get_next_id_qry .= " AND wizard_id='" . $wizard_id . "'";
        $get_next_id_qry .= " ORDER BY id ASC LIMIT 1";

        $get_next_id_rows = $wpdb->get_row($get_next_id_qry);
        $next_question_html = '';
        //$next_question_html .=$get_next_id_qry;
        if (!empty($get_next_id_rows) && $get_next_id_rows != '0') {
            $get_next_question_id = $get_next_id_rows->id;
            $next_question_html .= '<a class="wprw-button wprw-button-next wprw-button-inactive" id="wd_' . $wizard_id . '_que_' . $get_next_question_id . '_cur_' . $get_next_question_id . '" href="javascript:void(0);">';
            $next_question_html .= '<span class="">Next</span>' . $get_next_question_id; // . $get_next_question_id;
            $next_question_html .= '</a>';
        } else {
            $get_next_question_id = '';
            $next_question_html .= '';
        }
        return $next_question_html;
    }
    public function ajax_get_question_list_based_on_next_and_previous($wizard_id, $current_question_id, $all_selected_value_id) {
        global $wpdb;
        $wizard_table_name = $wpdb->prefix . 'wizard';
        $questions_table_name = $wpdb->prefix . 'questions';
        $options_table_name = $wpdb->prefix . 'questions_options';

        $sel_qry = "";
        $sel_qry .= "SELECT *";
        $sel_qry .= " FROM " . $questions_table_name;
        $sel_qry .= " WHERE wizard_id='" . $wizard_id . "'";
        $sel_qry .= " AND id='" . $current_question_id . "'";
        $sel_qry .= " ORDER BY id ASC";
        $sel_rows = $wpdb->get_results($sel_qry);
        $ajax_html = '';
        if (!empty($sel_rows)) {
            foreach ($sel_rows as $sel_data) {
                $question_id = $sel_data->id;
                $question_name = $sel_data->name;
                $option_type = trim($sel_data->option_type);

                $sel_qry = "";
                $sel_qry .= "SELECT *";
                $sel_qry .= " FROM " . $options_table_name;
                $sel_qry .= " WHERE wizard_id='" . $wizard_id . "'";
                $sel_qry .= " AND question_id='" . $question_id . "'";
                $sel_qry .= " ORDER BY id ASC";
                $sel_rows = $wpdb->get_results($sel_qry);

                $ajax_html .= '<li class="wprw-question wprw-mandatory-question" id="ques_' . $question_id . '">';
                ############ Question Result ############
//                $ajax_html .= '<input type="hidden" name="all_selected_value_name" id="all_selected_value_id" value="' . $all_selected_value_id . '"/>';
                $ajax_html .= '<div class="wprw-question-text-panel">';
                $ajax_html .= '<div class="wprw-question-text">' . $question_name . '</div>';
                $ajax_html .= '</div>';
                $ajax_html .= '<ol wprw-radiobutton="" class="wprw-answers">';

                if (!empty($sel_rows)) {
                    $i = 0;
                    foreach ($sel_rows as $sel_data) {
                        $i++;
                        $option_id = $sel_data->id;
                        $option_name = $sel_data->option_name;
                        $option_image = $sel_data->option_image;
                        $option_attribute = $sel_data->option_attribute;
                        $option_attribute_value = $sel_data->option_attribute_value;

                        if ($option_type == 'radio') {
                            $div_answer_action_class = 'radio';
                        } else {
                            $div_answer_action_class = 'checkbox';
                        }
                        $ajax_html .= '<li class="wprw-answer wprw-selected-answer" id="opt_attr_' . $option_id . '">';
                        $ajax_html .= '<div class="wprw-answer-content wprw-answer-selector">';
                        if (!empty($option_image)) {
                            $ajax_html .= '<div class="wprw-answer-image wprw-answer-selector">';
                            $ajax_html .= '<img class="wprw-desktop-image wprw-active-image" src=' . $option_image . '>';
                            $ajax_html .= '</div>';
                        }
                        $ajax_html .= '<div class="wprw-answer-action wprw-action-element wprw-' . $div_answer_action_class . '">';
                        $ajax_html .= '<span class="wprw-answer-selector">';
                        if ($option_type == 'radio') {
                            $ajax_html .= '<input class="wprw-input" type="radio" value="' . $option_id . '" name="option_name" id="wd_' . $wizard_id . '_que_' . $question_id . '_opt_' . $option_id . '"> ';
                        } elseif ($option_type == 'checkbox') {
                            $ajax_html .= '<input class="wprw-input" type="checkbox" value="' . $option_id . '" name="' . $option_name . '" id="wd_' . $wizard_id . '_que_' . $question_id . '_opt_' . $option_id . '"> ';
                        }
                        $ajax_html .= '<span class="wprw-label-element wprw-answer-label">';
                        $ajax_html .= '<span class="wprw-answer-label wprw-label-element">' . $option_name . '</span>';
                        $ajax_html .= '</span>';
                        $ajax_html .= '</span>';
                        $ajax_html .= '</div>';
                        $ajax_html .= '</div>';
                        $ajax_html .= '</li>';
                    }
                }
                $ajax_html .= '</ol>';
                $ajax_html .= '</li>';
            }
        }

        return $ajax_html;
    }

    public function get_ajax_woocommerce_product_list() {
        global $product, $wpdb;
        $options_table_name = $wpdb->prefix . 'questions_options';

        if (!empty($_REQUEST['current_wizard_id']) && isset($_REQUEST['current_wizard_id'])) {
            $wizard_id = $_REQUEST['current_wizard_id'];
        } else {
            $wizard_id = '';
        }
        if (!empty($_REQUEST['current_question_id']) && isset($_REQUEST['current_question_id'])) {
            $question_id = $_REQUEST['current_question_id'];
        } else {
            $question_id = '';
        }
        if (!empty($_REQUEST['current_option_id']) && isset($_REQUEST['current_option_id'])) {
            $option_id = $_REQUEST['current_option_id'];
        } else {
            $option_id = '';
        }
        if (!empty($_REQUEST['all_selected_value']) && isset($_REQUEST['all_selected_value'])) {
            $all_selected_value = $_REQUEST['all_selected_value'];
        } else {
            $all_selected_value = '';
        }
        if (!empty($_REQUEST['current_selected_value']) && isset($_REQUEST['current_selected_value'])) {
            $current_selected_value = $_REQUEST['current_selected_value'];
        } else {
            $current_selected_value = $all_selected_value;
        }

        $single_opion_value_frm_db = $this->get_option_value_based_on_option_id($current_selected_value);
        $single_opion_name_frm_db = $this->get_option_name_based_on_option_id($current_selected_value);

        $sel_qry = "";
        $sel_qry .= "SELECT *";
        $sel_qry .= " FROM " . $options_table_name;
        $sel_qry .= " WHERE wizard_id='" . $wizard_id . "'";
        $sel_qry .= " AND id IN (" . stripslashes($all_selected_value) . ")";
        $sel_qry .= " ORDER BY id DESC";
        //echo "\n" . $sel_qry;
        $sel_rows = $wpdb->get_results($sel_qry);

        $fetch_attribute_value_array = array();
        $fetch_attribute_value_pass_jquery = array();
        $option_attribute_arr = array();
        $fetch_option_attribute_value_arr = array();
        $fetch_attribute_value_pass_jquery_merge = array();
        foreach ( $sel_rows as $sel_data ) {
            $option_attribute = trim($sel_data->option_attribute);
            $fetch_option_attribute_value = trim(str_replace(", " ,"," ,$sel_data->option_attribute_value));
            //$fetch_attribute_value_array[] = trim($fetch_option_attribute_value);
            $option_attribute_arr[] = trim($sel_data->option_attribute);
            $fetch_option_attribute_value_arr[] = trim(str_replace(", " ,"," ,$sel_data->option_attribute_value));
            $fetch_option_attribute_value = str_replace(', ' ,"," ,$fetch_option_attribute_value);
            $fetch_attribute_value_array[][trim($option_attribute)] = trim($fetch_option_attribute_value); //for function
            if( !empty( $fetch_attribute_value_pass_jquery  )) {
                $fetch_attribute_value_pass_jquery_merge[trim(strtolower($option_attribute))] =  trim(strtolower($fetch_option_attribute_value));
                if (array_key_exists(trim(strtolower($option_attribute)), $fetch_attribute_value_pass_jquery)) {
                    foreach ( $fetch_attribute_value_pass_jquery as $fetch_attribute_value_pass_multiple_jquery_checkbox_only_value) {
                        $fetch_attribute_value_pass_jquery[trim(strtolower($option_attribute))] = $fetch_attribute_value_pass_multiple_jquery_checkbox_only_value.",".trim(strtolower(str_replace(", " ,"," ,$sel_data->option_attribute_value)));
                    }
                } else {
                    $fetch_attribute_value_pass_jquery[trim(strtolower($option_attribute))] = trim(strtolower($fetch_option_attribute_value));
                }
            } else {
                $fetch_attribute_value_pass_jquery[trim(strtolower($option_attribute))] = trim(strtolower($fetch_option_attribute_value));
            }
            // $fetch_attribute_value_pass_jquery[trim(strtolower($option_attribute))] = trim(strtolower($fetch_option_attribute_value));
        }
        $sel_qry = "";
        $sel_qry .= "SELECT *";
        $sel_qry .= " FROM " . $options_table_name;
        $sel_qry .= " WHERE wizard_id='" . $wizard_id . "'";
        $sel_qry .= " AND id IN (" . stripslashes($all_selected_value) . ")";
        $sel_qry .= " ORDER BY id DESC";
        //echo "\n" . $sel_qry;
        $all_sel_rows = $wpdb->get_results($sel_qry);

        $all_fetch_attribute_value_array = array();
        $all_option_attribute = array();
        $all_fetch_option_attribute_value_arr = array();
        $all_fetch_match_attribute_value_array = array();
        foreach ($all_sel_rows as $all_sel_data) {
            $all_option_single_id = trim($all_sel_data->id);
            $all_option_single_attribute = trim($all_sel_data->option_attribute);
            $all_fetch_option_attribute_value = trim(str_replace(", " ,"," ,$all_sel_data->option_attribute_value));
            $all_fetch_option_attribute_value_arr[][$all_option_single_id] = trim(str_replace(", " ,"," ,$all_sel_data->option_attribute_value));
            $all_option_attribute[] = trim($all_sel_data->option_attribute);
            $all_fetch_attribute_value_array[][trim($all_option_single_attribute)] = trim($all_fetch_option_attribute_value); //for function
            $all_fetch_match_attribute_value_array[trim($all_option_single_attribute)] = trim($all_fetch_option_attribute_value); //for function
        }

        $all_fetch_oopt_att_val_n_arr = array();
        $all_check_oopt_att_val_n_arr = array();
        foreach ($all_option_attribute as $all_opt_name_key => $all_opt_name_value) {
            foreach ($all_fetch_option_attribute_value_arr as $all_key => $all_value) {
                foreach ($all_value as $all_value_key => $all_value_value) {
                    if ($all_opt_name_key == $all_key) {
                        if (array_key_exists($all_opt_name_value, $all_check_oopt_att_val_n_arr)) {
                            // $i = 0;
                            foreach ($all_check_oopt_att_val_n_arr as $all_ft_key => $all_ft_value) {
                                //$i++;
                                if ($all_opt_name_value == $all_ft_key) {
                                    //$all_fetch_oopt_att_val_n_arr[$all_opt_name_value] = $all_value_value ."|" . $all_ft_value . "|" . $all_value_key;
                                    //$all_check_oopt_att_val_n_arr[$all_opt_name_value] = $all_value_value . "|" . $all_ft_value . "|" . $all_value_key;
                                    $all_fetch_oopt_att_val_n_arr[$all_opt_name_value] = $all_value_value.",".$all_ft_value;
                                    $all_check_oopt_att_val_n_arr[$all_opt_name_value] = $all_value_value.",".$all_ft_value;
                                }
                            }
                        } else {
                            // $all_fetch_oopt_att_val_n_arr[$all_opt_name_value] = $all_value_value . "|" . $all_value_key;
                            // $all_check_oopt_att_val_n_arr[$all_opt_name_value] = $all_value_value . "|" . $all_value_key;
                            $all_fetch_oopt_att_val_n_arr[$all_opt_name_value] = $all_value_value;
                            $all_check_oopt_att_val_n_arr[$all_opt_name_value] = $all_value_value;
                        }
                    }
                }
            }
        }
        $get_all_prd_attr = $this->get_all_attribute_value();
        $all_fetch_oopt_att_val_n_explode = array();
        foreach ($all_fetch_oopt_att_val_n_arr as $all_fin_key => $all_fin_value) {
            if (strpos($all_fin_value, '|') !== false) {
                $all_fetch_oopt_att_val_n_explode[$all_fin_key] = explode('|', trim($all_fin_value));
            } else {
                $all_fetch_oopt_att_val_n_explode[$all_fin_key] = array(trim($all_fin_value));
            }
        }
        $product_html = '';
        $product_html .= '<div class="main_all_prd_section">';
        $product_html .= '<div class="sub_prd_section" id="sub_prd_section_id">';
        ################################### Perfect Product Match ###################################
        $perfect_qry = "";
        $perfect_qry .= "SELECT *";
        $perfect_qry .= " FROM {$wpdb->prefix}posts";
        $perfect_qry .= " INNER JOIN {$wpdb->prefix}postmeta m1";
        $perfect_qry .= " ON ({$wpdb->prefix}posts.ID = m1.post_id)";
        $perfect_qry .= " WHERE";
        $perfect_qry .= " {$wpdb->prefix}posts.post_type = 'product'";
        $perfect_qry .= " AND {$wpdb->prefix}posts.post_status = 'publish'";
        $perfect_qry .= " AND (m1.meta_key = '_product_attributes')";
        foreach ($all_fetch_oopt_att_val_n_explode as $option_attribute_va_value_explode_key => $option_attribute_va_value_explode_value) {
            $option_val = $option_attribute_va_value_explode_value[0];
            $option_val = str_replace(","," | " ,$option_val);
            $perfect_qry .= " AND m1.meta_value REGEXP '[[:<:]]" . $option_val . "[[:>:]]'";
        }
        $perfect_qry .= " ORDER BY {$wpdb->prefix}posts.post_date";
        $perfect_qry .= " ASC";
        //echo "\n" . $perfect_qry;
        $perfect_products_result = $wpdb->get_results($perfect_qry);
        $perfect_products_result_count = count($perfect_products_result);

        if (!empty($perfect_products_result) && isset($perfect_products_result) && $perfect_products_result != 'false') {
            $product_html .= '<div class="wprw-product-headline">Products that fit your needs:</div>';
            $prev_result_value = array();
            $value_arr = array();
            foreach ($perfect_products_result as $prd_data) {
                $theid = $prd_data->ID;
                $meta_value = unserialize($prd_data->meta_value);
                $product = new WC_Product($theid);
                $variation_data = $product->get_attributes();
                if (!empty($variation_data) && isset($variation_data)) {
                    foreach ($variation_data as $attribute) {
                        $custom_product_attributes_name[] = explode('|', $attribute['name']);
                        $custom_product_attributes[] = explode('|', $attribute['value']);
                        $custom_product_attributes_arr[][$theid] = $attribute['name'] . "||" . $attribute['value'];
                        $custom_product_attributes_arr_arr[$attribute['name']] = $attribute['value'];
                    }
                }
                $currency = '$';
                $regular_price = get_post_meta($theid, '_regular_price', true);
                $sale_price = get_post_meta($theid, '_sale_price', true);

                ######### Product Div Structure #########
                $product_html .= '<div class="prd_section" id="prd_' . $theid . '">';
                $product_html .= '<div class="prd_detail">';
                $product_html .= '<div class="prd_top_detail">';
                $product_html .= '<div class="prd_title left_title">';
                $product_html .= '<a class="woo-product-detail-link" href="' . get_the_permalink($theid) . '">' . get_the_title($theid) . '</a>';
                $product_html .= '</div>';
                $product_html .= '<div class="prd_compare right_compare">';
                $product_html .= '</div>';
                $product_html .= '</div>';
                $product_html .= '<div class="prd_middle_detail">';
                $product_html .= '<div class="prd_image left_image">';
                $product_html .= '<a class="woo-product-detail-link" href="' . get_the_permalink($theid) . '">' . get_the_post_thumbnail($theid) . '</a>';
                $product_html .= '</div>';
                $product_html .= '<div class="prd_attribute middle_attribute">';
                $product_html .= '<div class="prd_attribute_list">';
                $product_html .= '<div class="prd-overlay-attributes">';
                if (!empty($get_all_prd_attr) && isset($get_all_prd_attr)) {
                    foreach ($get_all_prd_attr as $all_key => $all_value) {
                        if ($all_key == $theid) {
                            foreach ($all_value as $key => $value) {
                                if (strpos($value, '|') !== false) {
                                    $attribute_value_ex = explode('|', trim($value));
                                } else {
                                    $attribute_value_ex = array($value);
                                }
                                foreach ($attribute_value_ex as $att_key => $att_value) {
                                    if (!empty($att_value) && isset($att_value)) {
                                        $get_option_id = $this->get_option_id_based_on_option_value($att_value);
                                        if (!empty($get_option_id)) {
                                            $option_id = $get_option_id;
                                        } else {
                                            $option_id = '';
                                        }
                                        $product_html .= '<div class="prd-attribute prd-neutral-attr" id="prd_att_'.strtolower($option_id).'"><span id="'.trim(strtolower($key)).'" class="prd_attribute_name">'.$key .': </span><span id="'.trim(strtolower($att_value)).'" class="prd_attribute_value">'.$att_value. '</span></div>';
                                    }
                                }
                            }
                        }
                    }
                }
                $product_html .= '</div>';
                $product_html .= '</div>';
                $product_html .= '<div class="prd_price right_bottom_price">';
                $product_html .= '<div class="product-details">';
                $product_html .= '<div class="wprw-product-price">';
                $product_html .= '<span class="prd_sale_price">';
                $product_html .= $currency . " " . $sale_price;
                $product_html .= '</span>';
                $product_html .= '</div>';
                $product_html .= '<a class="wprw-button wprw-detail-button wprw-product-detail-link" href="' . get_the_permalink($theid) . '">';
                $product_html .= '<span class="prd_detail_name">Details</span>';
                $product_html .= '</a>';
                $product_html .= '</div>';
                $product_html .= '</div>';
                $product_html .= '</div>';
                $product_html .= '</div>';
                $product_html .= '</div>';
                $product_html .= '</div>';
            }
        }

        ################################### Recently Product Match ###################################
        $prefix = $prd_id_list = '';
        if (!empty($perfect_products_result) && isset($perfect_products_result)) {
            foreach ($perfect_products_result as $ppr_value) {
                $prd_id_list .= $prefix . $ppr_value->ID;
                $prefix = ', ';
            }
        }
        $check_recently_qry = "";
        $check_recently_qry .= "SELECT *";
        $check_recently_qry .= " FROM {$wpdb->prefix}posts";
        $check_recently_qry .= " INNER JOIN {$wpdb->prefix}postmeta m1";
        $check_recently_qry .= " ON ({$wpdb->prefix}posts.ID = m1.post_id)";
        $check_recently_qry .= " WHERE";
        $check_recently_qry .= " {$wpdb->prefix}posts.post_type = 'product'";
        $check_recently_qry .= " AND {$wpdb->prefix}posts.post_status = 'publish'";
        $check_recently_qry .= " AND (m1.meta_key = '_product_attributes')";
        if (isset($prd_id_list) && $prd_id_list != '') {
            $check_recently_qry .= " AND {$wpdb->prefix}posts.ID NOT IN (" . stripslashes($prd_id_list) . ")";
        }
        $check_recently_qry .= " ORDER BY {$wpdb->prefix}posts.post_date";
        $check_recently_qry .= " ASC";
        $check_recently_products_result = $wpdb->get_results($check_recently_qry);

        $test_prev_result_value = array();
        $test_value_arr = array();
        $test_custom_product_attributes_name = array();
        $test_custom_product_attributes = array();
        $test_custom_product_attributes_arr = array();
        $test_custom_product_attributes_arr_arr = array();

        $fetch_attribute_value_pass_jquery_test = $fetch_attribute_value_pass_jquery;
        $fetch_attribute_value_pass_jquery_test_result_data = array();
        $arr_fetch_record_custom_array = array();

        //umang code for make order query

        foreach(  $fetch_attribute_value_pass_jquery_test as $fetch_attribute_value_pass_jquery_test_result_key =>$fetch_attribute_value_pass_jquery_test_result ) {
            $fetch_attribute_value_pass_jquery_test_resultkey = $fetch_attribute_value_pass_jquery_test_result_key;
            $data_array = explode(',', $fetch_attribute_value_pass_jquery_test_result);
            $fetch_attribute_value_pass_jquery_test_result = implode(',',array_unique(explode(',', $fetch_attribute_value_pass_jquery_test_result)));
            foreach (explode(',', $fetch_attribute_value_pass_jquery_test_result) as $line) {
                $arr_fetch_record_custom_array[][$fetch_attribute_value_pass_jquery_test_resultkey] = $line;
            }
            $fetch_attribute_value_pass_jquery_test_result_data[$fetch_attribute_value_pass_jquery_test_resultkey] = $fetch_attribute_value_pass_jquery_test_result;
        }

        if (!empty($check_recently_products_result) && isset($check_recently_products_result) && $check_recently_products_result != 'false') {
            $prev_result_value = array();
            $value_arr = array();
            $array_install_id_to_order_by_product = array();
            foreach ($check_recently_products_result as $prd_data) {
                $theid = $prd_data->ID;
                $match_id_and_counter = 0;
                $meta_value = unserialize($prd_data->meta_value);
                $product = new WC_Product($theid);
                $variation_data = $product->get_attributes();
                foreach ($variation_data as $attribute) {
                    $custom_product_attributes_name[] = explode('|', $attribute['name']);
                    $custom_product_attributes[] = explode('|', $attribute['value']);
                    $custom_product_attributes_arr[][$theid] = $attribute['name'] . "||" . $attribute['value'];
                    $custom_product_attributes_arr_arr[$theid][$attribute['name']] = $attribute['value'];
                }
                $currency = '$';
                $regular_price = get_post_meta($theid, '_regular_price', true);
                $sale_price = get_post_meta($theid, '_sale_price', true);

                if (!empty($get_all_prd_attr) && isset($get_all_prd_attr)) {
                    foreach ($get_all_prd_attr as $all_key => $all_value) {
                        if ($all_key == $theid) {
                            foreach ($all_value as $key => $value) {
                                if (strpos($value, '|') !== false) {
                                    $attribute_value_ex = explode('|', trim($value));
                                } else {
                                    $attribute_value_ex = array($value);
                                }
                                foreach ($attribute_value_ex as $att_key => $att_value) {
                                    if (!empty($att_value) && isset($att_value)) {
                                        $get_option_id = $this->get_option_id_based_on_option_value($att_value);
                                        if (!empty( $arr_fetch_record_custom_array)) {
                                            foreach ( $arr_fetch_record_custom_array as  $arr_fetch_record_custom_array_result) {
                                                foreach ( $arr_fetch_record_custom_array_result as  $arr_fetch_record_custom_array_key =>  $arr_fetch_record_custom_array_for_match_product_id) {
                                                     if (!empty( $arr_fetch_record_custom_array_key) && (strtolower($key) ==  $arr_fetch_record_custom_array_key) && ( in_array(strtolower(trim($att_value)) , $arr_fetch_record_custom_array_result) ) ) {
                                                        $match_id_and_counter++;
                                                        $array_install_id_to_order_by_product[$theid] = $match_id_and_counter;
                                                    } else {
                                                         //$match_id_and_counter = 0;
                                                        $array_install_id_to_order_by_product[$theid] = $match_id_and_counter;
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

        if( !empty( $array_install_id_to_order_by_product )) {
            $result_order_by_id = $array_install_id_to_order_by_product;
            arsort($result_order_by_id);
            //print_r($array_install_id_to_order_by_product);
            $order_result_by_id = '';
            if (!empty($result_order_by_id)) {
                $order_result_by_id = implode(", ", array_keys($result_order_by_id));
            }
        }

        $recently_qry = "";
        $recently_qry .= "SELECT *";
        $recently_qry .= " FROM {$wpdb->prefix}posts";
        $recently_qry .= " INNER JOIN {$wpdb->prefix}postmeta m1";
        $recently_qry .= " ON ({$wpdb->prefix}posts.ID = m1.post_id)";
        $recently_qry .= " WHERE";
        $recently_qry .= " {$wpdb->prefix}posts.post_type = 'product'";
        $recently_qry .= " AND {$wpdb->prefix}posts.post_status = 'publish'";
        $recently_qry .= " AND (m1.meta_key = '_product_attributes')";
        if (isset($prd_id_list) && $prd_id_list != '') {
            $recently_qry .= " AND {$wpdb->prefix}posts.ID NOT IN (" . stripslashes($prd_id_list) . ")";
        }
        if(!empty( $result_order_by_id )) {
            $recently_qry .= " ORDER BY FIELD( wp_posts.ID ,$order_result_by_id)";
        } else {
            $recently_qry .= " ORDER BY {$wpdb->prefix}posts.post_date";
            $recently_qry .= " ASC";

        }
        $recently_products_result = $wpdb->get_results($recently_qry);


        if (!empty($recently_products_result) && isset($recently_products_result) && $recently_products_result != 'false') {
            $product_html .= '<div class="wprw-product-headline">Recently Product that fit your needs:</div>';
            $prev_result_value = array();
            $value_arr = array();
            foreach ($recently_products_result as $prd_data) {
                $theid = $prd_data->ID;
                $meta_value = unserialize($prd_data->meta_value);
                $product = new WC_Product($theid);
                $variation_data = $product->get_attributes();
                foreach ($variation_data as $attribute) {
                    $custom_product_attributes_name[] = explode('|', $attribute['name']);
                    $custom_product_attributes[] = explode('|', $attribute['value']);
                    $custom_product_attributes_arr[][$theid] = $attribute['name'] . "||" . $attribute['value'];
                    $custom_product_attributes_arr_arr[$theid][$attribute['name']] = $attribute['value'];
                }

                $currency = '$';
                $regular_price = get_post_meta($theid, '_regular_price', true);
                $sale_price = get_post_meta($theid, '_sale_price', true);

                ######### Product Div Structure #########
                $product_html .= '<div class="prd_section" id="prd_' . $theid . '">';
                $product_html .= '<div class="prd_detail">';
                $product_html .= '<div class="prd_top_detail">';
                $product_html .= '<div class="prd_title left_title">';
                $product_html .= '<a class="woo-product-detail-link" href="'.get_the_permalink($theid) . '">'.get_the_title($theid) . '</a>';
                $product_html .= '</div>';
                $product_html .= '<div class="prd_compare right_compare">';
                $product_html .= '</div>';
                $product_html .= '</div>';
                $product_html .= '<div class="prd_middle_detail">';
                $product_html .= '<div class="prd_image left_image">';
                $product_html .= '<a class="woo-product-detail-link" href="'.get_the_permalink($theid).'">'.get_the_post_thumbnail($theid).'</a>';
                $product_html .= '</div>';
                $product_html .= '<div class="prd_attribute middle_attribute">';
                $product_html .= '<div class="prd_attribute_list">';
                $product_html .= '<div class="prd-overlay-attributes">';
                $attribute_value_ex = array();
//                if (!empty($custom_product_attributes_arr_arr) && isset($custom_product_attributes_arr_arr)) {
//                    foreach ($custom_product_attributes_arr_arr as $key => $value) {
//                        if (strpos($value, '|') !== false) {
//                            $attribute_value_ex = explode('|', trim($value));
//                        } else {
//                            $attribute_value_ex = array($value);
//                        }
//                        if (!empty($attribute_value_ex) && isset($attribute_value_ex)) {
//                            foreach ($attribute_value_ex as $att_key => $att_value) {
//                                $get_option_id = $this->get_option_id_based_on_option_value($att_value);
//                                if (!empty($get_option_id)) {
//                                    $option_id = $get_option_id;
//                                } else {
//                                    $option_id = '';
//                                }
//                                $product_html .= $option_id . '<div class="prd-attribute prd-neutral-attr" id="prd_att_' . strtolower($option_id) . '"><span id="' . trim(strtolower($key)) . '" class="prd_attribute_name">' . $key . ': </span><span id="' . trim(strtolower($att_value)) . '" class="prd_attribute_value">' . $att_value . '</span></div>';
//                            }
//                        }
//                    }
//                }
                if (!empty($get_all_prd_attr) && isset($get_all_prd_attr)) {
                    foreach ($get_all_prd_attr as $all_key => $all_value) {
                        if ($all_key == $theid) {
                            foreach ($all_value as $key => $value) {
                                if (strpos($value, '|') !== false) {
                                    $attribute_value_ex = explode('|', trim($value));
                                } else {
                                    $attribute_value_ex = array($value);
                                }
                                foreach ($attribute_value_ex as $att_key => $att_value) {
                                    if (!empty($att_value) && isset($att_value)) {
                                        $get_option_id = $this->get_option_id_based_on_option_value($att_value);
                                        if (!empty($get_option_id)) {
                                            $option_id = $get_option_id;
                                        } else {
                                            $option_id = '';
                                        }
                                        $product_html .= '<div class="prd-attribute prd-neutral-attr" id="prd_att_' . strtolower($option_id) . '"><span id="' . trim(strtolower($key)) . '" class="prd_attribute_name">' . $key . ': </span><span id="' . trim(strtolower($att_value)) . '" class="prd_attribute_value">' . $att_value . '</span></div>';
                                    }
                                }
                            }
                        }
                    }
                }
                $product_html .= '</div>';
                $product_html .= '</div>';
                $product_html .= '<div class="prd_price right_bottom_price">';
                $product_html .= '<div class="product-details">';
                $product_html .= '<div class="wprw-product-price">';
                $product_html .= '<span class="prd_sale_price">';
                $product_html .= $currency . " " . $sale_price;
                $product_html .= '</span>';
                $product_html .= '</div>';
                $product_html .= '<a class="wprw-button wprw-detail-button wprw-product-detail-link" href="' . get_the_permalink($theid) . '">';
                $product_html .= '<span class="prd_detail_name">Details</span>';
                $product_html .= '</a>';
                $product_html .= '</div>';
                $product_html .= '</div>';
                $product_html .= '</div>';
                $product_html .= '</div>';
                $product_html .= '</div>';
                $product_html .= '</div>';
            }
        }
        $product_html .= '</div>';
        $product_html .= '</div>';

        echo "true" . "||" . $product_html .  "||" . json_encode($fetch_attribute_value_pass_jquery) . "||" . json_encode($fetch_option_attribute_value_arr) . "||" . $perfect_qry . "||" . $recently_qry ;

        print_r($array_install_id_to_order_by_product);

        wp_die();
    }

    public function get_option_value_based_on_option_id($option_id) {
        global $wpdb;
        $options_table_name = $wpdb->prefix . 'questions_options';
        $sel_qry = "";
        $sel_qry .= "SELECT *";
        $sel_qry .= " FROM " . $options_table_name;
        $sel_qry .= " WHERE id='" . $option_id . "'";
        $sel_rows = $wpdb->get_row($sel_qry);
        if (!empty($sel_rows) && $sel_rows != '0' && isset($sel_rows)) {
            $option_value = str_replace(", ","," ,$sel_rows->option_attribute_value);
            return $option_value;
        }
    }

    public function get_option_name_based_on_option_id($option_id) {
        global $wpdb;
        $options_table_name = $wpdb->prefix . 'questions_options';
        $sel_qry = "";
        $sel_qry .= "SELECT *";
        $sel_qry .= " FROM " . $options_table_name;
        $sel_qry .= " WHERE id='" . $option_id . "'";
        $sel_rows = $wpdb->get_row($sel_qry);
        if (!empty($sel_rows) && $sel_rows != '0' && isset($sel_rows)) {
            $option_attribute = $sel_rows->option_attribute;
            return $option_attribute;
        }
    }

    public function get_all_question_list($wizard_id) {
        global $wpdb;
        $questions_table_name = $wpdb->prefix . 'questions';
        $sel_qry = "";
        $sel_qry .= "SELECT *";
        $sel_qry .= " FROM " . $questions_table_name;
        $sel_qry .= " WHERE wizard_id='" . $wizard_id . "'";
        $sel_qry .= " ORDER BY id ASC";
        $sel_rows = $wpdb->get_results($sel_qry);
        if (!empty($sel_rows) && $sel_rows != '0' && isset($sel_rows)) {
            return $sel_rows;
        }
    }

    public function get_option_id_based_on_option_value($option_name) {
        global $wpdb;
        $options_table_name = $wpdb->prefix . 'questions_options';
        $sel_qry = "";
        $sel_qry .= "SELECT *";
        $sel_qry .= " FROM " . $options_table_name;
        if (!empty($option_name) && $option_name != '' && isset($option_name)) {
            $sel_qry .= " WHERE  option_attribute_value ='" . trim($option_name) . "'";
        }
        $sel_qry .= " ORDER BY id ASC";
        //echo "\n" . $sel_qry;
        $get_option_result = $wpdb->get_row($sel_qry);
        if (!empty($get_option_result) && $get_option_result != '' && isset($get_option_result)) {
            $get_option_id = $get_option_result->id;
            return $get_option_id;
        }
    }

    public function get_all_attribute_value() {
        global $wpdb;
        $sel_qry = "";
        $sel_qry .= "SELECT *";
        $sel_qry .= " FROM {$wpdb->prefix}posts";
        $sel_qry .= " INNER JOIN {$wpdb->prefix}postmeta m1";
        $sel_qry .= " ON ({$wpdb->prefix}posts.ID = m1.post_id)";
        $sel_qry .= " WHERE";
        $sel_qry .= " {$wpdb->prefix}posts.post_type = 'product'";
        $sel_qry .= " AND {$wpdb->prefix}posts.post_status = 'publish'";
        $sel_qry .= " AND (m1.meta_key = '_product_attributes')";
        $sel_qry .= " ORDER BY {$wpdb->prefix}posts.post_date";
        $sel_qry .= " ASC";
        $sel_result = $wpdb->get_results($sel_qry);
        $sel_result_count = count($sel_result);

        $custom_product_attributes_arr_arr = array();
        if (!empty($sel_result) && isset($sel_result)) {
            foreach ($sel_result as $prd_data) {
                $theid = $prd_data->ID;
                $meta_value = unserialize($prd_data->meta_value);
                $product = new WC_Product($theid);
                $variation_data = $product->get_attributes();
                if (!empty($variation_data) && isset($variation_data)) {
                    foreach ($variation_data as $attribute) {
                        $custom_product_attributes_name[] = explode('|', $attribute['name']);
                        $custom_product_attributes[] = explode('|', $attribute['value']);
                        $custom_product_attributes_arr[][$theid] = $attribute['name'] . "||" . $attribute['value'];
                        $custom_product_attributes_arr_arr[$theid][$attribute['name']] = $attribute['value'];
                    }
                }
            }
        }
        return $custom_product_attributes_arr_arr;
    }
}

?>
