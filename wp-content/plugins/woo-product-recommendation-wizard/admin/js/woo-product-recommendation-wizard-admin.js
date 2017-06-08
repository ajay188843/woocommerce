(function($) {
    'use strict';
    $(window).load(function() {
        $("#wprw_free_dialog").dialog({
            modal: true, title: 'Subscribe To Our Newsletter', zIndex: 10000, autoOpen: true,
            width: '500', resizable: false,
            position: {my: "center", at: "center", of: window},
            dialogClass: 'dialogButtons',
            buttons: [
                {
                    id: "Delete",
                    text: "YES",
                    click: function() {
                        // $(obj).removeAttr('onclick');
                        // $(obj).parents('.Parent').remove();
                        var email_id = jQuery('#txt_user_sub_wprw_free').val();
                        var data = {
                            'action': 'wp_add_plugin_userfn_free_wprw',
                            'email_id': email_id
                        };
                        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                        jQuery.post(ajaxurl, data, function(response) {
                            jQuery('#wprw_free_dialog').html('<h2>You have been successfully subscribed');
                            jQuery(".ui-dialog-buttonpane").remove();
                        });
                    }
                },
                {
                    id: "No",
                    text: "No, Remind Me Later",
                    click: function() {

                        jQuery(this).dialog("close");
                    }
                },
            ]
        });
        jQuery("div.dialogButtons .ui-dialog-buttonset button").removeClass('ui-state-default');
        jQuery("div.dialogButtons .ui-dialog-buttonset button").addClass("button-primary woocommerce-save-button");

        /*Table Sorter*/
        jQuery(".tablesorter").tablesorter({
            headers: {
                0: {
                    sorter: false
                },
                4: {
                    sorter: false
                }
            }
        });

        /*Accordian section for option section*/
        jQuery("#accordion").accordion({
            header: "> div > h3",
            collapsible: true,
            active: false,
            autoHeight: false,
            autoActivate: true,
            beforeActivate: function(event, ui) {
                // The accordion believes a panel is being opened
                if (ui.newHeader[0]) {
                    var currHeader = ui.newHeader;
                    var currContent = currHeader.next('.ui-accordion-content');
                    // The accordion believes a panel is being closed
                } else {
                    var currHeader = ui.oldHeader;
                    var currContent = currHeader.next('.ui-accordion-content');
                }
                // Since we've changed the default behavior, this detects the actual status
                var isPanelSelected = currHeader.attr('aria-selected') == 'true';
                // Toggle the panel's header
                currHeader.toggleClass('ui-corner-all', isPanelSelected).toggleClass('accordion-header-active ui-state-active ui-corner-top', !isPanelSelected).attr('aria-selected', ((!isPanelSelected).toString()));
                // Toggle the panel's icon
                currHeader.children('.ui-icon').toggleClass('ui-icon-triangle-1-e', isPanelSelected).toggleClass('ui-icon-triangle-1-s', !isPanelSelected);
                // Toggle the panel's content
                currContent.toggleClass('accordion-content-active', !isPanelSelected)
                if (isPanelSelected) {
                    currContent.slideUp();
                } else {
                    currContent.slideDown();
                }

                return false; // Cancels the default action
            }
        });
        jQuery("#accordion").sortable({
            axis: "y",
            handle: "h3",
            items: "div",
            receive: function(event, ui) {
                jQuery(ui.item).removeClass();
                jQuery(ui.item).removeAttr("style");
                jQuery("#accordion").accordion("add", "<div>" + ui.item.hmtl() + "</div>");
            }
        });

        /*Check all checkbox wizard*/
        jQuery('body').on('click', '#chk_all_wizard', function(e) {
            jQuery('input.chk_single_wizard:checkbox').not(this).prop('checked', this.checked);
        });

        /*Get all checkbox checked value*/
        jQuery('body').on('click', '#detete_all_selected_wizard', function(e) {
            var selected_wizard_arr = [];
            jQuery.each(jQuery("input[name='chk_single_wizard_chk']:checked"), function() {
                selected_wizard_arr.push(jQuery(this).val());
            });
            var selected_wizard = selected_wizard_arr;//.join(", ")
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: "delete_selected_wizard_using_checkbox",
                    selected_wizard_id: selected_wizard
                },
                success: function(response) {
                    if (response == 'true') {
                        jQuery.each(selected_wizard, function(index, value) {
                            jQuery('#wizard_row_' + value).remove();
                        });
                    } else {

                    }
                }
            });
        });

        /*Check all checkbox wizard*/
        jQuery('body').on('click', '#chk_all_question', function(e) {
            jQuery('input.chk_single_question:checkbox').not(this).prop('checked', this.checked);
        });

        /*Get all checkbox checked value*/
        jQuery('body').on('click', '#detete_all_selected_question', function(e) {
            var selected_question_arr = [];
            jQuery.each(jQuery("input[name='chk_single_question_name']:checked"), function() {
                selected_question_arr.push(jQuery(this).val());
            });
            var selected_question = selected_question_arr;//.join(", ")
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: "delete_selected_question_using_checkbox",
                    selected_question_id: selected_question
                },
                success: function(response) {
                    if (response == 'true') {
                        jQuery.each(selected_question, function(index, value) {
                            jQuery('#after_updated_question_' + value).remove();
                        });
                    } else {

                    }
                }
            });
        });

        /*Add new options*/
        jQuery('body').on('click', '#add_new_options', function() {
            var fetchOptionLabel = JSON.parse(optionLabelDetails.option_label);
            var fetchOptionLabelDescription = JSON.parse(optionLabelDetails.option_lable_description);
            var fetchOptionLabelPlaceholder = JSON.parse(optionLabelDetails.option_lable_placeholder);
            var fetchOptionImageLabel = JSON.parse(optionLabelDetails.option_image_lable);
            var fetchOptionImageSelectFile = JSON.parse(optionLabelDetails.option_image_select_file);
            var fetchOptionImageUploadImage = JSON.parse(optionLabelDetails.option_image_upload_image);
            var fetchOptionImageRemoveImage = JSON.parse(optionLabelDetails.option_image_remove_image);
            var fetchOptionImageDescription = JSON.parse(optionLabelDetails.option_image_description);
            var fetchOptionAttributeLabel = JSON.parse(optionLabelDetails.option_attribute_lable);
            var fetchOptionAttributeDescription = JSON.parse(optionLabelDetails.option_attribute_description);
            var fetchOptionAttributePlaceholder = JSON.parse(optionLabelDetails.option_attribute_placeholder);
            var fetchOptionValueLabel = JSON.parse(optionLabelDetails.option_value_lable);
            var fetchOptionValueDescription = JSON.parse(optionLabelDetails.option_value_description);
            var fetchOptionValuePlaceholder = JSON.parse(optionLabelDetails.option_value_placeholder);
            var total_count_options = jQuery('.options_rank_class').length;

            var fetchAllAttributeName = JSON.parse(all_attribute_name.attributeArray);
            var x = +total_count_options + +1;
            var option_title = 'Options Configuration ' + x + '';
            var append_new_row = ''
            append_new_row += '<div class="options_rank_class" id="options_rank_' + x + '">';
            append_new_row += '<input type="hidden" name="options_id[][' + x + ']" value="' + x + '">';
            append_new_row += '<h3>' + option_title + '</h3>';
            append_new_row += '<div>';
            append_new_row += '<table class="form-table table-outer product-fee-table" id="option_section">';
            append_new_row += '<tbody>';
            append_new_row += '<tr valign="top">';
            append_new_row += '<th class="titledesc" scope="row">';
            append_new_row += '<label for="options_name">' + fetchOptionLabel + '<span class="required-star">*</span></label>';
            append_new_row += '</th>';
            append_new_row += '<td class="forminp mdtooltip">';
            append_new_row += '<input type="text" name="options_name[][' + x + ']" class="text-class" id="options_name_id_' + x + '" value="" required="1" placeholder="' + fetchOptionLabelPlaceholder + '">';
            append_new_row += '<span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>';
            append_new_row += '<p class="description">' + fetchOptionLabelDescription + '</p>';
            append_new_row += '</td>';
            append_new_row += '</tr>';
            append_new_row += '<tr valign="top">';
            append_new_row += '<th class="titledesc" scope="row">';
            append_new_row += '<label for="options_image">' + fetchOptionImageLabel + '</label>';
            append_new_row += '</th>';
            append_new_row += '<td class="forminp mdtooltip option_image_section">';
            append_new_row += '<div class="product_cost_left_div">';
            append_new_row += '<a class="option_single_upload_file button" id="option_single_upload_file_id_' + x + '" uploader_title="' + fetchOptionImageSelectFile + '" uploader_button_text="Include File">' + fetchOptionImageUploadImage + '</a>';
            append_new_row += '<a class="option_single_remove_file button" id="option_single_remove_file_id_' + x + '" >' + fetchOptionImageRemoveImage + '</a>';
            append_new_row += '<span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>';
            append_new_row += '<p class="description">' + fetchOptionImageDescription + '</p>';
            append_new_row += '</div>';
            append_new_row += '<div class="option_image_div">';
            append_new_row += '<img class="option_single_image_src" id="option_single_image_src_id_' + x + '" name="option_single_image_name[][' + x + ']" style="display:none;" src="" width="250px" height="100px"/>';
            append_new_row += '<input type="hidden" name="hf_option_single_image_src[][' + x + ']" id="hf_option_single_image_src_' + x + '" value="">';
            append_new_row += '</div>';
            append_new_row += '</td>';
            append_new_row += '</tr>';
            append_new_row += '<tr valign="top">';
            append_new_row += '<th class="titledesc" scope="row">';
            append_new_row += '<label for="attribute_name">' + fetchOptionAttributeLabel + '</label>';
            append_new_row += '</th>';
            append_new_row += '<td class="forminp mdtooltip">';
            append_new_row += '<select id="attribute_name_' + x + '" data-placeholder="' + fetchOptionAttributePlaceholder + '" name="attribute_name[][' + x + ']" class="chosen-select-attribute-value category-select chosen-rtl">';
            append_new_row += '<option value=""></option>';
            jQuery.each(fetchAllAttributeName, function(index, value) {
                append_new_row += '<option value="' + jQuery.trim(value) + '">' + jQuery.trim(value) + '</option>';
            });
            append_new_row += '</select>';
            append_new_row += '<span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>';
            append_new_row += '<p class="description">' + fetchOptionAttributeDescription + '</p>';
            append_new_row += '</td>';
            append_new_row += '</tr>';
            append_new_row += '<tr valign="top">';
            append_new_row += '<th class="titledesc" scope="row">';
            append_new_row += '<label for="attributr_value">' + fetchOptionValueLabel + '</label>';
            append_new_row += '</th>';
            append_new_row += '<td class="forminp mdtooltip">';
            append_new_row += '<select id="attribute_value_' + x + '" data-placeholder="' + fetchOptionValuePlaceholder + '" name="attribute_value[][' + x + ']" multiple="true" class="chosen-select-attribute-value category-select chosen-rtl">';
            append_new_row += '</select>';
            append_new_row += '<span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>';
            append_new_row += '<p class="description">' + fetchOptionValueDescription + '</p>';
            append_new_row += '</td>';
            append_new_row += '</tr>';
            append_new_row += '</tbody>';
            append_new_row += '</table>';
            append_new_row += '</div></div>';
            jQuery('#submit_options').before(append_new_row);
            jQuery('#accordion').accordion("refresh");
            jQuery('.accordian_custom_class:last select').chosen();

            jQuery('body').on('change', '#attribute_name_' + x, function(e) {
                var attribute_name = jQuery(this).val();
                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: "get_attributes_value_based_on_attribute_name",
                        attribute_name: attribute_name
                    },
                    success: function(response) {
                        //alert(response);
                        jQuery("#attribute_value_" + x).html(response);
                        jQuery("#attribute_value_" + x).trigger('chosen:updated');
                    }
                });
            });
        });

        /* description toggle */
        jQuery('body').on('click', 'span.woocommerce_wprw_tab_descirtion', function() {
            var data = jQuery(this);
            jQuery(this).next('p.description').toggle();
        });

        jQuery("#custom_pagination a").live('click', function(e) {
            e.preventDefault();
            var pageNum = this.id;
            var parts = pageNum.split('_');
            var wizard_id = parts[1];
            var numRecords = parts[3];
            var pageNum = parts[5];
            //alert(wizard_id + " " + pageNum + " " + numRecords);
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: "get_question_list_with_pagination",
                    wizard_id: wizard_id,
                    pagenum: pageNum,
                    limit: numRecords
                },
                success: function(response) {
                    //alert(response);
                    jQuery("#using_ajax").html(response);
                }
            });
        });

        function displayRecords(wizard_id, numRecords, pageNum) {
            //alert(wizard_id + " " + numRecords + " " + pageNum);
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: "get_question_list_with_pagination",
                    wizard_id: wizard_id,
                    pagenum: pageNum,
                    limit: numRecords
                },
                success: function(response) {
                    //alert(response);
                    jQuery("#using_ajax").html(response);
                }
            });
        }

        function getUrlVars()
        {
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for (var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        }

        jQuery(document).ready(function(e) {
            var url_parameters = getUrlVars();
            var current_wizard_id = url_parameters['wrd_id'];
            displayRecords(current_wizard_id, 5, 1);
        });

        /*Attribute value*/
        var configattributevalue = {
            '.chosen-select-attribute-value': {},
            '.chosen-select-deselect': {allow_single_deselect: true},
            '.chosen-select-no-single': {disable_search_threshold: 10},
            '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
        }
        for (var selectorattributevalue in configattributevalue) {
            $(selectorattributevalue).chosen(configattributevalue[selectorattributevalue]);
        }

        var fetchAllAttributeValuID = JSON.parse(option_value_id.OptionValueIDArray);
        jQuery.each(fetchAllAttributeValuID, function(index, value) {
            var option_id = value.substr(value.lastIndexOf("_") + 1);
            /*Attribute Option Section*/
            var settingObj = window["allAttributeValue" + option_id];
            var selectedAttributeOptionsArray1 = settingObj.attributeOptionArray;
            var selectedttributeOptionsglobalarr1 = [];
            for (var j in selectedAttributeOptionsArray1) {
                selectedttributeOptionsglobalarr1.push(selectedAttributeOptionsArray1[j]);
            }
            var attributeString1 = '';
            attributeString1 = selectedttributeOptionsglobalarr1.join(",");
            //alert(attributeString1);
            if (attributeString1 != '') {
                jQuery.each(attributeString1.split(","), function(i, e) {
                    jQuery("#attribute_value_" + option_id + " option[value='" + jQuery.trim(e) + "']").prop("selected", true);
                    jQuery("#attribute_value_" + option_id).trigger('chosen:updated');
                });
            }

            /*Attribute Name Section*/
            var settingObj = window["allAttributename" + option_id];
            var selectedAttributeNameArray1 = settingObj.attributeAttributeArray;
            if (selectedAttributeNameArray1 != '') {
                jQuery("#attribute_name_" + option_id + " option[value='" + jQuery.trim(selectedAttributeNameArray1) + "']").prop("selected", true);
                jQuery("#attribute_name_" + option_id).trigger('chosen:updated');
            }

            /*Attribute Name Chosen Section (Using Ajax)*/
            jQuery('body').on('change', '#attribute_name_' + option_id, function(e) {
                var attribute_name = jQuery(this).val();
                var chosen_id = jQuery(this).attr('id');
                var chosen_int_id = chosen_id.substr(chosen_id.lastIndexOf("_") + 1);
                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: "get_attributes_value_based_on_attribute_name",
                        attribute_name: attribute_name
                    },
                    success: function(response) {
                        //alert(response);
                        jQuery("#attribute_value_" + chosen_int_id).html(response);
                        jQuery("#attribute_value_" + chosen_int_id).trigger('chosen:updated');
                    }
                });
            });
        });

        /*Add css for chosen select*/
        jQuery('body').on('click', '.chosen-container-multi', function(e) {
            if (jQuery('.chosen-container-multi').hasClass("chosen-container-active")) {
                jQuery('.chosen-container-multi .chosen-drop').css("position", "relative");
            }
            e.stopPropagation();
        });
        jQuery(document).click(function() {
            jQuery('.chosen-container .chosen-drop').css("position", "absolute");
        });

        /*Remove option data from ajax*/
        jQuery('body').on('click', '.remove_option_row', function(e) {
            var confrim = confirm("Remove this option?");
            if (confrim == true) {
                var remove_option_id = jQuery(this).attr('id');
                var remove_option_int_id = remove_option_id.substr(remove_option_id.lastIndexOf("_") + 1);
                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: "remove_option_data_from_option_page",
                        option_id: remove_option_int_id
                    },
                    success: function(response) {
                        if (response == '1') {
                            jQuery('#options_rank_' + remove_option_int_id).remove();
                        } else {
                            alert('Something error');
                        }
                    }
                });
            } else {
                return false;
            }
        });

        /*Upload image in option*/
        jQuery('.option_single_upload_file').live('click', function(event) {
            var id = jQuery(this).attr('id');
            var int_id = id.substr(id.lastIndexOf("_") + 1);
            event.preventDefault();
            var file_frame;
            /*If the media frame already exists, reopen it.*/
            if (file_frame) {
                file_frame.open();
                return;
            }

            /*Create the media frame.*/
            file_frame = wp.media.frames.file_frame = wp.media({
                title: jQuery(this).data('uploader_title'),
                button: {
                    text: jQuery(this).data('uploader_button_text'),
                },
                multiple: false
            });
            file_frame.on('select', function() {
                var attachment = file_frame.state().get('selection').first().toJSON();
                jQuery('#option_single_image_src_id_' + int_id).attr('src', attachment.url);
                jQuery('#hf_option_single_image_src_' + int_id).val(attachment.url);
                jQuery('#option_single_image_src_id_' + int_id).css('display', 'block');
            });
            file_frame.open();
        });

        /*Remove image from option*/
        jQuery('.option_single_remove_file').live('click', function(event) {
            var id = jQuery(this).attr('id');
            var int_id = id.substr(id.lastIndexOf("_") + 1);
            jQuery('#option_single_image_src_id_' + int_id).attr('src', '');
            jQuery('#option_single_image_src_id_' + int_id).css('display', 'none');
        });
    });


})(jQuery);
