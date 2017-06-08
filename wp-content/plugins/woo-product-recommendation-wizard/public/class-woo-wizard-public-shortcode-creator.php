<?php

global $wpdb;
$wizard_table_name = $wpdb->prefix . 'wizard';
$sel_qry = "";
$sel_qry .= "SELECT *";
$sel_qry .= " FROM " . $wizard_table_name . " wizard";
$wizard_rows = $wpdb->get_results($sel_qry);

if (!empty($wizard_rows)) {
    foreach ($wizard_rows as $wizard_data) {
        $wizard_id = $wizard_data->id;
        $wizard_title = $wizard_data->name;
        $wizard_shortcode = $wizard_data->shortcode;
        $wizard_status = $wizard_data->status;

        $cb = function() use ($wizard_id) {
            global $wpdb;
            $wizard_table_name = $wpdb->prefix . 'wizard';
            $questions_table_name = $wpdb->prefix . 'questions';
            $options_table_name = $wpdb->prefix . 'questions_options';

            //$woo_prd_obj = new Woo_Product_Recommendation_Wizard_Public($this->plugin_name, $this->version);
            //$woo_prd_obj_detail = $woo_prd_obj->get_all_woocommerce_product_list();

            $sel_qry = "";
            $sel_qry .= "SELECT ";
            $sel_qry .= " wizard.*,";
            $sel_qry .= " qustions.id AS question_id,qustions.name,qustions.option_type";
            $sel_qry .= " FROM " . $wizard_table_name . " wizard";
            $sel_qry .= " LEFT JOIN " . $questions_table_name . " AS qustions";
            $sel_qry .= " ON qustions.wizard_id=wizard.id";
            $sel_qry .= " WHERE wizard.id='" . $wizard_id . "'";
            $sel_qry .= " AND wizard.status='on'";
            $sel_qry .= " ORDER BY qustions.id ASC";
            $sel_qry .= " LIMIT 0,1";
            $sel_rows = $wpdb->get_results($sel_qry);
            if (!empty($sel_rows)) {
                $front_html = '';
                $i = 0;
                $front_html .= '<div class="test">';
                $front_html .= '<ol class="wprw-questions" id="test_new">';
                foreach ($sel_rows as $sel_data) {
                    $i++;
                    $question_id = $sel_data->question_id;
                    $question_name = $sel_data->name;
                    $option_type = trim($sel_data->option_type);

                    ############ Get Next Questions ID ############
                    $get_next_id_qry = "";
                    $get_next_id_qry .= "SELECT *";
                    $get_next_id_qry .= " FROM " . $questions_table_name;
                    $get_next_id_qry .= " WHERE id=" . "(select min(id) from " . $questions_table_name . " where id > " . $question_id . ")";
                    $get_next_id_rows = $wpdb->get_row($get_next_id_qry);
                    $next_question_html = '';
                    if (!empty($get_next_id_rows) && $get_next_id_rows != '0') {
                        $get_next_question_id = $get_next_id_rows->id;
                        $next_question_html .= '<a class="wprw-button wprw-button-next wprw-button-inactive" id="wd_' . $wizard_id . '_que_' . $get_next_question_id . '_cur_' . $question_id . '" href="javascript:void(0);">';
                        $next_question_html .= '<span class="">Next</span>' . $get_next_question_id;
                        $next_question_html .= '</a>';
                    } else {
                        $get_next_question_id = '';
                    }

                    //$front_html .= $get_next_id_qry;
                    $front_html .= '<li class="wprw-question wprw-mandatory-question" id="ques_' . $question_id . '">';
                    $front_html .= '<div class="wprw-mandatory-message" style="display: none;">Please answer the question.</div>';
                    $front_html .= '<div class="wprw-question-text-panel">';
                    $front_html .= '<div class="wprw-question-text">' . $question_name . '</div>';
                    $front_html .= '</div>';
                    $front_html .= '<ol wprw-radiobutton="" class="wprw-answers">';

                    $sel_qry = "";
                    $sel_qry .= "SELECT *";
                    $sel_qry .= " FROM " . $options_table_name;
                    $sel_qry .= " WHERE wizard_id='" . $wizard_id . "'";
                    $sel_qry .= " AND question_id='" . $question_id . "'";
                    $sel_qry .= " ORDER BY id ASC";
                    $sel_rows = $wpdb->get_results($sel_qry);
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
                            $front_html .= '<li class="wprw-answer wprw-selected-answer" id="opt_attr_' . $option_id . '">';
                            $front_html .= '<div class="wprw-answer-content wprw-answer-selector">';
                            if (!empty($option_image)) {
                                $front_html .= '<div class="wprw-answer-image wprw-answer-selector">';
                                $front_html .= '<img class="wprw-desktop-image wprw-active-image" src=' . $option_image . '>';
                                $front_html .= '</div>';
                            }
                            $front_html .= '<div class="wprw-answer-action wprw-action-element wprw-' . $div_answer_action_class . '">';
                            $front_html .= '<span class="wprw-answer-selector">';
                            if ($option_type == 'radio') {
                                $front_html .= '<input class="wprw-input" type="radio" value="' . $option_id . '" name="option_name" id="wd_' . $wizard_id . '_que_' . $question_id . '_opt_' . $option_id . '"> ';
                            } elseif ($option_type == 'checkbox') {
                                $front_html .= '<input class="wprw-input" type="checkbox" value="' . $option_id . '" name="' . $option_name . '" id="wd_' . $wizard_id . '_que_' . $question_id . '_opt_' . $option_id . '"> ';
                            }
                            $front_html .= '<span class="wprw-label-element wprw-answer-label">';
                            $front_html .= '<span class="wprw-answer-label wprw-label-element">' . $option_name . '</span>';
                            $front_html .= '</span>';
                            $front_html .= '</span>';
                            $front_html .= '</div>';
                            $front_html .= '</div>';
                            $front_html .= '</li>';
                        }
                    }
                    $front_html .= '</ol>';
                    $front_html .= '</li>';
                    $front_html .= '<div class="wprw-page-nav-buttons">';
                    $front_html .= $next_question_html;
                    $front_html .= '</div>';
                }
                $front_html .= '</ol>';
                $test_obj = new Woo_Product_Recommendation_Wizard_Public($this->plugin_name, $this->version);
                $question_result = $test_obj->get_all_question_list($wizard_id);
                if (!empty($question_result)) {
                    foreach ($question_result as $question_result_data) {
                        $all_question_id = $question_result_data->id;
                        $front_html .= '<input type="hidden" name="current_selected_value_name" id="current_selected_value_id_' . $all_question_id . '" value=""/>';
                    }
                }
                $front_html .= '<input type="hidden" name="all_selected_value" id="all_selected_value" value=""/>';
                $front_html .= '<div class="product_list" id="product_list_id">';
                $front_html .= '</div>';
                $front_html .= '</div>';
                return $front_html;
            }
        };

        add_shortcode("wprw_" . $wizard_id, $cb);
    }
}

