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
                    console.log(result);
                    if (result[0] == 'true') {
                        var curr_fetch_att_name = jQuery.parseJSON(JSON.stringify(result[2]));
                        jQuery('#product_list_id').html(result[1]);
                        var k = 0;
                        jQuery.each(split_val, function(i, val) {
                            var j = 0;
                            jQuery('.prd_section .prd-attribute').each(function() {
                                j++;
                                var prd_attribute_id = jQuery(this).attr('id');
                                var prd_attribute_int_id = jQuery.trim(prd_attribute_id.substr(prd_attribute_id.lastIndexOf("_") + 1));
                                var attribute_value = jQuery('#prd_att_' + prd_attribute_int_id + " span.prd_attribute_value").attr('id');
                                var attribute_name = jQuery('#prd_att_' + prd_attribute_int_id + " span.prd_attribute_name").attr('id');

                                jQuery.each(JSON.parse(curr_fetch_att_name), function(opt_att_name, opt_att_value) {
                                    opt_att_value = jQuery.trim(opt_att_value);
                                    var array_opt_att_value = opt_att_value.split(",");
                                    if (attribute_name == opt_att_name && array_opt_att_value.includes(attribute_value)) {
                                        jQuery('.prd_section').find('#prd_att_' + prd_attribute_int_id).addClass('prd-positive-attr').removeClass('prd-neutral-attr');
                                    }
                                    if (attribute_name == opt_att_name && !array_opt_att_value.includes(attribute_value) && prd_attribute_int_id != val) {
                                        jQuery('.prd_section').find('#prd_att_' + prd_attribute_int_id).addClass('prd-negative-attr').removeClass('prd-neutral-attr');
                                    }
                                    jQuery('.prd_section').find('#prd_att_').addClass('prd-neutral-attr').removeClass('prd-negative-attr');
                                    jQuery('.prd_section').find('#prd_att_').addClass('prd-neutral-attr').removeClass('prd-positive-attr');
                                    if (attribute_name != opt_att_name) {
                                        //jQuery('.prd_section').find('#prd_att_').addClass('prd-neutral-attr').removeClass('prd-negative-attr');
                                        //jQuery('.prd_section').find('#prd_att_').addClass('prd-neutral-attr').removeClass('prd-positive-attr');
                                    }
                                })

//                                if (prd_attribute_int_id == val) {
//                                    //if (attribute_value == curr_fetch_att_value && attribute_name == curr_fetch_att_name) {
//                                    //alert('id');
//                                    jQuery('.prd_section').find('#prd_att_' + prd_attribute_int_id).addClass('prd-positive-attr').removeClass('prd-neutral-attr');
//                                    //}
//                                } else {
//                                    jQuery.each(JSON.parse(curr_fetch_att_name), function(opt_att_name, opt_att_value) {
//                                        //alert(attribute_name + " == " + opt_att_name + " && " + attribute_value + " == " + opt_att_value);
//                                        if (attribute_name == opt_att_name && attribute_value != opt_att_value) {
//                                            //alert('second else if');
//                                            jQuery('.prd_section').find('#prd_att_' + prd_attribute_int_id).addClass('prd-negative-attr').removeClass('prd-neutral-attr');
//                                        }
//                                    })
//                                    //alert('else ' + attribute_value + " != " + curr_fetch_att_value + "  " + attribute_name + " == " + curr_fetch_att_name);
////                                    if (attribute_name == curr_fetch_att_name) {
////                                        if (attribute_value != curr_fetch_att_value) {
////                                            jQuery('.prd_section').find('#prd_att_' + prd_attribute_int_id).addClass('prd-negative-attr').removeClass('prd-neutral-attr');
////                                        }
////                                    }
//
//                                }
                            });
                            k++;
                        });
                        jQuery('.prd_section').each(function() {
                            var prd_attribute_id = jQuery(this).attr('id');
                            var prd_attribute_int_id = jQuery.trim(prd_attribute_id.substr(prd_attribute_id.lastIndexOf("_") + 1));

                            var negative_value = jQuery('#prd_' + prd_attribute_int_id).find('div.prd-negative-attr').sort(sortMe);
                            var neutral_value = jQuery('#prd_' + prd_attribute_int_id).find('div.prd-neutral-attr').sort(sortMe);

                            function sortMe(a, b) {
                                return a.className < b.className;
                            }

                            jQuery('#prd_' + prd_attribute_int_id + ' .prd-overlay-attributes').append(negative_value);
                            jQuery('#prd_' + prd_attribute_int_id + ' .prd-overlay-attributes').append(neutral_value);
                        });
                    }
                    //alert(result[4]);
                    //alert(result[5]);
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
