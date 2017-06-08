(function($) {
    'use strict';
    $(window).load(function() {
        jQuery(".wprw-button-previous").hide();
        jQuery(".wprw-button-previous").hide();
        jQuery(".wprw-display-results-button").hide();
        jQuery(".wprw-start-advisor-button").hide();
        jQuery(".wprw-scroll-to-results-button").hide();


        jQuery('body').on('click', '.wprw-button-next', function(e) {
            var main_id = jQuery(this).attr('id');
            var parts = main_id.split('_');
            var wizard_int_id = parts[1];
            var question_int_id = parts[3];
            var option_int_id = parts[5];
            //var all_selected_value_id = jQuery.trim(jQuery('#all_selected_value_id').val());

            var all_question_value = [];
            jQuery('input[name="current_selected_value_name"]').each(function(i) {
                var all_selected_value_id = jQuery(this).attr('id');
                var all_question_id = all_selected_value_id.substr(all_selected_value_id.lastIndexOf("_") + 1);
                var current_selected_val = jQuery('#current_selected_value_id_' + all_question_id).val();
                if (current_selected_val != "") {
                    all_question_value.push(jQuery('#current_selected_value_id_' + all_question_id).val());
                }
            });
            jQuery('#all_selected_value').val(all_question_value);
            var total_selected_value_with_join = all_question_value.join(',');
            var split_val = total_selected_value_with_join.split(',');
            jQuery.each(split_val, function(i, val) {
                jQuery('#wd_' + wizard_int_id + '_que_' + question_int_id + '_opt_' + val).prop('checked', true);
            });
            jQuery.ajax({
                type: 'POST',
                url: MyAjax.ajaxurl,
                data: {
                    action: "get_next_questions_front_side",
                    current_wizard_id: wizard_int_id,
                    current_question_id: question_int_id,
                    all_selected_value_id: all_question_value
                },
                success: function(response) {
                    //alert(response);
                    var result = response.split('||');
                    if (result[0] == 'true') {
                        jQuery('#test_new').html(result[1]);
                        var total_selected_value = []
                        var current_selected_value_arr = [];
                        var total_question_id = JSON.parse(result[2]);
                        jQuery.each(total_question_id, function(i, val) {
                            var current_selected_val = jQuery('#current_selected_value_id_' + val).val();
                            if (current_selected_val != "") {
                                current_selected_value_arr.push(jQuery('#current_selected_value_id_' + val).val());
                            }
                        });
                        if (current_selected_value_arr != '') {
                            total_selected_value.push(current_selected_value_arr);
                        }
                        jQuery('#all_selected_value_id').val(total_selected_value);
                        var total_selected_value_with_join = total_selected_value.join(',');
                        var split_val = total_selected_value_with_join.split(',');
                        jQuery.each(split_val, function(i, val) {
                            jQuery('#wd_' + wizard_int_id + '_que_' + question_int_id + '_opt_' + val).prop('checked', true);
                        });
                    } else {
                    }
                }
            });
        });

        jQuery('body').on('click', '.wprw-button-previous', function(e) {
            var main_id = jQuery(this).attr('id');
            var parts = main_id.split('_');
            var wizard_int_id = parts[1];
            var question_int_id = parts[3];
            var option_int_id = parts[5];
            var all_selected_value_id = jQuery.trim(jQuery('#all_selected_value_id').val());

            var all_question_value = [];
            jQuery('input[name="current_selected_value_name"]').each(function(i) {
                var all_selected_value_id = jQuery(this).attr('id');
                var all_question_id = all_selected_value_id.substr(all_selected_value_id.lastIndexOf("_") + 1);
                var current_selected_val = jQuery('#current_selected_value_id_' + all_question_id).val();
                if (current_selected_val != "") {
                    all_question_value.push(jQuery('#current_selected_value_id_' + all_question_id).val());
                }
            });
            jQuery('#all_selected_value').val(all_question_value);
            var total_selected_value_with_join = all_question_value.join(',');
            var split_val = total_selected_value_with_join.split(',');
            jQuery.each(split_val, function(i, val) {
                jQuery('#wd_' + wizard_int_id + '_que_' + question_int_id + '_opt_' + val).prop('checked', true);
            });
            jQuery.ajax({
                type: 'POST',
                url: MyAjax.ajaxurl,
                data: {
                    action: "get_previous_questions_front_side",
                    current_wizard_id: wizard_int_id,
                    current_question_id: question_int_id,
                    all_selected_value_id: all_question_value
                },
                success: function(response) {
                    var result = response.split('||');
                    if (result[0] == 'true') {
                        jQuery('#test_new').html(result[1]);
                        var total_selected_value = []
                        var current_selected_value_arr = [];
                        var total_question_id = JSON.parse(result[2]);
                        jQuery.each(total_question_id, function(i, val) {
                            var current_selected_val = jQuery('#current_selected_value_id_' + val).val();
                            if (current_selected_val != "") {
                                current_selected_value_arr.push(jQuery('#current_selected_value_id_' + val).val());
                            }
                        });
                        if (current_selected_value_arr != '') {
                            total_selected_value.push(current_selected_value_arr);
                        }
                        jQuery('#all_selected_value_id').val(total_selected_value);
                        var total_selected_value_with_join = total_selected_value.join(',');
                        var split_val = total_selected_value_with_join.split(',');
                        jQuery.each(split_val, function(i, val) {
                            jQuery('#wd_' + wizard_int_id + '_que_' + question_int_id + '_opt_' + val).prop('checked', true);
                        });
                    } else {
                    }
                }
            });
        });

        jQuery('body').on('click', 'span.wprw-answer-selector input.wprw-input', function(e) {
            var input_value = jQuery(this).val();
            var main_id = jQuery(this).attr('id');
            var parts = main_id.split('_');
            var wizard_int_id = parts[1];
            var question_int_id = parts[3];
            var option_int_id = parts[5];

            var input_name = jQuery(this).attr('name');
            var allInputs = jQuery("input.wprw-input:input");
            var allInputs_type = jQuery.trim(allInputs.attr('type'));
            var current_selected_value = [];
            var current_selected_value_with_join;
            if (allInputs_type == 'checkbox') {
                jQuery('input.wprw-input:checkbox:checked').each(function(i) {
                    current_selected_value[i] = jQuery(this).val();
                });
                current_selected_value_with_join = current_selected_value.join(',');
            }
            if (allInputs_type == 'radio') {
                var radioValue = jQuery("input.wprw-input:radio:checked").val();
                if (radioValue) {
                    current_selected_value = radioValue;
                }
                current_selected_value_with_join = current_selected_value;
            }
            jQuery('#current_selected_value_id_' + question_int_id).val(current_selected_value);

            var all_question_value = [];
            jQuery('input[name="current_selected_value_name"]').each(function(i) {
                var all_selected_value_id = jQuery(this).attr('id');
                var all_question_id = all_selected_value_id.substr(all_selected_value_id.lastIndexOf("_") + 1);
                var current_selected_val = jQuery('#current_selected_value_id_' + all_question_id).val();
                if (current_selected_val != "") {
                    all_question_value.push(current_selected_val);
                }
            });
            jQuery('#all_selected_value').val(all_question_value);
            var total_selected_value_with_join = all_question_value.join(',');
            var split_val = total_selected_value_with_join.split(',');
            jQuery.each(split_val, function(i, val) {
                jQuery('#wd_' + wizard_int_id + '_que_' + question_int_id + '_opt_' + val).prop('checked', true);
            });
            var total_selected_value_pass_database = '\'' + total_selected_value_with_join.split(',').join('\',\'') + '\'';

            jQuery.ajax({
                type: 'POST',
                url: MyAjax.ajaxurl,
                data: {
                    action: "get_ajax_woocommerce_product_list",
                    current_wizard_id: wizard_int_id,
                    current_question_id: question_int_id,
                    current_option_id: option_int_id,
                    current_selected_value: current_selected_value_with_join,
                    all_selected_value: total_selected_value_pass_database,
                },
                success: function(response) {
                    //alert(response);
                    var result = response.split('||');
                    if (result[0] == 'true') {
                        jQuery('#product_list_id').html(result[1]);
                        var k = 0;
                        jQuery.each(split_val, function(i, val) {
                            var j = 0;
                            jQuery('.prd_section .prd-attribute').each(function() {
                                j++;
                                var prd_attribute_id = jQuery(this).attr('id');
                                var prd_attribute_int_id = jQuery.trim(prd_attribute_id.substr(prd_attribute_id.lastIndexOf("_") + 1));
                                if (prd_attribute_int_id == val) {
                                    jQuery('.prd_section').find('#prd_att_' + prd_attribute_int_id).addClass('prd-positive-attr').removeClass('prd-negative-attr');
                                } else {
                                    jQuery('.prd_section').find('#prd_att_' + prd_attribute_int_id).addClass('text').removeClass('prd-negative-attr');
                                }
                            });
                            k++;
                        });
                    }
                    //alert(result[2]);
                }
            });
        });
    });
    /**
     * All of the code for your public-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

})(jQuery);
