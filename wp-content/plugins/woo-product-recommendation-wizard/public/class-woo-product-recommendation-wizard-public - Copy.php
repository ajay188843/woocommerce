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

        ############ Question Result ############
        $question_result = $this->get_all_question_list($wizard_id);
        $question_id_array = array();
        if (!empty($question_result)) {
            foreach ($question_result as $question_result_data) {
                $question_id_array[] = $question_result_data->id;
            }
        }

        if (!empty($_REQUEST['current_question_id']) && isset($_REQUEST['current_question_id'])) {
            $current_question_id = $_REQUEST['current_question_id'];
        } else {
            $current_question_id = '';
        }
        ############ Input Type ############
        if (!empty($_REQUEST['allInputs_type']) && isset($_REQUEST['allInputs_type'])) {
            $allInputs_type = $_REQUEST['allInputs_type'];
        } else {
            $allInputs_type = '';
        }
        ############ Get Selected Value ############
        if (!empty($_REQUEST['current_selected_value']) && isset($_REQUEST['current_selected_value'])) {
            if ($allInputs_type == 'checkbox') {
                $current_selected_value = implode(',', $_REQUEST['current_selected_value']);
            } else if ($allInputs_type == 'radio') {
                $current_selected_value = $_REQUEST['current_selected_value'];
            }
        } else {
            $current_selected_value = '';
        }
        ############ All Selected Value ############
        if (!empty($_REQUEST['all_selected_value_id']) && isset($_REQUEST['all_selected_value_id'])) {
            if ($allInputs_type == 'checkbox') {
                $all_selected_value_id = $_REQUEST['all_selected_value_id'];
            } else if ($allInputs_type == 'radio') {
                $all_selected_value_id = $_REQUEST['all_selected_value_id'];
            }
        } else {
            $all_selected_value_id = '';
        }

        ############ Get Next Questions ID ############
        $next_question_html = $this->get_next_button_front_side($wizard_id, $current_question_id, $current_selected_value, $all_selected_value_id);

        ############ Get Previous Questions ID ############
        $previous_question_html = $this->get_previous_button_front_side($wizard_id, $current_question_id, $current_selected_value, $all_selected_value_id);

        ############ Get Next Record ############
        $next_html = '';
        $next_html .= $this->ajax_get_question_based_on_next_and_previous($wizard_id, $current_question_id, $current_selected_value, $all_selected_value_id);
        $next_html .= '<div class="wprw-page-nav-buttons">';
        $next_html .= $previous_question_html;
        $next_html .= $next_question_html;
        $next_html .= '</div>';
        ############ END Next Record ############
        $next_html .= '<div class="product_list" id="product_list_id">';
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

        ############ Question Result ############
        $question_result = $this->get_all_question_list($wizard_id);
        $question_id_array = array();
        if (!empty($question_result)) {
            foreach ($question_result as $question_result_data) {
                $question_id_array[] = $question_result_data->id;
            }
        }

        if (!empty($_REQUEST['current_question_id']) && isset($_REQUEST['current_question_id'])) {
            $current_question_id = $_REQUEST['current_question_id'];
        } else {
            $current_question_id = '';
        }
        ############ Input Type ############
        if (!empty($_REQUEST['allInputs_type']) && isset($_REQUEST['allInputs_type'])) {
            $allInputs_type = $_REQUEST['allInputs_type'];
        } else {
            $allInputs_type = '';
        }
        ############ Get Selected Value ############
        if (!empty($_REQUEST['current_selected_value']) && isset($_REQUEST['current_selected_value'])) {
            if ($allInputs_type == 'checkbox') {
                $current_selected_value = implode(',', $_REQUEST['current_selected_value']);
            } else if ($allInputs_type == 'radio') {
                $current_selected_value = $_REQUEST['current_selected_value'];
            }
        } else {
            $current_selected_value = '';
        }
        ############ All Selected Value ############
        if (!empty($_REQUEST['all_selected_value_id']) && isset($_REQUEST['all_selected_value_id'])) {
            if ($allInputs_type == 'checkbox') {
                $all_selected_value_id = $_REQUEST['all_selected_value_id'];
            } else if ($allInputs_type == 'radio') {
                $all_selected_value_id = $_REQUEST['all_selected_value_id'];
            }
        } else {
            $all_selected_value_id = '';
        }

        ############ Get Next Questions ID ############
        $next_question_html = $this->get_next_button_front_side($wizard_id, $current_question_id, $current_selected_value, $all_selected_value_id);

        ############ Get Previous Questions ID ############
        $previous_question_html = $this->get_previous_button_front_side($wizard_id, $current_question_id, $current_selected_value, $all_selected_value_id);

        ############ Get Previous Record ############
        $previous_html = '';
        $previous_html .= $this->ajax_get_question_based_on_next_and_previous($wizard_id, $current_question_id, $current_selected_value, $all_selected_value_id);
        $previous_html .= '<div class="wprw-page-nav-buttons">';
        $previous_html .= $previous_question_html;
        $previous_html .= $next_question_html;
        $previous_html .= '</div>';
        ############ END Next Record ############
        $previous_html .= '<div class="product_list" id="product_list_id">';
        $previous_html .= '</div>';
        echo "true" . "||" . $previous_html . "||" . json_encode($question_id_array);
        wp_die();
    }

    public function get_previous_button_front_side($wizard_id, $current_question_id, $current_selected_value, $all_selected_value_id) {
        ############ Get Previous Questions ID ############
        global $wpdb;
        $questions_table_name = $wpdb->prefix . 'questions';
        $get_previous_id_qry = "";
        $get_previous_id_qry .= "SELECT *";
        $get_previous_id_qry .= " FROM " . $questions_table_name;
        $get_previous_id_qry .= " WHERE id=" . "(select max(id) from " . $questions_table_name . " where id < " . $current_question_id . ")";
        $get_previous_id_qry .= " AND wizard_id='" . $wizard_id . "'";
        $get_previous_id_rows = $wpdb->get_row($get_previous_id_qry);
        $previous_question_html = '';
        if (!empty($get_previous_id_rows) && $get_previous_id_rows != '0') {
            $get_previous_question_id = $get_previous_id_rows->id;
            $previous_question_html .= '<a class="wprw-button wprw-button-previous" id="wd_' . $wizard_id . '_que_' . $get_previous_question_id . '" href="javascript:void(0);">';
            $previous_question_html .= '<span class="wprw-back-advisor-label">Back</span>' . $get_previous_question_id;
            $previous_question_html .= '</a>';
        } else {
            $get_previous_question_id = '';
            $previous_question_html .='';
        }
//        $question_result = $this->get_all_question_list($wizard_id);
//        if (!empty($question_result)) {
//            foreach ($question_result as $question_result_data) {
//                $all_question_id = $question_result_data->id;
//                if ($current_question_id == $all_question_id) {
//                    $previous_question_html .= '<input type="hidden" name="current_selected_value_name" id="current_selected_value_id_' . $current_question_id . '" value="' . $current_selected_value . '"/>';
//                }
//                $previous_question_html .= '<input type="hidden" name="current_selected_value_name" id="current_selected_value_id_' . $all_question_id . '" value=""/>';
//            }
//        }
        return $previous_question_html;
    }

    public function get_next_button_front_side($wizard_id, $current_question_id, $current_selected_value, $all_selected_value_id) {
        ############ Get Next Questions ID ############
        global $wpdb;
        $questions_table_name = $wpdb->prefix . 'questions';
        $get_next_id_qry = "";
        $get_next_id_qry .= "SELECT *";
        $get_next_id_qry .= " FROM " . $questions_table_name;
        $get_next_id_qry .= " WHERE id=" . "(select min(id) from " . $questions_table_name . " where id > " . $current_question_id . ")";
        $get_next_id_qry .= " AND wizard_id='" . $wizard_id . "'";
        $get_next_id_rows = $wpdb->get_row($get_next_id_qry);
        $next_question_html = '';
        if (!empty($get_next_id_rows) && $get_next_id_rows != '0') {
            $get_next_question_id = $get_next_id_rows->id;
            $next_question_html .= '<a class="wprw-button wprw-button-next wprw-button-inactive" id="wd_' . $wizard_id . '_que_' . $get_next_question_id . '" href="javascript:void(0);">';
            $next_question_html .= '<span class="">Next</span>' . $get_next_question_id;
            $next_question_html .= '</a>';
        } else {
            $get_next_question_id = '';
            $next_question_html .= '';
        }
//        $question_result = $this->get_all_question_list($wizard_id);
//        if (!empty($question_result)) {
//            foreach ($question_result as $question_result_data) {
//                $all_question_id = $question_result_data->id;
//                if ($current_question_id == $all_question_id) {
//                    $next_question_html .= '<input type="hidden" name="current_selected_value_name" id="current_selected_value_id_' . $current_question_id . '" value="' . $current_selected_value . '"/>';
//                }
//                $next_question_html .= '<input type="hidden" name="current_selected_value_name" id="current_selected_value_id_' . $all_question_id . '" value=""/>';
//            }
//        }
        return $next_question_html;
    }

    public function ajax_get_question_based_on_next_and_previous($wizard_id, $current_question_id, $current_selected_value, $all_selected_value_id) {
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

                //$ajax_html .=$get_next_id_qry;
                //$ajax_html .=$get_previous_id_qry;
                $ajax_html .= '<li class="wprw-question wprw-mandatory-question" id="ques_' . $question_id . '">';
                ############ Question Result ############
                $ajax_html .= '<input type="hidden" name="current_selected_value_name" id="current_selected_value_id_' . $current_question_id . '" value="' . $current_selected_value . '"/>';
                $ajax_html .= '<input type="hidden" name="all_selected_value_name" id="all_selected_value_id" value="' . $all_selected_value_id . '"/>';
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
                            $ajax_html .= '<input class="wprw-input" type="radio" value="' . $option_id . '" name="' . $option_name . '" id="option_value_' . $option_id . '"> ';
                        } elseif ($option_type == 'checkbox') {
                            $ajax_html .= '<input class="wprw-input" type="checkbox" value="' . $option_id . '" name="' . $option_name . '" id="option_value_' . $option_id . '"> ';
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
        if (!empty($_REQUEST['option_id'])) {
            $option_id = $_REQUEST['option_id'];
        } else {
            $option_id = '';
        }
        if (!empty($_REQUEST['option_name'])) {
            $option_name = $_REQUEST['option_name'];
        } else {
            $option_name = '';
        }
        if (!empty($_REQUEST['selected_value'])) {
            $selected_value = $_REQUEST['selected_value'];
        } else {
            $selected_value = '';
        }
        $product_html = '';
        //$get_option_value = $this->get_option_value_based_on_option_id($option_id);
        //$product_html.=$get_option_value;
        $prd_qry = new WP_Query(array('post_type' => array('product'), 'post_status' => 'publish', 'posts_per_page' => -1));
        $product_html .= '<div class="main_all_prd_section">';
        $product_html .= '<div class="wprw-product-headline">Products that fit your needs:</div>';
        $product_html .= '<div class="sub_prd_section" id="sub_prd_section_id">';
        while ($prd_qry->have_posts()) : $prd_qry->the_post();
            $theid = get_the_ID();
            $product = new WC_Product($theid);
            $currency = get_woocommerce_currency_symbol();
            $regular_price = get_post_meta($product->post->ID, '_regular_price', true);
            $sale_price = get_post_meta($product->post->ID, '_sale_price', true);

            ######### Product Div Structure #########
            $product_html .= '<div class="prd_section" id="prd_' . $product->post->ID . '">';
            $product_html .= '<div class="prd_detail">';
            $product_html .= '<div class="prd_top_detail">';
            $product_html .= '<div class="prd_title left_title">';
            $product_html .= '<a class="woo-product-detail-link" href="' . get_the_permalink($product->post->ID) . '">' . get_the_title($product->post->ID) . '</a>';
            $product_html .= '</div>';
            $product_html .= '<div class="prd_compare right_compare">';
            $product_html .= '</div>';
            $product_html .= '</div>';
            $product_html .= '<div class="prd_middle_detail">';
            $product_html .= '<div class="prd_image left_image">';
            $product_html .= '<a class="woo-product-detail-link" href="' . get_the_permalink($product->post->ID) . '">' . woocommerce_get_product_thumbnail() . '</a>';
            $product_html .= '</div>';
            $product_html .= '<div class="prd_attribute middle_attribute">';
            $product_html .= '<div class="prd_attribute_list">
                            it displays price of a main product on the page for every single product in my grid - the price of the product which post it is, 
                            rather than the price of each product in a grid, if that makes sense... So if the price of the product on single page is £9.00, 
                            every product in related products grid will display with £9.00 too rather than it"s own price...
                        </div>';
            $product_html .= '<div class="prd_price right_bottom_price">';
            $product_html .= '<div class="product-details">';
            $product_html .= '<div class="wprw-product-price">';
            $product_html .= '<span class="prd_sale_price">';
            $product_html .= $currency . " " . $sale_price;
            $product_html .= '</span>';
            $product_html .= '</div>';
            $product_html .= '<a class="wprw-button wprw-detail-button wprw-product-detail-link" href="' . get_the_permalink($product->post->ID) . '">';
            $product_html .= '<span class="prd_detail_name">Details</span>';
            $product_html .= '</a>';
            $product_html .= '</div>';
            $product_html .= '</div>';
            $product_html .= '</div>';
            $product_html .= '</div>';
            $product_html .= '</div>';
            $product_html .= '</div>';
        endwhile;
        $product_html .= '</div>';
        $product_html .= '</div>';
        echo "true" . "||" . $product_html;
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
        if (!empty($sel_rows) && $sel_rows != '0') {
            $option_value = $sel_rows->option_attribute_value;
            return $option_value;
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
        return $sel_rows;
    }

}
