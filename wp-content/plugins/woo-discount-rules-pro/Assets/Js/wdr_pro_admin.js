/* global jQuery, ajaxurl, wdr_data */
(function ($) {
    $(document).ready(function () {

        $( ".awdr-product-discount-type" ).on( "advanced_woo_discount_rules_on_change_adjustment_type", function ( e, value ) {
            var data_placement = $(this).data('placement');
            if(value == 'wdr_buy_x_get_x_discount'){
                $('.' + data_placement).find('.buyx_getx_range_group').addClass('buyx_getx_range_setter').attr('id', 'bulk_adjustment_sortable');
                $('.awdr-filter-content').html(wdr_data.localization_data.bogo_buyx_getx_filter_description);
                $('.awdr-discount-heading').html(wdr_data.localization_data.two_column_bxgx_discount_heading);
                $('.awdr-discount-content').html(wdr_data.localization_data.bogo_buyx_getx_discount_content);
                $('.awdr-rules-content').html(wdr_data.localization_data.common_rules_description);
            }
            if(value == "wdr_buy_x_get_y_discount"){
                $('.' + data_placement).find('.awdr_buyx_gety_range_group').addClass('awdr_buyx_gety_range_setter').attr('id', 'bulk_adjustment_sortable');
                $('.awdr-filter-heading').html(wdr_data.localization_data.bogo_buyx_gety_filter_heading);
                $('.awdr-filter-content').html(wdr_data.localization_data.bogo_buyx_gety_filter_description);
                $('.awdr-discount-heading').html(wdr_data.localization_data.two_column_bxgy_discount_heading);
                $('.awdr-discount-content').html(wdr_data.localization_data.bogo_buyx_gety_discount_content);
                $('.awdr-rules-content').html(wdr_data.localization_data.common_rules_description);
                let wdr_buy_x_get_y_type = $('.select_bxgy_type option:selected').val();
                if(wdr_buy_x_get_y_type == 0){
                    $('.bxgy_type_selected').hide();
                    $('.bxgy_category').hide();
                    $('.bxgy_product').hide();
                }
                $(".select_bxgy_type").trigger('change');
            }
           /* $('#bulk_adjustment_sortable').sortable();*/

            var isMobile = false;
            if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
                || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
                isMobile = true;
            }

            if($(window).width() > 1024){
                if(isMobile == true){
                    $('#bulk_adjustment_sortable').sortable({
                        handle: ".awdr-sortable-handle",
                    });
                }else{
                    $('#bulk_adjustment_sortable').sortable();
                }
            }else{
                $('#bulk_adjustment_sortable').sortable({
                    handle: ".awdr-sortable-handle",
                });
            }

            $("#bulk_adjustment_sortable").disableSelection();
            if(value == 'wdr_free_shipping'){
                $('.awdr-hidden-new-rule').fadeIn(500);
                $('.awdr-general-settings-section').fadeIn(500);
                $("button.wdr_save_stay, button.wdr_save_close").attr("disabled", false).css("cursor", "pointer");
                $('.' + data_placement).html('');
                $('.awdr-discount-container').hide();
            }
        });
        $(".awdr-product-discount-type").trigger('change');
        $(".buyx_gety_discount_select").trigger('change');
        $(document).on('change', '.select_bxgy_type', function () {
            $('.awdr-discount-content').html(wdr_data.localization_data.bogo_buyx_gety_discount_content_for_product);
            var adjustment_mode = $('input[name="buyx_gety_adjustments[mode]"]:checked').val();
            if($(this).val() == 'bxgy_product'){
                if(adjustment_mode === undefined){
                    $("input[value='auto_add']").prop("checked", true);
                }
                $('.bxgy-icon').removeClass('awdr-bygy-all');
                $('.bxgy-icon').removeClass('awdr-bygy-cat-products');
                $('.bxgy-icon').addClass('awdr-bygy-cat-products');
                $('.auto_add').show();
                $('.bxgy_product').show();
                $('.bxgy_category').hide();
                $('.bxgy_type_selected').show();
                $('.awdr-example').show();
            }else if($(this).val() == 'bxgy_category'){
                $('.awdr-discount-content').html(wdr_data.localization_data.bogo_buyx_gety_discount_content_for_category);
                $('.auto_add').hide();
                if(adjustment_mode === undefined || adjustment_mode == 'auto_add'){
                    $("input[value='cheapest']").prop("checked", true);
                }
                $('.bxgy-icon').removeClass('awdr-bygy-all');
                $('.bxgy-icon').removeClass('awdr-bygy-cat-products');
                $('.bxgy-icon').addClass('awdr-bygy-cat-products');
                $('.bxgy_product').hide();
                $('.bxgy_category').show();
                $('.bxgy_type_selected').show();
                $('.awdr-example').show();
            }else if($(this).val() == 'bxgy_all'){
                $('.awdr-discount-content').html(wdr_data.localization_data.bogo_buyx_gety_discount_content_for_all);
                $('.auto_add').hide();
                if(adjustment_mode === undefined || adjustment_mode == 'auto_add'){
                    $("input[value='cheapest']").prop("checked", true);
                }
                $('.bxgy-icon').removeClass('awdr-bygy-cat-products');
                $('.bxgy-icon').removeClass('awdr-bygy-all');
                $('.bxgy-icon').addClass('awdr-bygy-all');
                $('.bxgy_type_selected').show();
                $('.bxgy_product').hide();
                $('.bxgy_category').hide();
                $('.awdr-example').show();
            }else{
                $('.awdr-discount-content').html(wdr_data.localization_data.bogo_buyx_gety_discount_content);
                $('.awdr-example').hide();
                $('.bxgy_type_selected').hide();
                $('.bxgy_category').hide();
                $('.bxgy_product').hide();
            }
        });

        $(document).on("click", "#validate_licence_key", function() {
            var licence_key = $("#awdr_licence_key").val();
            var awdr_nonce = $(this).attr('data-awdr_nonce');
            var data = {
                action: 'awdr_validate_licence_key',
                licence_key: licence_key,
                awdr_nonce: awdr_nonce,
            };
            $("#validate_licence_key").val(woo_discount_pro_localization.validating_please_wait);
            $.ajax({
                url: ajaxurl,
                data: data,
                type: 'POST',
                success: function (response) {
                    if(response.success == true){
                        if(response.data.message !== undefined){
                            $('.validate_licence_key_status').html(response.data.message);
                        }
                    }
                    $("#validate_licence_key").val(woo_discount_pro_localization.validate);
                },
                error: function (response) {
                    $("#validate_licence_key").val(woo_discount_pro_localization.validate);
                },
                complete: function (response) {
                    $("#validate_licence_key").val(woo_discount_pro_localization.validate);
                },
            });
        });
        /**
         * condition
         * show otr hide product combination 'to' filed
         */
        $(document).on('change', '.combination_operator', function () {
            if ($(this).val() == 'in_range') {
                $('.product_combination_to').show();
                $('.product_combination_from_placeholder').attr("placeholder", "From");
            } else {
                $('.product_combination_to').hide();
                $('.product_combination_from_placeholder').attr("placeholder", "Quantity");
            }
        });
        /**
         * condition
         * show otr hide Category combination 'to' filed
         */
        $(document).on('change', '.cat_combination_operator', function () {
            if ($(this).val() == 'in_range') {
                $('.cat_combination_to').show();
                $('.cat_combination_from_placeholder').attr("placeholder", "From");
            } else {
                $('.cat_combination_to').hide();
                $('.cat_combination_from_placeholder').attr("placeholder", "Value");
            }
        });

        $(document).on('change', '.awdr-email-condition-eg-text', function () {
            let email_condition = $(this).val();
            if( email_condition == 'user_email_tld'){
                $(this).parents('.wdr_user_email_group').find('.awdr_user_email_tld').show();
                $(this).parents('.wdr_user_email_group').find('.awdr_user_email_domain').hide();
            } else if(email_condition == 'user_email_domain'){
                $(this).parents('.wdr_user_email_group').find('.awdr_user_email_tld').hide();
                $(this).parents('.wdr_user_email_group').find('.awdr_user_email_domain').show();
            }
        })
        $('.awdr-email-condition-eg-text').trigger('change');

    });
})(jQuery);