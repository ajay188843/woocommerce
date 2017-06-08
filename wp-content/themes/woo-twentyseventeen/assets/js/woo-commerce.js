/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function () {
jQuery(".woocommerce").on("change",'.qty', function () {
        var upd_cart_btn = jQuery("input[name=update_cart]");
        upd_cart_btn.hide();
       jQuery(".qty").mouseout(function (){ upd_cart_btn.trigger("click"); }); 
    });
    jQuery("#copon_messege1").hide();
    jQuery("#ajax-coupon-redeem").on("click", function () {
        var code = jQuery('input#coupon').val();
        jQuery.ajax({
            type: "POST",
            datatype: "json",
            url: woocommerce_params.ajax_url,
            data: {action: "spyr_coupon_redeem_handler", coupon_code: code},
            success: function (returned_data) {
                jQuery("#copon_messege1").show();
                jQuery("#copon_messege1").html('&#9745;' + ' ' + returned_data['message']);
                jQuery('input#coupon').val('');
                console.log(returned_data);

            }
        });
    });

});
function ajax_for_coupon() {
    //jQuery( '#ajax-coupon-redeem input[type="submit"]').on('click', function() {
    // Get the coupon code
    var code = jQuery('input#coupon').val();
    jQuery.ajax({
        type: "POST",
        datatype: "json",
        url: woocommerce_params.ajax_url,
        data: {action: "spyr_coupon_redeem_handler", coupon_code: code},
        success: function (returned_data) {
            jQuery(".woocommerce-message").html(returned_data['message']);
            jQuery('input#coupon').val('');
            // update_wc_div( returned_data, preserve_notices );
        }
    });

    // We are going to send this for processing
//        data = {
//            action: 'spyr_coupon_redeem_handler',
//            coupon_code: code
//        }

    // Send it over to WordPress.
//        jQuery.post( woocommerce_params.ajax_url, data, function( returned_data ) {
//            if( returned_data.result == 'error' ) {
//                jQuery( 'p.result' ).html( returned_data.message );
//            } else {
//                // Hijack the browser and redirect user to cart page
//                window.location.href = returned_data.href;
//            }
//        })

    // Prevent the form from submitting
    // ev.preventDefault();
    //  }); 
}
function reviewdisplay() {
    jQuery("#review_form_wrapper").toggle();
}
